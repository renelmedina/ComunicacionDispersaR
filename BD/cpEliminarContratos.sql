CREATE PROCEDURE `EliminarContratos` (
	in varContratosID int
)
BEGIN
	delete from ContratosMedidores where idContratosMedidores=varContratosID;
END