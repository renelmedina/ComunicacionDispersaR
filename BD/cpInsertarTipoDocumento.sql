CREATE PROCEDURE `InsertarTipoDocumento` (
	in varNombre varchar(255),
    in varDescripcion text,
    in varImagenReferencial varchar(255)
)
BEGIN
	insert into TipoDocumento(
		Nombre,
        Descripcion,
        ImagenReferencial
	)values(
		varNombre,
        varDescripcion,
        varImagenReferencial
	);
END
