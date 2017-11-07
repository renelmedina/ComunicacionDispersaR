CREATE PROCEDURE `IngresarZona` (
	in varNroZona varchar(10),
	in varNombreZona varchar(45),
    in varDescripcionZona text
)
BEGIN
	insert into Zona(
		NroZona,
		NombreZona,
        DescripcionZona
    )values(
		varNroZona,
		varNombreZona,
        varDescripcionZona
    );
END