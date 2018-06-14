CREATE PROCEDURE `EliminarTipoDocumento` (
	in varTipoDocumentoID int
)
BEGIN
	delete from TipoDocumento where idTipoDocumento=varTipoDocumentoID;
END
