CREATE PROCEDURE `EliminarRuta` (
	in varRutaID int
)
BEGIN
	delete from Ruta where idRuta=varRutaID;
END