CREATE PROCEDURE `ModificarLibro` (
	in LibroID int,
    in varNroLibro varchar(10),
	in varNombreLibro varchar(45),
    in varDescripcionLibro text
)
BEGIN
	update Libro set
		NroLibro=varNroLibro,
		NombreLibro=varNombreLibro,
        DescripcionLibro=varDescripcionLibro
	where idLibro=LibroID;
END