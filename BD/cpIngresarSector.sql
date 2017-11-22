CREATE PROCEDURE `IngresarSector` (
	in varNroSector varchar(10),
	in varNombreSector varchar(45),
    in varDescripcionSector text
)
BEGIN
    if not exists(select 1 from Sector where NroSector=varNroSector) then
		insert into Sector(
			NroSector,
			NombreSector,
			DescripcionSector
		)values(
			varNroSector,
			varNombreSector,
			varDescripcionSector
			
		);
		# errno 0, significa que se ingreso con normalidad
		select 0 as errno;
	else
		# errno 1, significa que ya existe el numero de contrato.
        update Sector set
			NroSector=varNroSector,
            NombreSector=varNombreSector,
            DescripcionSector=varDescripcionSector
		where NroSector=varNroSector;
		select 1 as errno;
	end if;
END