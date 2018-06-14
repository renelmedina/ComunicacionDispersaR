CREATE PROCEDURE `ListarTodoHojasXpaginas_Total` ()
BEGIN
	select count(*) as total from Hoja
    order by idHoja;
END