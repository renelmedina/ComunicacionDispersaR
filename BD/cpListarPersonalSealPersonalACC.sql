CREATE PROCEDURE `ListarPersonalSealPersonalACC` ()
BEGIN
	select id,subzonalID,nombre_completo,apellido_paterno,apellido_materno,foto from accsac_personal_acc.personal_acc;
END