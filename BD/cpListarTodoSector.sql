CREATE PROCEDURE `ListarTodoSector` ()
BEGIN
	select idSector,NroSector,NombreSector,DescripcionSector from Sector;
END
