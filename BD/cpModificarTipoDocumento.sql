CREATE PROCEDURE `ModificarTipoDocumento` (
	in varTipoDocumentoID int,
    in varNombre varchar(255),
    in varDescripcion text,
    in varImagenReferencial varchar(255)
)
BEGIN
	update TipoDocumento set
		Nombre=varNombre,
        Descripcion=varDescripcion,
        ImagenReferencial=varImagenReferencial
	where idTipoDocumento=varTipoDocumentoID;
END
