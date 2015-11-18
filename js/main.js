$.ajax({
  url: 'http://localhost/Adinan/test-dev/carros',
  success: function(data) {
    var div = document.getElementById("results");
	div.innerHTML = "Carros registrados: <br><br>"+data;
  }
});