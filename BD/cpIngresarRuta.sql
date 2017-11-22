CREATE PROCEDURE `IngresarRuta` (
	in varNroRuta varchar(10),
	in varNombreRuta varchar(45),
    in varDescripcionRuta text
)
BEGIN
	
    if not exists(select 1 from Ruta where NroRuta=varNroRuta) then
		insert into Ruta(
			NroRuta,
			NombreRuta,
			DescripcionRuta
		)values(
			varNroRuta,
			varNombreRuta,
			varDescripcionRuta
		);
		# errno 0, significa que se ingreso con normalidad
		select 0 as errno;
	else
		# errno 1, significa que ya existe el numero de contrato.
        update Ruta set
			NroRuta=varNroRuta,
            NombreRuta=varNombreRuta,
            DescripcionRuta=varDescripcionRuta
		where NroRuta=varNroRuta;
		select 1 as errno;
	end if;
END