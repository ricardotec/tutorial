$(document).ready(function()
{
	$("#terminado").click(function() {
		var path="http://localhost/tutorial/", ruta=path+"administrador/terminado";
		$("#contenido").load('administrador/terminado');
		//alert("Hola mundo");
	});

	$("#descarga").click(function() {
		var path="http://localhost/tutorial/", ruta=path+"soporte/descargar";
		var dir = $('#ubicacion').val();
		var nuevo = $('#arch1').val();
		var viejo = $('#arch2').val();
		$.post(ruta,{"ubicacion":dir,"arch1":nuevo,"arch2":viejo},function (data) {
			console.info(data);
			//window.open(path+data);
			window.location.href = path+data;
		});
	});

	$("#download").click(function(){
		var ruta = $('#ruta2').val();
		//var ruta2 = $('#ruta2').val();

		window.location.href = 'http://localhost/tutorial/'.concat(ruta);
	});
});