CREATE PROCEDURE `WS_RegistrarVisitaXId` (
	in varDocumentosTrabajoID int,
    in NroSuministro int,
	in varIdNotificador int,
	in varFechaAsignado datetime,
	in varFechaEjecutado datetime,
	in varEstado varchar(45),
	in varEstadoSeal varchar(45),
	in varNombreRecepcionador varchar(255),
	in varDNIRecepcionador varchar(45),
	in varParentesco varchar(45),
    in varLecturaMedidor varchar(255),
	in varLatitudVisita varchar(255),
	in varLongitudVisita varchar(255),
	in varObservaciones varchar(255)
)
BEGIN
	insert into VisitasCampo(
		DocumentosTrabajoID,
        NroSuministro,
		IdNotificador,
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
	)values(
		varDocumentosTrabajoID,
        NroSuministro,
		varIdNotificador,
		varFechaAsignado,
		varFechaEjecutado,
		varEstado,
		varEstadoSeal,
		varNombreRecepcionador,
		varDNIRecepcionador,
		varParentesco,
        varLecturaMedidor,
		varLatitudVisita,
		varLongitudVisita,
		varObservaciones
	);
    select max(idVisitasCampo) as IdCreado from VisitasCampo;
END