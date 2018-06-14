CREATE PROCEDURE `DocumentosTrabajoEstadoFechaEntregaSealXId` (
	in varDocumentosTrabajoID int,
	in varEstado int,
	in varFechaEntregaSeal date
)
BEGIN
	update DocumentosTrabajo set
		Estado=varEstado,
		FechaEntregaASeal=varFechaEntregaSeal
	where idDocumentosTrabajo=varDocumentosTrabajoID;
END