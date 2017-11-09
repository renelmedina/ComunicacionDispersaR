CREATE PROCEDURE `ModificarTipoContrato` (
	in varTipoContratoID int,
	in varNombreTipo varchar(45),
    in varDescripcionTipo varchar(255)
)
BEGIN
	update TipoContrato set
		NombreTipo=varNombreTipo,
        DescripcionTipo=varDescripcionTipo
	where idTipoContrato=varTipoContratoID;
END