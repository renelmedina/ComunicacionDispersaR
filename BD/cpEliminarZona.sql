CREATE PROCEDURE `EliminarZona` (
	in varZonaID int
)
BEGIN
 delete from Zona where idZona=varZonaID;
END