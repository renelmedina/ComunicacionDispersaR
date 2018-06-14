CREATE PROCEDURE `VisitasCampo_Buscar` (
	in varDocumentosTrabajoID int,
	in varNotificadorID int,
	in varFechaInicial varchar(45),
	in varFechaFinal varchar(45),
	in varEstadoSeal varchar(45),
	in varDatoBuscar varchar(255),
	in varBuscarEn varchar(45),
	in varPaginaActual int,
	in varPaginasMostrar int
)
BEGIN
	select 
		vc.idVisitasCampo,
		vc.DocumentosTrabajoID,
        vc.NroSuministro,
		dt.ContratoID,
        dt.NroDocumento,
        dt.Tipo,
        ac.idAccesoLogin,
		vc.IdNotificador,
        ta.NombreAcceso,
		CASE
            WHEN ta.NombreAcceso = 'Personal Temporal' THEN ((select CONCAT_WS(",", Apellidos, Nombres)  AS ConcatenatedString from PersonalExterno where idPersonalExterno=ac.PersonalID))
			WHEN ta.NombreAcceso = 'Supervisor Externo' THEN ((select CONCAT_WS(",", Apellidos, Nombres)  AS ConcatenatedString from PersonalExterno where idPersonalExterno=ac.PersonalID))
            -- WHEN ta.NombreAcceso != '' THEN 'En vigor'
			ELSE (select CONCAT_WS(",", per.apellido_paterno,per.apellido_materno, per.nombre_completo) from accsac_personal_acc.personal_acc as per where per.id=vc.IdNotificador)
        END as NotificadorNombre,
		-- CONCAT_WS(" ",per.apellido_paterno,per.apellido_materno,per.nombre_completo) AS NotificadorNombre,
		vc.FechaAsignado,
		vc.FechaEjecutado,
		vc.Estado,
		vc.Estado as Estado,
        case
			when vc.Estado=1 then "Doc. Registrado"
            when vc.Estado=2 then "Doc. Asignado"
            when vc.Estado=3 then "Doc. Rezagado"
            when vc.Estado=4 then "Doc. E. Cliente"
            when vc.Estado=5 then "Doc.R.E. a Seal"
            when vc.Estado=6 then "Doc. E. Seal"
            else "Desconocido"
		end as NombreEstado,
		vc.EstadoSeal,
		case
			when vc.EstadoSeal=10 then "Con firma"
            when vc.EstadoSeal=11 then "Sin Firma"
            when vc.EstadoSeal=12 then "Ausente"
            when vc.EstadoSeal=13 then "No Ubicado"
            when vc.EstadoSeal=14 then "Rechazado"
            when vc.EstadoSeal=15 then "Terreno Baldio"
            when vc.EstadoSeal=16 then "NIS no corresponde"
            when vc.EstadoSeal=17 then "Construccion Paralizada"	
            else "-"
		end as NombreCodigoSeal,
		vc.NombreRecepcionador,
		vc.DNIRecepcionador,
		vc.Parentesco,
		vc.LecturaMedidor,
		vc.LatitudVisita,
		vc.LongitudVisita,
		vc.Observaciones
	from VisitasCampo as vc
	-- left join accsac_personal_acc.personal_acc as per on per.id=vc.IdNotificador
    left join AccesoLogin as ac on ac.idAccesoLogin=vc.IdNotificador
	left join TiposAcceso as ta on ta.idTiposAcceso=ac.TipoAcceso
	left join DocumentosTrabajo as dt on dt.idDocumentosTrabajo=vc.DocumentosTrabajoID
	where IF(varDocumentosTrabajoID != 0 or varDocumentosTrabajoID is null, vc.DocumentosTrabajoID=varDocumentosTrabajoID, 1=1)
			and IF(varNotificadorID != 0 or varNotificadorID is null, vc.IdNotificador=varNotificadorID, 1=1)
			and IF(varFechaInicial != '' and varFechaFinal!='',DATE(vc.FechaEjecutado) between varFechaInicial and varFechaFinal, 1=1)
			-- and IF(varEstado != 0 or varEstado is null, vc.Estado=varEstado, 1=1)
			and IF(varEstadoSeal != 0 or varEstadoSeal is null, vc.EstadoSeal=varEstadoSeal, 1=1)
			and IF(varDatoBuscar != '' and (varBuscarEn=0 or varBuscarEn is null),
									vc.DocumentosTrabajoID like CONCAT('%',varDatoBuscar,'%')
									or dt.ContratoID like CONCAT('%',varDatoBuscar,'%')
									or dt.NroDocumento like concat('%',varDatoBuscar,'%')
									or vc.Observaciones like concat('%',varDatoBuscar,'%')
                                    or vc.NroSuministro like concat('%',varDatoBuscar,'%')	
									,if(varBuscarEn=1,dt.idDocumentosTrabajo like CONCAT('%',varDatoBuscar,'%'),
										if(varBuscarEn=2,dt.ContratoID like CONCAT('%',varDatoBuscar,'%') or vc.NroSuministro like concat('%',varDatoBuscar,'%'),
											if(varBuscarEn=3,dt.NroDocumento like CONCAT('%',varDatoBuscar,'%'),
												if(varBuscarEn=4,dt.NombreCliente like CONCAT('%',varDatoBuscar,'%'),
													1=1			
												)
											)
										)
									)
				)
	order by vc.idVisitasCampo desc
	limit varPaginaActual,varPaginasMostrar;
END