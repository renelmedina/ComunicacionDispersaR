CREATE PROCEDURE `EliminarAccesoLogin` (
	in varAccesoLoginID int
)
BEGIN
	delete from AccesoLogin where idAccesoLogin=varAccesoLoginID;
END
