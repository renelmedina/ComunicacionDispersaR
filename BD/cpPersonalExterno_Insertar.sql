CREATE PROCEDURE `PersonalExterno_Insertar` (
	in varApellidos varchar(255),
	in varNombres varchar(255),
	in varDNI varchar(45),
	in varDireccion varchar(255),
	in varTelefonos varchar(255)
)
BEGIN
	insert into PersonalExterno(
		Apellidos,
		Nombres,
		DNI,
		Direccion,
		Telefonos
	)values(
		varApellidos,
		varNombres,
		varDNI,
		varDireccion,
		varTelefonos
	);
    select max(idPersonalExterno) as IdObtenido from PersonalExterno;
END