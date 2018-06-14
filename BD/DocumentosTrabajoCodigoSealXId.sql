CREATE PROCEDURE `DocumentosTrabajoCodigoSealXId` (
	in varDocumentosTrabajoID int,
	in varCodigoSeal int,
	in varFechaEjecucionTrabajo date
)
BEGIN
	update DocumentosTrabajo set
		CodigoSeal=varCodigoSeal,
		FechaEjecucion=varFechaEjecucionTrabajo
	where idDocumentosTrabajo=varDocumentosTrabajoID;
END