CREATE PROCEDURE `WS_ActualizarDocumentoEjecutado` (
	in varDocumentoID int,
	in PersonalID int,
	in varFechaEjecucion DATETIME,
	in varEstado varchar(255),
	in varCodigoSeal varchar(45),
	in varObservaciones varchar(255)	
)
BEGIN
	update DocumentosTrabajo set
		IdNotificador=PersonalID,
		FechaEjecucion=varFechaEjecucion,
		Estado=varEstado,
		CodigoSeal=varCodigoSeal,
		Observaciones=varObservaciones
	where idDocumentosTrabajo=varDocumentoID;
END