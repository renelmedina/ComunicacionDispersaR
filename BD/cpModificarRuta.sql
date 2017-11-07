CREATE PROCEDURE `ModificarRuta` (
	in RutaID int,
    in varNroRuta varchar(10),
	in varNombreRuta varchar(45),
    in varDescripcionRuta text
)
BEGIN
	update Ruta set
		NroRuta=varNroRuta,
		NombreRuta=varNombreRuta,
        DescripcionRuta=varDescripcionRuta
	where idRuta=RutaID;
END