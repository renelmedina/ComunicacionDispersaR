CREATE PROCEDURE `InsertarTDD` (
	IN varIdTipoDocumento int,
	IN varNombreTDD varchar(255),
	IN varDescripcion text,
	IN varImagenReferencial varchar(255)
)
BEGIN
	insert into TipoDocumentoDetalle(
		IdTipoDocumento,
		Nombre,
		Descripcion,
		ImagenReferencial
	)values(
		varIdTipoDocumento,
		varNombreTDD,
		varDescripcion,
		varImagenReferencial
	);
END