CREATE PROCEDURE `ModificarZona` (
	in varZonaID int,
    in varNroZona varchar(10),
    in varNombreZona varchar(45),
    in varDescripcionZona text
)
BEGIN
	update Zona set
		NroZona=varNroZona,
        NombreZona=varNombreZona,
        DescripcionZona=varDescripcionZona
	where idZona=varZonaID;
END