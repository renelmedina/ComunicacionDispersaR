CREATE PROCEDURE `ListarTodoTipoContrato` ()
BEGIN
	select idTipoContrato,NombreTipo,DescripcionTipo from TipoContrato;
END
