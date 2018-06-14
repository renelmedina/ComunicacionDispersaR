CREATE PROCEDURE `DocumentosTrabajoEntregaSealXId` (
	in varDocumentosTrabajoID int,
    in varEstado int,
	in varFechaEjecucionTrabajo date
)
BEGIN
	update DocumentosTrabajo set
		Estado=varEstado,
		FechaEntregaASeal=varFechaEjecucionTrabajo
	where idDocumentosTrabajo=varDocumentosTrabajoID;
END