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
            <ul>
              <li><a href="#">Dokumentation des Projekts</a></li>
              <li><a href="#">Probleme/Erkenntnisse</a></li>
              <li><a href="#">Quellcode</a></li>
              <li><a href="#">Sonstiges</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
      </div>
      <div class="content">
        <h1>Autos</h1>
        <div class="content_item">
          <h2>Folgende Autos stehen zur Verfügung:</h2>
          <table style="width:100%; border-spacing:0;">
            <tr><th>ID</th><th>Marke</th><th>Type</th><th>Kennz.</th><th>Farbe</th><th>Status</th><th>Verb.</th><th>KW</th><th>Standort</th><th>Preis</th><th>Währung</th></tr>
            <?php
				$json = (json_decode(file_get_contents('https://gate.edelhofer.org/sint/api/cars'), true));

				//echo file_get_contents('https://gate.edelhofer.org/sint/api/cars');
				foreach ($json['cars'] as $type => $property)
				{
					echo '<tr>';
					//foreach ($property as $properties => $value)
						{
							echo '<td>'.$property['id'].'</td>';
							echo '<td>'.$property['brand'].'</td>';
							echo '<td>'.$property['type'].'</td>';
							echo '<td>'.$property['plate'].'</td>';
							echo '<td>'.$property['color'].'</td>';
							
							if (!$property['state'])
								echo '<td><span class="red">&nbsp;&nbsp;ausgeliehen&nbsp;&nbsp;  </span></td>';
							else
								echo '<td><span class="green">&nbsp;&nbsp;&nbsp;&nbsp;verfügbar &nbsp;&nbsp;&nbsp;&nbsp; </span></td>';
								
							echo '<td>'.$property['consumption'].'</td>';
							echo '<td>'.$property['power'].'</td>';
							echo '<td>'.$property['id_site'].'</td>';
							echo '<td>'.$property['priceperday'].'</td>';
							echo '<td>'.$property['valuta'].'</td>';
							//echo '<td>'.$value.'</td>';
						}
					
					echo '</tr>';
				}
				echo '</table>';
								
				//echo'<pre>';
				//print_r($json);
				//echo'</pre>';
			?>
			
		  
		  				


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
