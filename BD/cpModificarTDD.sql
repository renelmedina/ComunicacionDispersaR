CREATE PROCEDURE `ModificarTDD` (
	IN varTipoDocumentoDetalleID int,
	IN varIdTipoDocumento int,
	IN varNombreTDD varchar(255),
	IN varDescripcion text,
	IN varImagenReferencial varchar(255)
)
BEGIN
	update TipoDocumentoDetalle set
		IdTipoDocumento=varIdTipoDocumento,
		Nombre=varNombreTDD,
		Descripcion=varDescripcion,
		ImagenReferencial=varImagenReferencial
	where idTipoDocumentoDetalle=varTipoDocumentoDetalleID;
END