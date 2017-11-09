CREATE PROCEDURE `EliminarSector` (
	in varSectorID int
)
BEGIN
	delete from Sector where idSector=varSectorID;
END