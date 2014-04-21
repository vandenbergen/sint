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
          </li>
          <li><a href="contact.php">Kontakt</a></li>
        </ul>
      </nav>
    </header>
    <div id="site_content">
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
              <li><a href="#">Dokumentation</a></li>
			  <li><a href="https://gate.edelhofer.org/sint/api">REST/SOAP Cars Rental Webservice</a></li>
              <li><a href="http://remote.makas.at/ConversionService.asmx">SOAP Currency Converter Webservice</a></li>
              <li><a href="https://github.com/vandenbergen/sint">Quellcode auf GitHub</a></li>
            </ul>
          </div>
          <div class="sidebar_base"></div>
        </div>
     </div>
      <div class="content">
        <h1>Kontaktinformationen</h1>
        <div class="content_item">
          <p>Treten Sie mit uns in Kontakt.</p>
          <?php
            // This PHP Contact Form is offered &quot;as is&quot; without warranty of any kind, either expressed or implied.
            // David Carter at www.css3templates.co.uk shall not be liable for any loss or damage arising from, or in any way
            // connected with, your use of, or inability to use, the website templates (even where David Carter has been advised
            // of the possibility of such loss or damage). This includes, without limitation, any damage for loss of profits,
            // loss of information, or any other monetary loss.

            // Set-up these 3 parameters
            // 1. Enter the email address you would like the enquiry sent to
            // 2. Enter the subject of the email you will receive, when someone contacts you
            // 3. Enter the text that you would like the user to see once they submit the contact form
            $to = 'markus@diepold.net';
            $subject = 'Anfrage vom Mietwagenportal';
            $contact_submitted = 'Ihre Nachricht wurde übermittelt.';

            // Do not amend anything below here, unless you know PHP
            function email_is_valid($email) {
              return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i',$email);
            }
            if (!email_is_valid($to)) {
              echo '<p style="color: red;">You must set-up a valid (to) email address before this contact page will work.</p>';
            }
            if (isset($_POST['contact_submitted'])) {
              $return = "\r";
              $youremail = trim(htmlspecialchars($_POST['your_email']));
              $yourname = stripslashes(strip_tags($_POST['your_name']));
              $yourmessage = stripslashes(strip_tags($_POST['your_message']));
              $contact_name = "Name: ".$yourname;
              $message_text = "Message: ".$yourmessage;
              $user_answer = trim(htmlspecialchars($_POST['user_answer']));
              $answer = trim(htmlspecialchars($_POST['answer']));
              $message = $contact_name . $return . $message_text;
              $headers = "From: ".$youremail;
              if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$youremail)) {
                mail($to,$subject,$message,$headers);
                $yourname = '';
                $youremail = '';
                $yourmessage = '';
                echo '<p style="color: blue;">'.$contact_submitted.'</p>';
              }
              else echo '<p style="color: red;">Bitte geben sie einen Namen und eine gültige E-Mail Adresse ein, und beantworten Sie diese einfache Frage, bevor sie das Formular absenden.</p>';
            }
            $number_1 = rand(1, 9);
            $number_2 = rand(1, 9);
            $answer = substr(md5($number_1+$number_2),5,10);
          ?>
          <form id="contact" action="contact.php" method="post">
            <div class="form_settings">
              <p><span>Name</span><input class="contact" type="text" name="your_name" value="<?php echo $yourname; ?>" /></p>
              <p><span>E-Mail Adresse</span><input class="contact" type="text" name="your_email" value="<?php echo $youremail; ?>" /></p>
              <p><span>Nachricht</span><textarea class="contact textarea" rows="5" cols="50" name="your_message"><?php echo $yourmessage; ?></textarea></p>
              <p style="line-height: 1.7em;">Zur Vermeidung von Spam beantworten Sie bitte folgende Frage:</p>
              <p><span><?php echo $number_1; ?> + <?php echo $number_2; ?> = ?</span><input type="text" name="user_answer" /><input type="hidden" name="answer" value="<?php echo $answer; ?>" /></p>
              <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="contact_submitted" value="send" /></p>
            </div>
          </form>
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
