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
              <li><a href="https://github.com/vandenbergen/sint">Quellcode</a></li>
              <li><a href="#">Sonstiges</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
      </div>
      <div class="content">
        <h1>Buchungen</h1>
        <div class="content_item">
          <h2>Status der aktuellen Buchungen:</h2>
          		  
		  <table style="width:100%; border-spacing:0;">
            <tr><th>ID</th><th>Kunde</th><th>Datum von</th><th>Datum bis</th><th>Status</th><th>Abfahrt</th><th>Ankunft</th><th>Fahrzeug</th><th>Preis</th><th>Währung</th></tr>
            
            <?php
				$json = (json_decode(file_get_contents('https://gate.edelhofer.org/sint/api/rent'),true));
				// echo '<pre>';
				// print_r ($json);
				// echo '</pre>';
						
						
				foreach ($json['rent'] as $type => $value)
				{
							echo '<tr>';
							echo '<td>'.$value['id'].'</td>';
							echo '<td>'.$value['cus_id'].'</td>';
							echo '<td>'.$value['date_from'].'</td>';
							echo '<td>'.$value['date_to'].'</td>';
							if (!$value['state'])
								echo '<td><span class="red">&nbsp;ausgeliehen&nbsp;</span></td>';
							else
								echo '<td><span class="green">&nbsp;&nbsp;&nbsp;verfügbar &nbsp;&nbsp;</span></td>';
								
							echo '<td>'.$value['loc_id_from'].'</td>';
							
							echo '<td>'.$value['loc_id_to'].'</td>';
							echo '<td>'.$value['car_id'].'</td>';
							echo '<td>'.$value['priceperday'].'</td>';
							echo '<td>'.$value['valuta'].'</td>';
							echo '</tr>';
				}
			?>
			
          </table>
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