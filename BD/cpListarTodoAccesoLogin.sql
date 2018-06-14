CREATE PROCEDURE `ListarTodoAccesoLogin` ()
BEGIN
	select 
		ac.idAccesoLogin as idAccesoLogin,
        ac.PersonalID as PersonalID,
        ac.Usuario as Usuario,
        ac.Password as Contrasenia,
        ac.TipoAcceso as TipoAcceso,
        ta.NombreAcceso as NombreAcceso,
		CASE
            WHEN ta.NombreAcceso = 'Personal Temporal' THEN ((select CONCAT_WS(",", Apellidos, Nombres)  AS ConcatenatedString from PersonalExterno where idPersonalExterno=ac.PersonalID))
			WHEN ta.NombreAcceso = 'Supervisor Externo' THEN ((select CONCAT_WS(",", Apellidos, Nombres)  AS ConcatenatedString from PersonalExterno where idPersonalExterno=ac.PersonalID))
            -- WHEN ta.NombreAcceso != '' THEN 'En vigor'
			ELSE CONCAT_WS(",", per.apellido_paterno,per.apellido_materno, per.nombre_completo)
        END as NombresCompletos
		from AccesoLogin as ac
		left join accsac_personal_acc.personal_acc as per on per.id=ac.PersonalID
        left join TiposAcceso as ta on ta.idTiposAcceso=ac.TipoAcceso
        order by NombresCompletos;
    
    /*select id,subzonalID,nombre_completo,apellido_paterno,apellido_materno,foto from accsac_personal_acc.personal_acc;*/
END