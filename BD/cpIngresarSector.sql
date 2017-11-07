CREATE PROCEDURE `IngresarSector` (
	in varNroSector varchar(10),
	in varNombreSector varchar(45),
    in varDescripcionSector text
)
BEGIN
	insert into Sector(
		NroSector,
		NombreSector,
        DescripcionSector
    )values(
		varNombreSector,
        varDescripcionSector,
        varNroSector
    );
END