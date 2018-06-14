CREATE PROCEDURE `InsertarAccesoLogin` (
	in varPersonalID int,
	in varUsuario varchar(255),
	in varPassword varchar(255),
	in varTipoAcceso int
)
BEGIN
	insert into AccesoLogin(
		PersonalID,
		Usuario,
		Password,
		TipoAcceso
	)values(
		varPersonalID,
		varUsuario,
		varPassword,
		varTipoAcceso
	);
END
