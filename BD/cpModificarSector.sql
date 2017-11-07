CREATE PROCEDURE `ModificarSector` (
	in varSectorID int,
    in varNroSector varchar(10),
    in varNombreSector varchar(45),
    in varDescripcionSector text
)
BEGIN
	update Sector set
		NroSector=varNroSector,
        NombreSector=varNombreSector,
        DescripcionSector=varDescripcionSector
	where idSector=varSectorID;
END