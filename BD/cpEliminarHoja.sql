CREATE PROCEDURE `EliminarHoja` (
	in varHojaID int
)
BEGIN
	delete from Hoja where idHoja=varHojaID;
END
