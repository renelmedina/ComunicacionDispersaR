CREATE PROCEDURE `ListarTodoHojas` ()
BEGIN
	select idHoja,NroHoja,NombreHoja,DescripcionHoja from Hoja;
END