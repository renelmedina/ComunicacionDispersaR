CREATE PROCEDURE `IngresarLibro` (
	in varNroLibro varchar(10),
	in varNombreLibro varchar(45),
    in varDescripcionLibro text
)
BEGIN
	
    if not exists(select 1 from Libro where NroLibro=varNroLibro) then
		insert into Libro(
			NroLibro,
			NombreLibro,
			DescripcionLibro
		)values(
			varNroLibro,
			varNombreLibro,
			varDescripcionLibro
		);
		# errno 0, significa que se ingreso con normalidad
		select 0 as errno;
	else
		# errno 1, significa que ya existe el numero de contrato.
        update Libro set
			NroLibro=varNroLibro,
            NombreLibro=varNombreLibro,
            DescripcionLibro=varDescripcionLibro
		where NroLibro=varNroLibro;
		select 1 as errno;
	end if;
END