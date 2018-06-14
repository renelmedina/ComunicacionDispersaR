CREATE PROCEDURE `ListarTodoTiposAcceso` ()
BEGIN
	select  idTiposAcceso,NombreAcceso,Descripcion,UrlDestino from TiposAcceso;
END