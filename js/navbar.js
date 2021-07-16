var links = document.getElementsByClassName("myLink");
var URL = window.location.pathname;
URL = URL.substring(URL.lastIndexOf('/'));


var links = document.getElementsByTagName("a");

for (var i = 0; i < links.length; i++) {
  if ("/"+links[i].getAttribute("href") == URL) {
    links[i].setAttribute("class", "active");
  }
}

var urlToTitle = {
    "/gallery.php": 'Galerie',
    "/registration.php": 'Registrace',
    "/login.php": 'Přihlásit se',
};

if (URL in urlToTitle) {
  document.title = urlToTitle[URL];
}
else {
  document.title = "Galerie";
}