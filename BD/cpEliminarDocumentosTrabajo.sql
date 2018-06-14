CREATE PROCEDURE `EliminarDocumentosTrabajo` (
	in varDocumentosTrabajoID int
)
BEGIN
	delete from DocumentosTrabajo where idDocumentosTrabajo=varDocumentosTrabajoID;
END