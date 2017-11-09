CREATE PROCEDURE `EliminarContratosXContrato` (
	in varNroContrato varchar(10)
)
BEGIN
	delete from ContratosMedidores where NroContrato=varNroContrato;
END