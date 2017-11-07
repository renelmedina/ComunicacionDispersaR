CREATE PROCEDURE `IngresarRuta` (
	in varNroRuta varchar(10),
	in varNombreRuta varchar(45),
    in varDescripcionRuta text
)
BEGIN
	insert into Ruta(
		NroRuta,
		NombreRuta,
        DescripcionRuta
    )values(
		varNroRuta,
		varNombreRuta,
		varDescripcionRuta
    );
END