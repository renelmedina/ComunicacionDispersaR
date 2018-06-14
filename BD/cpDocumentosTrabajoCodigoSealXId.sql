CREATE PROCEDURE `DocumentosTrabajoCodigoSealXId` (
	in varDocumentosTrabajoID int,
	in varCodigoSeal int,
    in varEstado int,
	in varFechaEjecucionTrabajo date
)
BEGIN
	update DocumentosTrabajo set
		Estado=varEstado,
		CodigoSeal=varCodigoSeal,
		FechaEjecucion=varFechaEjecucionTrabajo
	where idDocumentosTrabajo=varDocumentosTrabajoID;
END