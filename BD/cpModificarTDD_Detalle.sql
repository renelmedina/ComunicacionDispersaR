CREATE PROCEDURE `ModificarTDD_Detalle` (
	IN varTDD_DetalleID int,
	in varTipoDocumentoDetalleID int,
	in varNombre varchar(255),
	in varDescripcion text,
	in varImagenReferencial varchar(255)
)
BEGIN
	update TDD_Detalle set
		IdTipoDocumentoDetalle=varTipoDocumentoDetalleID,
		Nombre=varNombre,
		Descripcion=varDescripcion,
		ImagenReferencial=varImagenReferencial
	where idTDD_Detalle=varTDD_DetalleID;
END