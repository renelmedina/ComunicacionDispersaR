CREATE PROCEDURE `ModificarAccesoLogin` (
	in varAccesoLoginID int,
	in varPersonalID int,
	in varUsuario varchar(255),
	in varPassword varchar(255),
	in varTipoAcceso int
)
BEGIN
	update AccesoLogin set
		PersonalID=varPersonalID,
		Usuario=varUsuario,
		Password=varPassword,
		TipoAcceso=varTipoAcceso
	where idAccesoLogin=varAccesoLoginID;
END