CREATE PROCEDURE `EliminarTipoContrato` (
	in varTipoContratoID int
)
BEGIN
	delete from TipoContrato where idTipoContrato=varTipoContratoID;
END