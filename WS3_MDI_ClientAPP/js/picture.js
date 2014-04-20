

newWindow="";
function OpenNewWindow(Picture,Breit,Hoch,Alttext) {
xsize = Breit+1;
ysize = Hoch+25;

ScreenWidth = screen.width;
ScreenHeight = screen.height;

xpos = (ScreenWidth/2)-(xsize/2);
ypos = (ScreenHeight/2)-((ysize+50)/2);

if (!newWindow.closed && newWindow.location) {newWindow.close();}

html = ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de"><head><title>Webdesign nach Maß - '+Alttext+'</title><meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" /><style type="text/css">html, body, p, img, a {margin:0; padding:0; border: 0; font-family: Verdana,Geneva,Arial,sans-serif; color:#fff; text-align: center;} body {font-size:100.01%; background:#333; cursor:pointer;} p {font-size: 0.8em;}</style></head><body title="Klicken zum Schließen" onload="focus()"><p><img onclick="self.close()" src="'+Picture+'" alt="'+Alttext+'" width="'+Breit+'" height="'+Hoch+'" /><br /><a href="javascript:self.close()">Fenster&nbsp;schlie&szlig;en</a>&nbsp;|&nbsp;<a title="Bild drucken" href="javascript:window.print()">Drucken</a></p></body></html>');

newWindow=window.open("","Picture","height="+ysize+",width="+xsize+",resizable=yes,top="+ypos+",left="+xpos+"");

  newWindow.document.open("text/html", "replace")
  newWindow.document.write(html)
  newWindow.document.close()

  return false;
}
