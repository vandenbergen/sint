using System;
using System.Collections;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Services;
using System.Xml;
using System.Xml.Linq;

namespace ConversionService
{
    /// <summary>
    /// This Service converts the amount of one currency to an other currency. Exchange rates are taken from ECB.
    /// </summary>
    ///
    [WebService(Namespace = "http://10.27.1.27/")]
    [WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    [System.ComponentModel.ToolboxItem(false)]
    // To allow this Web Service to be called from script, using ASP.NET AJAX, uncomment the following line. 
    [System.Web.Script.Services.ScriptService]
    public class ConversionService : System.Web.Services.WebService
    {

        [WebMethod]
        public double ConvertPrice(string sourceCurrency, double sourcePrice, string targetCurrency)
        {
            Hashtable currencies = new Hashtable();
            double sourceRate = 0;
            double targetRate = 0;
            double targetPrice = 0;
            bool sourceEUR = false;
            string m_strFilePath = "http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
            XmlDocument doc = new XmlDocument();
            doc.Load(m_strFilePath);

            XmlReader rdr = XmlReader.Create(new System.IO.StringReader(doc.InnerXml.ToString()));
            while (rdr.Read()) 
            {
                if (rdr.Name.Equals("Cube") && rdr.NodeType == XmlNodeType.Element) 
                { 
                    if(rdr.AttributeCount == 2) 
                    {
                        currencies.Add(rdr.GetAttribute("currency"), rdr.GetAttribute("rate"));
                    }
                }
            }

            sourceCurrency = sourceCurrency.ToUpper();
            targetCurrency = targetCurrency.ToUpper();
            
            if (sourceCurrency.Equals("EUR"))
            {
                if (targetCurrency.Equals("EUR"))
                {
                    targetPrice = sourcePrice;
                }
                else
                {
                    targetRate = double.Parse(currencies[targetCurrency].ToString(), System.Globalization.CultureInfo.InvariantCulture);
                    targetPrice = sourcePrice * targetRate;
                }
            }
            else
            {
                sourceRate = double.Parse(currencies[sourceCurrency].ToString(), System.Globalization.CultureInfo.InvariantCulture);
                if (targetCurrency.Equals("EUR"))
                {
                    targetPrice = sourcePrice / sourceRate;
                }
                else
                {
                    targetRate = double.Parse(currencies[targetCurrency].ToString(), System.Globalization.CultureInfo.InvariantCulture);
                    double eurprice = sourcePrice / sourceRate;
                    targetPrice = eurprice * targetRate;
                }
            }
            
            return targetPrice;
        }
    }
}