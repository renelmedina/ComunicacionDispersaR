CREATE PROCEDURE `ListarTodoHojasXpaginas` (
	in varPaginaActual int,
    in varPaginasMostrar int
)
BEGIN
	select idHoja,NroHoja,NombreHoja,DescripcionHoja from Hoja
    order by idHoja
    limit varPaginaActual, varPaginasMostrar;
END