CREATE PROCEDURE `AsignarPersonalDocumentosTrabajo` (
	in varDocumentosTrabajoID int,
	in varIdNotificador int,
	in varFechaAsignacion date
)
BEGIN
	update DocumentosTrabajo set
		IdNotificador=varIdNotificador,
		FechaAsignacion=varFechaAsignacion,
        -- estado=2 significa que esta asigando
        Estado=2
	where idDocumentosTrabajo=varDocumentosTrabajoID;
END