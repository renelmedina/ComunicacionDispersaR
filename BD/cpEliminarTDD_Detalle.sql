CREATE PROCEDURE `EliminarTDD_Detalle` (
	IN varTDD_DetalleID int
)
BEGIN
	delete from TDD_Detalle where idTDD_Detalle=varTDD_DetalleID;
END