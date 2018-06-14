CREATE PROCEDURE `InsertarTDD_Detalle` (
	in varTipoDocumentoDetalleID int,
	in varNombre varchar(255),
	in varDescripcion text,
	in varImagenReferencial varchar(255)
)
BEGIN
	insert into TDD_Detalle(
		IdTipoDocumentoDetalle,
		Nombre,
		Descripcion,
		ImagenReferencial
	)values(
		varTipoDocumentoDetalleID,
		varNombre,
		varDescripcion,
		varImagenReferencial
	);
END