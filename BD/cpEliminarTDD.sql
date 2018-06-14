CREATE PROCEDURE `EliminarTDD` (
	IN varTipoDocumentoDetalleID int
)
BEGIN
	delete from TipoDocumentoDetalle where idTipoDocumentoDetalle=varTipoDocumentoDetalleID;
END