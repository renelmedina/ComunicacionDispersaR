CREATE PROCEDURE `ListarTodoTipoDocumento` ()
BEGIN
	select idTipoDocumento,Nombre,Descripcion,ImagenReferencial from TipoDocumento;
END
