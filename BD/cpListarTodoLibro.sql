CREATE PROCEDURE `ListarTodoLibro` ()
BEGIN
	select idLibro,NroLibro,NombreLibro,DescripcionLibro from Libro;
END
