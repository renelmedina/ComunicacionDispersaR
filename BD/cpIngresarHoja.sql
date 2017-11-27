CREATE PROCEDURE `IngresarHoja` (
	in varNroHoja varchar(10),
	in varNombreHoja varchar(45),
    in varDescripcionHoja text
)
BEGIN
	
    if not exists(select 1 from Hoja where NroHoja=varNroHoja) then
		insert into Hoja(
			NroHoja,
			NombreHoja,
			DescripcionHoja
		)values(
			varNroHoja,
			varNombreHoja,
			varDescripcionHoja
		);
		# errno 0, significa que se ingreso con normalidad
		select 0 as errno;
	else
		# errno 1, significa que ya existe el numero de contrato.
        update Hoja set
			NroHoja=varNroHoja,
            NombreHoja=varNombreHoja,
            DescripcionHoja=varDescripcionHoja
		where NroHoja=varNroHoja;
		select 1 as errno;
	end if;
END