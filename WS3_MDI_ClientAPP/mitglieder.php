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
              <li><a href="Systemintegration_MDI_MED_CMA.pdf">Dokumentation</a></li>
			  <li><a href="https://gate.edelhofer.org/sint/api">REST/SOAP Cars Rental Webservice</a></li>
              <li><a href="http://remote.makas.at/ConversionService.asmx">SOAP Currency Converter Webservice</a></li>
              <li><a href="https://github.com/vandenbergen/sint">Quellcode auf GitHub</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
      </div>
      <div class="content">
        <h1>Mitglieder</h1>
        <div class="content_item">
          <h2>Folgende Benutzer sind angemeldet:</h2>
		  <form method="post" action="mitglieder_detail.php">
		  <div class="form_settings">
			<span>&nbsp;</span><input class="new" type="submit" name="new" value="Neuer Benutzer" />
          </div>
		  <table style="width:100%; border-spacing:0;">
            <tr><th>ID</th><th>Nachname</th><th>Vorname</th><th>Strasse</th><th>PLZ</th><th>Ort</th><th>Land</th></tr>
            
            <?php
				$json = (json_decode(file_get_contents('https://gate.edelhofer.org/sint/api/customers'),true));
				
				foreach ($json['customers'] as $type => $value)
				{
							echo '<tr>';
							echo '<td>'.$value['id'].'</td>';
							echo '<td><a href=mitglieder_detail.php?id='.$value['id'].' method="post">'.$value['givenname'].'</a></td>';
							echo '<td>'.$value['firstname'].'</td>';
							echo '<td>'.$value['street'].'</td>';
							echo '<td>'.$value['zip'].'</td>';
							echo '<td>'.$value['city'].'</td>';
							echo '<td>'.$value['country'].'</td>';
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