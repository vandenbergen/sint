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
  <?php include ("./lib/functions.php"); ?>
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
        <h1>Fahrzeugleihe</h1>
		<div class="content_item">
		  <h2>Buchungsdetails:</h2>
          
            
            
            <?php
				$locations = (json_decode(file_get_contents('https://gate.edelhofer.org/sint/api/locations'),true));
				$cars = (json_decode(file_get_contents('https://gate.edelhofer.org/sint/api/cars'),true));
				
				if(isset($_POST['new'])) {				
					$id = $_POST['id'];
					$json = array("customers_rent" => array(
											0 => array(
												"cus_id" => $_POST['id'], 
												"date_from" => '', 
												"date_to" => '', 
												"loc_id_from" => '', 
												"loc_id_to" => '',
												"car_id" => '')));
				}
				else {
					if(isset($_POST['submit']))
					$id = $_POST['cus_id'];					
					echo 'id ist: '.$id;
					{ 
						$data = array ("customers_rent" => array (
							0 	=> array("cus_id" => $_POST['cus_id'], 
									"date_from" => $_POST['date_from'], 
									"date_to" => $_POST['date_to'],
									"loc_id_from" => $_POST['loc_id_from'],
									"loc_id_to" => $_POST['loc_id_to'],
									"car_id" => $_POST['car_id']
								)
							)
						);
						
					// echo'<pre>';
					// print_r($data);
					// echo'</pre>';
					// echo '<br>'.json_encode($data).'<br>';
							
					my_curl_PUT(json_encode($data),'https://gate.edelhofer.org/sint/api/rent');
					header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
				}

						
				}

				?>				
				
				
				<form method="post" action="">
				<div class="form_settings">
					<p><span>Kunden ID</span><input class="readonly" type="text" name="cus_id" value="<?php echo $id ?>" readonly></p>
					<p><span>Datum von</span><input type="date" id="datepicker" name='date_from' size='9' value="<?php echo $json['customers_rent'][0]['date_from'] ?>" /> 
					<p><span>Datum bis</span><input type="date" id="datepicker" name='date_to' size='9' value="<?php echo $json['customers_rent'][0]['date_to'] ?>" /> 
              		<p><span>Standort von</span><select class="contact" name="loc_id_from">
						<option value=""></option>
						 <?php foreach ($locations['locations'] as $type => $property) {echo '<option value="'.$property['id'].'" >'.$property['city'].'</option>';} ?>
						</select></p>
              		<p><span>Standort nach</span><select class="contact" name="loc_id_to">
						<option value=""></option>
						 <?php foreach ($locations['locations'] as $type => $property) {echo '<option value="'.$property['id'].'" >'.$property['city'].'</option>';} ?>
					</select></p>
					
              		<p><span>Fahrzeug</span><select class="contact" name="car_id">
						<option value=""></option>
						 <?php 
							foreach ($cars['cars'] as $type => $property) {
								if($property['state'] == 1)
									echo '<option value="'.$property['id'].'" >'.$property['plate'].'&nbsp;-&nbsp;'.$property['brand'].'&nbsp;'.$property['type'].'&nbsp;</option>';
							} 
						?>
					</select></p>

					<p style="padding-top: 15px"><span>&nbsp;</span><button class="submit4" type="button" onclick="history.back();">zurück</button>
												<input class="submit3" type="submit" name="submit" value="buchen" /></p>


												
				</div>
				</form>
					
        </div>
		
		<h1>Buchungen</h1>
		<div class="content_item">
          <h2>Buchungsübersicht:</h2>
		  <form method="post" action="mitglieder_rent.php">
		  <div class="form_settings">
			<span>&nbsp;</span><input class="new" type="submit" name="new" value="Neue Buchung" />
          </div>
		  </form>
		  <table style="width:100%; border-spacing:0;">
            <tr><th>ID</th><th>Datum von</th><th>Datum bis</th><th>Status</th><th>Abfahrt</th><th>Ankunft</th><th>Fahrzeug</th></tr>
            
            <?php
				$rent = (json_decode(file_get_contents('https://gate.edelhofer.org/sint/api/customers/'.$id.'/rent'),true));
				//echo '<pre>';
				//print_r ($rent);
				//echo '</pre>';
						
				if($rent) {
					foreach ($rent['customers_rent'] as $type => $value)
					{
						echo '<tr>';
						echo '<td>'.$value['id'].'</td>';
						echo '<td>'.$value['date_from'].'</td>';
						echo '<td>'.$value['date_to'].'</td>';
						if (!$value['state'])
							echo '<td><span class="red">&nbsp;&nbsp;ausgeliehen&nbsp;&nbsp;  </span></td>';
						else
							echo '<td><span class="green">&nbsp;&nbsp;&nbsp;&nbsp;verfügbar &nbsp;&nbsp;&nbsp;&nbsp; </span></td>';
							
						echo '<td>'.$value['loc_id_from'].'</td>';
						
						echo '<td>'.$value['loc_id_to'].'</td>';
						echo '<td>'.$value['car_id'].'</td>';
						echo '</tr>';
					}
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