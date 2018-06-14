CREATE PROCEDURE `VisitasCampo_VerXIdDocumento` (
	in varDocumentosTrabajoID int
)
BEGIN
	select 
		idVisitasCampo,
		DocumentosTrabajoID,
		IdNotificador,
		CONCAT_WS(" ",per.apellido_paterno,per.apellido_materno,nombre_completo) AS NotificadorNombre,
		FechaAsignado,
		FechaEjecutado,
		Estado,
		EstadoSeal,
		NombreRecepcionador,
		DNIRecepcionador,
		Parentesco,
		LecturaMedidor,
		LatitudVisita,
		LongitudVisita,
		Observaciones
	from VisitasCampo
	left join accsac_personal_acc.personal_acc as per on per.id=VisitasCampo.IdNotificador
	where DocumentosTrabajoID=varDocumentosTrabajoID;
END