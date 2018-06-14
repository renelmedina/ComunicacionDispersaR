CREATE PROCEDURE `PersonalExterno_Actualizar` (
	in varPersonalExternoID int,
	in varApellidos varchar(255),
	in varNombres varchar(255),
	in varDNI varchar(45),
	in varDireccion varchar(255),
	in varTelefonos varchar(255)
)
BEGIN
	update PersonalExterno set
		Apellidos=varApellidos,
		Nombres=varNombres,
		DNI=varDNI,
		Direccion=varDireccion,
		Telefonos=varTelefonos
	where idPersonalExterno=varPersonalExternoID;
END