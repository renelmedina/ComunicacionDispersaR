CREATE PROCEDURE `PersonalExterno_ListarTodo` ()
BEGIN
	select idPersonalExterno,Apellidos,Nombres,DNI,Direccion,Telefonos from PersonalExterno;
END