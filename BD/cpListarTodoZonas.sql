CREATE PROCEDURE `ListarTodoZonas` ()
BEGIN
	select idZona,NroZona,NombreZona,DescripcionZona from Zona;
END