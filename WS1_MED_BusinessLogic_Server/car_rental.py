#!/usr/bin/env python
#
# Author: Markus Edelhofer
#

#imports the web.py module
import web
import json
#Import inbulit sqlite db
import sqlite3
import xml.etree.ElementTree as ET
from datetime import datetime
import time
from pysimplesoap.client import SoapClient

def notfound():
   return json.dumps({'ok':0, 'errcode': 404})

def internalerror():
   return json.dumps({'ok':0, 'errcode': 500})

#------------------------------------------------------------------------------#
# rewrite output to JSON
def cus_out(output):

   output = output[:-1]
   output += ']}'
   output = output.replace("<Storage" , "");
   output = output.replace(">" , "");
   output = output.replace(" u'" , " '");
   output = output.replace("'" , "\"");
   return output

#------------------------------------------------------------------------------#
# SOAP Request
def soap_req(sC,sP,tC):
   try:
      client = SoapClient(wsdl="http://remote.makas.at/ConversionService.asmx?wsdl" )
      response = client.ConvertPrice(sourceCurrency=sC,sourcePrice=sP,targetCurrency=tC)
      return tC, response['ConvertPriceResult']
   except:
      return sC, sP

#------------------------------------------------------------------------------#
# set the car state in rent
def set_rent_state():
   date_format = "%Y-%m-%d"
   date_today = datetime.now()

   rental = list(db.select('rental', vars=locals()))
   for i in range(len(rental)):
      date_from = datetime.strptime(rental[i]["date_from"], date_format)
      date_to = datetime.strptime(rental[i]["date_to"], date_format)
      #id = str(rental["rental"][i]["id"])
      id = i + 1

      if date_from <= date_today:
         if date_to >= date_today:
            db.update('rental', where="id = $id", state=0, vars=locals())
         else:
            db.update('rental', where="id = $id", state=1, vars=locals())
      else:
         db.update('rental', where="id = $id", state=1, vars=locals())


#------------------------------------------------------------------------------#
#db = web.database(dbn='sqlite', db='car_rental.db')
db = web.database(dbn='sqlite', db='/var/www/html/sint/car_rental.db')

render = web.template.render('templates/')

urls = (
   '/', 'index',
   '/cars', 'show_cars',
   '/cars/(.*)', 'show_car',
   '/rent', 'rent',
   '/rent/(.*)', 'rent',
   '/customers', 'customers',
   '/customers/(.*)/rent', 'show_customers_rent',
   '/customers/(.*)', 'customer',
   '/countries', 'show_countries',
   '/locations', 'show_locations',
   '/locations/(.*)', 'show_locations_cars'
)

app = web.application(urls, globals())

class index:
   def GET(self):
      ctype = 'text/html'
      output = '''<!doctype html>
<html lang="en">
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>SINT 2014</title>
 </head>
 <body>
  <h1 align="center">Wellcome to REST Cars Rental Webservice</h1>
  <h2 align="center">FH Technikum-Wien - 2014 - SINT</h2>
  <p align="center">Output: JSON<br>use:</p>
  <p align="left">GET &nbsp; <a href="/cars">/cars</a> &nbsp;&nbsp;&nbsp; ... &nbsp; show all cars<br>
  GET &nbsp; <a href="/cars/">/cars/</a>&lt;id&gt; &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show single car<br>
  GET &nbsp; <a href="/rent">/rent</a> &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show all rents<br>
  PUT &nbsp; /rent &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; rent a car<br>
  POST &nbsp; /rent &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; rent a car<br>
  GET &nbsp; <a href="/customers">/customers</a> &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show all customers<br>
  PUT &nbsp; /customers &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; add a new customer<br>
  POST &nbsp; /customers &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; add a new customer<br>
  GET &nbsp; <a href="/customers/">/customers/</a>&lt;id&gt; &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show single customer<br>
  PUT &nbsp; /customers/&lt;id&gt; &nbsp;&nbsp;&nbsp;&nbsp; ... change a customer<br>
  POST &nbsp; /customers/&lt;id&gt; &nbsp;&nbsp;&nbsp;&nbsp; ... change a customer<br>
  DELETE &nbsp; /customers/&lt;id&gt; &nbsp;&nbsp;&nbsp;&nbsp; ... del customer<br>
  GET &nbsp; /customers/&lt;id&gt/rent &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show rents from customer<br>
  GET &nbsp; <a href="/countries">/countries</a> &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show all countries<br>
  GET &nbsp; <a href="/locations">/locations</a> &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show all locations<br>
  GET &nbsp; <a href="/locations/">/locations/</a>&lt;id&gt &nbsp;&nbsp;&nbsp;&nbsp; ... &nbsp; show cars per location</p>
  <div style="position:absolute; bottom:0; height:7px;">
   <p align="center">Author: Markus Edelhofer</p>
  </div>
 </body>
</html>'''
      status = '200 OK'
      web.header('Content-type', 'text/html')
      return output

#------------------------------------------------------------------------------#
# Show all Cars
class show_cars:
   def GET(self):
      set_rent_state()
      cars = list(db.select('cars', order="id ASC" , vars=locals()))
      output = '{"cars":['
      for i in range(len(cars)):
         j = i + 1
         rental = list(db.select('rental', where="car_id = $j", order="id ASC", vars=locals()))
         if rental:
            cars[i]["state"] = str(rental[0]["state"])
         else:
            cars[i]["state"] = "1"

         id_site = cars[i]["id_site"]
         location = list(db.select('locations', where="id = $id_site", what="city", vars=locals()))
         cars[i]["id_site"] = location[0]["city"]

         output += str(cars[i])
         output += ','
      output = cus_out(output)
      web.header('Content-type', 'application/json')
      return output

#------------------------------------------------------------------------------#
# Show sinlge Car
class show_car:
   def GET(self,id):
      if id.isnumeric():
         cars = list(db.select('cars', where="id = $id", vars=locals()))
         output = '{"cars":' 
         output += str(cars)
         output = cus_out(output)
         web.header('Content-type', 'application/json')
         return output
      else:
         output = 'no numeric id';
         return output

#------------------------------------------------------------------------------#
# show rent a car / rent a car
class rent:
   def GET(self):
      set_rent_state()
      rental = list(db.select('rental', vars=locals()))
      for i in range(len(rental)):
         cus_id = str(rental[i]["cus_id"]);
         customer = list(db.select('customers', where="id = $cus_id", what="givenname,firstname", vars=locals()))

         car_id = str(rental[i]["car_id"]);
         car = list(db.select('cars', where="id = $car_id", what="plate,brand,type,priceperday,valuta" ,vars=locals()))

         loc_id_from = str(rental[i]["loc_id_from"]);
         loc_from = list(db.select('locations', where="id = $loc_id_from", what="city", vars=locals()))

         loc_id_to = str(rental[i]["loc_id_to"]);
         loc_to = list(db.select('locations', where="id = $loc_id_to", what="city", vars=locals()))

         rental[i]["cus_id"] = str(customer[0]["givenname"] + " " + customer[0]["firstname"])
         rental[i]["car_id"] = str(car[0]["plate"] + " - " + car[0]["brand"] + " " + car[0]["type"])
         rental[i]["priceperday"] = str(car[0]["priceperday"])
         rental[i]["valuta"] = str(car[0]["valuta"])
         rental[i]["loc_id_from"] = str(loc_from[0]["city"])
         rental[i]["loc_id_to"] = str(loc_to[0]["city"])

      output = '{"rent":['
      for i in range(len(rental)):
         output += str(rental[i])
         output += ','
      output = cus_out(output)
      web.header('Content-type', 'application/json')
      return output
   def PUT(self):
      input = json.loads(web.data())
      db.insert('rental', car_id = input["customers_rent"][0]["car_id"], cus_id = input["customers_rent"][0]["cus_id"], loc_id_from = input["customers_rent"][0]["loc_id_from"], loc_id_to = input["customers_rent"][0]["loc_id_to"], date_from = input["customers_rent"][0]["date_from"], date_to = input["customers_rent"][0]["date_to"], state = "0")
      id = input["customers_rent"][0]["car_id"]
      db.update('cars', where="id = $id", id_site = input["customers_rent"][0]["loc_id_to"], vars=locals())
      return "ok"
   def POST(self):
      input = json.loads(web.data())
      db.insert('rental', car_id = input["customers_rent"][0]["car_id"], cus_id = input["customers_rent"][0]["cus_id"], loc_id_from = input["customers_rent"][0]["loc_id_from"], loc_id_to = input["customers_rent"][0]["loc_id_to"], date_from = input["customers_rent"][0]["date_from"], date_to = input["customers_rent"][0]["date_to"], state = "0")
      id = input["customers_rent"][0]["car_id"]
      db.update('cars', where="id = $id", id_site = input["customers_rent"][0]["loc_id_to"], vars=locals())
      return "ok"

#------------------------------------------------------------------------------#
# show all customers / add customer
class customers:
   def GET(self):
      set_rent_state()
      customers = list(db.select('customers', order="id ASC", vars=locals()))
      output = '{"customers":['
      for i in range(len(customers)):
         token = str(customers[i]["country"]);
         countrie = list(db.select('countries',  where="token = $token", what="countries", vars=locals()));
         customers[i]["country"] = str(countrie[0]["countries"])
         output += str(customers[i]);
         output += ',';
      output = cus_out(output)
      web.header('Content-type', 'application/json')
      count = str(countrie[0]["countries"])
      return output
   def PUT(self):
      input = json.loads(web.data())
      db.insert('customers', givenname = input["customer"][0]["givenname"], firstname = input["customer"][0]["firstname"], street = input["customer"][0]["street"], city = input["customer"][0]["city"], zip = input["customer"][0]["zip"], country = input["customer"][0]["country"])
      return "ok"
   def POST(self):
      input = json.loads(web.data())
      db.insert('customers', givenname = input["customer"][0]["givenname"], firstname = input["customer"][0]["firstname"], street = input["customer"][0]["street"], city = input["customer"][0]["city"], zip = input["customer"][0]["zip"], country = input["customer"][0]["country"])
      return "ok"

#------------------------------------------------------------------------------#
# show single customers / change customer
class customer:
   def GET(self, id):
      set_rent_state()
      if id.isnumeric():
         customers = list(db.select('customers', where="id = $id", order="id ASC" , vars=locals()))
         output = '{"customer":'
         output += str(customers)
         output = cus_out(output)
         web.header('Content-type', 'application/json')
         return output
      else:
         output = 'no numeric id';
         return output
   def PUT(self, id):
      input = json.loads(web.data())
      id = input["customer"][0]["id"]
      db.update('customers', where="id = $id", givenname = input["customer"][0]["givenname"], firstname = input["customer"][0]["firstname"], street = input["customer"][0]["street"], city = input["customer"][0]["city"], zip = input["customer"][0]["zip"], country = input["customer"][0]["country"], vars=locals())
      return "ok"
   def POST(self, id):
      input = json.loads(web.data())
      id = input["customer"][0]["id"]
      db.update('customers', where="id = $id", givenname = input["customer"][0]["givenname"], firstname = input["customer"][0]["firstname"], street = input["customer"][0]["street"], city = input["customer"][0]["city"], zip = input["customer"][0]["zip"], country = input["customer"][0]["country"], vars=locals())
      return "ok"
   def DELETE(self, id):
      db.delete('customers', where="id = $id", vars=locals())
      return "DELETE"

#------------------------------------------------------------------------------#
# show rents from customer
class show_customers_rent:
   def GET(self, id):
      set_rent_state()
      if id.isnumeric():
         rental = list(db.select('rental', where="cus_id = $id", order="id ASC" , vars=locals()))
         output = '{"customers_rent":['
         for i in range(len(rental)):
            cus_id = str(rental[i]["cus_id"]);
            customer = list(db.select('customers', where="id = $cus_id", what="givenname,firstname,country", vars=locals()))

            car_id = str(rental[i]["car_id"]);
            car = list(db.select('cars', where="id = $car_id", what="plate,brand,type,priceperday,valuta" ,vars=locals()))

            loc_id_from = str(rental[i]["loc_id_from"]);
            loc_from = list(db.select('locations', where="id = $loc_id_from", what="city", vars=locals()))

            loc_id_to = str(rental[i]["loc_id_to"]);
            loc_to = list(db.select('locations', where="id = $loc_id_to", what="city", vars=locals()))

            cus_token = str(customer[0]["country"])
            sourceCurrency = str(car[0]["valuta"])
            sourcePrice = str(car[0]["priceperday"])
            targetCurrency = list(db.select('countries', where="token = $cus_token", what="valuta", vars=locals()))[0]["valuta"]
            targetCurrency, targetPrice = soap_req(sourceCurrency,sourcePrice,targetCurrency)

            rental[i]["cus_id"] = str(customer[0]["givenname"] + " " + customer[0]["firstname"])
            rental[i]["car_id"] = str(car[0]["plate"] + " - " + car[0]["brand"] + " " + car[0]["type"])
            rental[i]["priceperday"] = targetPrice
            rental[i]["valuta"] = targetCurrency
            rental[i]["loc_id_from"] = str(loc_from[0]["city"])
            rental[i]["loc_id_to"] = str(loc_to[0]["city"])
 
            output += str(rental[i])
            output += ','
         output = cus_out(output)
         web.header('Content-type', 'application/json')

         return output
      else:
         output = 'no numeric id';
         return output


#------------------------------------------------------------------------------#
# show countries / token / values
class show_countries:
   def GET(self):
      set_rent_state()
      countries = list(db.select('countries', order="id ASC" , vars=locals()))
      output = '{"countries":['
      for i in range(len(countries)):
         output += str(countries[i])
         output += ','
      output = cus_out(output)
      web.header('Content-type', 'application/json')
      return output

#------------------------------------------------------------------------------#
# show rent locations
class show_locations:
   def GET(self):
      set_rent_state()
      locations = list(db.select('locations', order="id ASC" , vars=locals()))
      output = '{"locations":['
      for i in range(len(locations)):
         token = str(locations[i]["country"]);
         j = i + 1
         cars = len(list(db.select('cars',  where="id_site = $j", vars=locals())))
         countrie = list(db.select('countries',  where="token = $token", what="countries", vars=locals()));
         locations[i]["country"] = str(countrie[0]["countries"])
         locations[i]["available"] = cars
         output += str(locations[i])
         output += ','
      output = cus_out(output)
      web.header('Content-type', 'application/json')
      return output

#------------------------------------------------------------------------------#
# show cars with location id
class show_locations_cars:
   def GET(self,id):
      set_rent_state()
      cars = list(db.select('cars', where = "id_site = $id", order="id ASC" , vars=locals()))
      output = '{"freeCars":['
      for i in range(len(cars)):
         if cars:         
            car_id = str(cars[i]["id"]);
            rental = list(db.select('rental', where="car_id = $car_id", order="id ASC", vars=locals()))
            if rental:
               cars[i]["state"] = str(rental[0]["state"])
            output += str(cars[i])
      output = cus_out(output)
      web.header('Content-type', 'application/json')
      return output

#------------------------------------------------------------------------------#
#if __name__ == "__main__":
#   app=web.application(urls, globals())
#   app.run()
application = web.application(urls, globals()).wsgifunc()
