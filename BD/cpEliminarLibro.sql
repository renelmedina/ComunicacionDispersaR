CREATE PROCEDURE `EliminarLibro` (
	in varLibroID int
)
BEGIN
	delete from Libro where idLibro=varLibroID;
END