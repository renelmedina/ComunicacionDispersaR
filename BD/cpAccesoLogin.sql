CREATE PROCEDURE `AccesoLogin` (
	in varUsuario varchar(255),
    in varPassword varchar(255)
)
BEGIN
	select
		acc.idAccesoLogin as idAccesoLogin,
        acc.PersonalID as PersonalID,
        acc.Usuario as Usuario,
        acc.Password as Password,
        acc.TipoAcceso as TipoAcceso,
        concat_ws(" ",per.apellido_paterno,per.apellido_materno,per.nombre_completo) as NombrePersonal
	from AccesoLogin as acc
    left join accsac_personal_acc.personal_acc as per on per.id=acc.PersonalID
    where Usuario=varUsuario and Password=varPassword;
        
END
