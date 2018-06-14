CREATE PROCEDURE `AsignarDocumentosTrabajoXID` (
	in varDocumentosTrabajoID int,
	in varPersonalID int
)
BEGIN
	update DocumentosTrabajo set
		IdNotificador=varPersonalID
	where idDocumentosTrabajo=varDocumentosTrabajoID;
END
