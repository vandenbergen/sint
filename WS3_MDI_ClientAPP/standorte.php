<!DOCTYPE HTML>
<html>

<head>
  <title>Willkommen beim Mietwagenportal</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
  <script type="text/javascript" src="js/picture.js"></script>
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.html">Das <span class="logo_colour">Mietwagenportal</span></a></h1>
          <h2>Einfach. Günstig. Schnell. Sicher.</h2>
        </div>
        <form method="post" action="#" id="search">
          <input class="search" type="text" name="search_field" value="Suche....." onclick="javascript: document.forms['search'].search_field.value=''" />
          <input name="search" type="image" style="float: right;border: 0; margin: 20px 0 0 0;" src="images/search.png" alt="search" title="search" />
        </form>
      </div>
      <nav>
        <ul class="sf-menu" id="nav">
          <li class="current"><a href="index.html">Home</a></li>
          <li><a href="standorte.php">Standorte</a></li>
          <li><a href="autos.php">Autos</a></li>
          <li><a href="mitglieder.php">Mitglieder</a></li>
          <li><a href="buchungen.php">Buchungen</a>
          <li><a href="contact.php">Kontakt</a></li>
        </ul>
      </nav>
    </header>
    <div id="site_content">

	  
	  
      <div class="content">
        <h1>Standorte</h1>
        <div class="content_item">
          <h2>An folgenden Standorten bieten wir unsere Dienstleistungen an:</h2>
          <table style="width:100%; border-spacing:0;">
            <tr><th>ID</th><th>Ort</th><th>PLZ</th><th>Strasse</th><th>Land</th><th>Autos</th><th>lat</th><th>lng</th></tr>
			
			<?php
				$json = (json_decode(file_get_contents('https://gate.edelhofer.org/sint/api/locations'),true));
				
				//echo'<pre>';
				//print_r($json);
				//echo'</pre>';
				
				$google = array( array(), array(), array());
				
				// echo'<pre>';
				// print_r($google);
				// echo'</pre>';
				
				$i = 0;
				foreach ($json['locations'] as $type => $value)
				{
				
					echo '<tr>';
					echo '<td>'.$value['id'].'</td>';
					echo '<td>'.$value['city'].'</td>';
					echo '<td>'.$value['zip'].'</td>';
					echo '<td>'.$value['street'].'</td>';
					echo '<td>'.$value['country'].'</td>';
					echo '<td>'.$value['available'].'</td>';
			
					$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.$value['zip'].',+'.$value['city'].',+'.$value['street'].'&sensor=true';
					$url = str_replace(' ', '+', $url);
					
					//$json2 = (json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&sensor=true'),true));
					$json2 = (json_decode(file_get_contents($url),true));
					
					
					$str = serialize ($json2);
					$lat = substr(strstr($str, 'lat";d'),7,15);
					$lng = substr(strstr($str, 'lng";d'),7,15);
					
					echo '<td>'.$lat.'</td>';
					echo '<td>'.$lng.'</td></tr>';
					
					$google[$i][0] = $value['city'];
					$google[$i][1] = $lat;
					$google[$i][2] = $lng;
					$i = $i + 1;	
				}
				//noch das array in json
				$google = json_encode($google);
			?>
			

          </table>
			
			<script type="text/javascript">
					
					
					
					var my_json = '<?php echo $google; ?>';
					// document.write ("<br>mein json: <br> " + my_json); 
					
					var as = JSON.parse(my_json);
					// document.write ("<br>mein json mit ajax: <br> " + as); 
					
					

					function getArray(object){
						 var array = [];
						 for(var key in object){
							var item = object[key];
							array[parseInt(key)] = (typeof(item) == "object")?getArray(item):item;
						 }
						 return array;
					}

					var dataArray = getArray(as);

					// document.write('<br>Array Testhalber ausgeben: '); 
					// for (i=0; i<3; i++)
						// for (j=0; j<1; j++)
							// { document.write(dataArray[i][j] + " i = " + i + " j = " + j + "<br>"); }
				</script>
		  
        </div>
		
    </div>
		
		
		      <div id="sidebar_container">
        <div class="sidebar">
          <h3>Neueste Infos</h3>
          <div class="sidebar_item">
            <h4>Mietwagen APP veröffentlicht</h4>
            <h5>15. April 2014</h5>
            <p>Die App wurde online geschalten. Testphase somit angelaufen.
          </div>
          <div class="sidebar_base"></div>
        </div>
        <div class="sidebar">
          <h3>Weitere Links</h3>
          <div class="sidebar_item">
			<a href="images/schema.jpg" onclick="OpenNewWindow(this.href,800,600,'Schema');return false;" onkeypress="">
			<img class="bild200" src="images/schema.jpg" alt="Schema" title="Schemaübersicht" border="0" width="150" height="120"></a><br>
              <li><a href="#">Dokumentation</a></li>
			  <li><a href="#">Probleme/Erkenntnisse</a></li>
              <li><a href="https://github.com/vandenbergen/sint">Quellcode</a></li>
              <li><a href="#">Sonstiges</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
		<div class="sidebar">
          <h3>Standorte</h3>
          <div class="sidebar_item">
			<div class="sidebar_item" id="map" style="width: 170px; height: 150px;"></div> 
		
			<script type="text/javascript"> 
			
			var locations = dataArray; var map = new google.maps.Map(document.getElementById('map'), { zoom: 4, center: new google.maps.LatLng(46.92, 15.75), mapTypeId: google.maps.MapTypeId.ROADMAP }); var infowindow = new google.maps.InfoWindow(); var marker, i; for (i = 0; i < locations.length; i++) { marker = new google.maps.Marker({ position: new google.maps.LatLng(locations[i][1], locations[i][2]), map: map }); google.maps.event.addListener(marker, 'click', (function(marker, i) { return function() { infowindow.setContent(locations[i][0]); infowindow.open(map, marker); } })(marker, i)); } </script>
			
			
          </div>
          <div class="sidebar_base"></div>
        </div>
      </div>
		
      </div>

    <footer>
      <p><a href="mailto:ic13m032@technikum-wien.at">Markus Diepold</a> | <a href="mailto:ic13m005@technikum-wien.at">Markus Edelhofer</a> | <a href="ic13m035@technikum-wien.at">Christian Makas</a> </p>
      <p>Copyright &copy; CSS3_one | <a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>
    </footer>
  </div>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>
