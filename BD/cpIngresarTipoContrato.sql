CREATE PROCEDURE `IngresarTipoContrato` (
	in varNombreTipo varchar(45),
    in varDescripcionTipo varchar(255)
)
BEGIN
	insert into TipoContrato(NombreTipo,DescripcionTipo)values(varNombreTipo,varDescripcionTipo);
END