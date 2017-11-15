/*Acciones a utilizar
Usando jquery-3.2.1.js
*/
function fnCargaSimple(pagina,mensajeHTML,divprincipal,divmensajero) {
	$(divmensajero).html(mensajeHTML);
	$(divmensajero).fadeIn(100);
	if(!divprincipal==""){
		$(divprincipal).load(pagina, function(){
       		$(divmensajero).fadeOut(200);
     	});
 	}else{
 		$("#divPrincipal").load(pagina, function(){
       		$(divmensajero).fadeOut(200);
     	});
 	}
 	//Se puede agregar una clase para dar efecto al menu.
	/*$("."+enlace.className).css("background-color","#335088");
	$("."+enlace.className).css("color","#B6B6DA");
	$("."+enlace.className).css("font-weight","");
	$(enlace).css("background-color","#6F9FDF");
	$(enlace).css("color","#423E7B");
	$(enlace).css("font-weight","bold");*/
}
function envio_general_forms(formularioid,procesadorphp,capaeventosid,mensajeHTML){
  var str = new FormData($(formularioid)[0]);
      $.ajax({
        type: "POST",
        url: procesadorphp,
        data: str,
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){
            $(capaeventosid).html(mensajeHTML);
        },
        //una vez finalizado correctamente
        success: function(theResponse) {
            $(capaeventosid).html(theResponse);
        },
          //si ha ocurrido un error
        error: function(){
          $(capaeventosid).html("<strong>Error: </strong> Error de envio de datos, vuelve a intentarlo, si el problema persiste comunica al webmaster. este error es de comunicaion de datos con el servidor mediante tecnologia Ajax y Jquery");
        }
      });
}