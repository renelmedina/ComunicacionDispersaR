CREATE PROCEDURE `ListarTodoRuta` ()
BEGIN
	select idRuta,NroRuta,NombreRuta,DescripcionRuta from Ruta;
END
