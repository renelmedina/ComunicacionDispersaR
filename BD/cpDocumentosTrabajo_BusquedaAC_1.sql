CREATE PROCEDURE `DocumentosTrabajo_BusquedaAC_1` (
	IN varTDD_DetalleID int,
	IN varPersonalID int,
	IN varFechaInicial varchar(50),
	IN varFechaFinal varchar(50),
	IN varEstado int,
    IN varCodigoSeal int,
	IN varFiltro int,
	IN varDatoBuscar varchar(255),
	IN varBuscarEn int,
	IN varPaginaActual int,
	IN varPaginasMostrar int
)
BEGIN
	select
		dt.idDocumentosTrabajo as idDocumentosTrabajo,
		dt.IdTDD_Detalle as IdTDD_Detalle,
		TDDD.Nombre as NombreTDDD,
		dt.IdNotificador as IdNotificador,
        ta.NombreAcceso,
		CASE
            WHEN ta.NombreAcceso = 'Personal Temporal' THEN ((select CONCAT_WS(",", Apellidos, Nombres)  AS ConcatenatedString from PersonalExterno where idPersonalExterno=ac.PersonalID))
			WHEN ta.NombreAcceso = 'Supervisor Externo' THEN ((select CONCAT_WS(",", Apellidos, Nombres)  AS ConcatenatedString from PersonalExterno where idPersonalExterno=ac.PersonalID))
            -- WHEN ta.NombreAcceso != '' THEN 'En vigor'
			ELSE (select CONCAT_WS(",", per.apellido_paterno,per.apellido_materno, per.nombre_completo) from accsac_personal_acc.personal_acc as per where per.id=dt.IdNotificador)
        END as NotificadorNombre,
		dt.ContratoID as NroContrato,
		dt.CodBarra as CodBarra,
		dt.NroDocumento as NroDocumento,
		dt.NombreCliente as NombreCliente,
		dt.Direccion as Direccion,
		dt.Tipo as Tipo,
		dt.SE as SE,
        dt.Zona as Zona,
		dt.Sector as Sector,
		dt.Libro as Libro,
		dt.FechaEmisionDoc as FechaEmisionDoc,
		dt.FechaTrabajo as FechaTrabajo,
		dt.FechaAsignacion as FechaAsignacion,
		dt.FechaEjecucion as FechaEjecucion,
		dt.FechaLimiteCargo as FechaLimiteCargo,
		dt.FechaEntregaASeal as FechaEntregaASeal,
		dt.Estado as Estado,
        case
			when dt.Estado=1 then "Doc. Registrado"
            when dt.Estado=2 then "Doc. Asignado"
            when dt.Estado=3 then "Doc. Rezagado"
            when dt.Estado=4 then "Doc. E. Cliente"
            when dt.Estado=5 then "Doc.R.E. a Seal"
            when dt.Estado=6 then "Doc. E. Seal"
            else "Desconocido"
		end as NombreEstado,
        dt.CodigoSeal as CodigoSeal, 
        case
			when dt.CodigoSeal=10 then "Con firma"
            when dt.CodigoSeal=11 then "Sin Firma"
            when dt.CodigoSeal=12 then "Ausente"
            when dt.CodigoSeal=13 then "No Ubicado"
            when dt.CodigoSeal=14 then "Rechazado"
            when dt.CodigoSeal=15 then "Terreno Baldio"
            when dt.CodigoSeal=16 then "NIS no corresponde"
            when dt.CodigoSeal=17 then "Construccion Paralizada"	
            else "-"
		end as NombreCodigoSeal,
		dt.Observaciones as Observaciones
	from DocumentosTrabajo as dt
	left join TDD_Detalle as TDDD on TDDD.idTDD_Detalle=dt.IdTDD_Detalle
    -- left join accsac_personal_acc.personal_acc as ac on ac.id=dt.IdNotificador
    left join AccesoLogin as ac on ac.idAccesoLogin=dt.IdNotificador
	left join TiposAcceso as ta on ta.idTiposAcceso=ac.TipoAcceso
	-- Aqui van las condiciones
	where IF(varTDD_DetalleID != 0 or varTDD_DetalleID is null, dt.IdTDD_Detalle=varTDD_DetalleID, 1=1)
			and IF(varPersonalID != 0 or varPersonalID is null, dt.IdNotificador=varPersonalID, 1=1)
			and IF(varFechaInicial != '' and varFechaFinal!='', dt.FechaEmisionDoc>=varFechaInicial and dt.FechaEmisionDoc<=varFechaFinal, 1=1)
			and IF(varEstado != 0 or varEstado is null, dt.Estado=varEstado, 1=1)
			and IF(varCodigoSeal != 0 or varCodigoSeal is null, dt.CodigoSeal=varCodigoSeal, 1=1)
			and IF(varFiltro != 0,
					-- 1=Documentos sin asignar, solo registrado
                    -- 2=Documentos aisgnados, solo registrado
					if(varFiltro=1,dt.IdNotificador is null,
						if(varFiltro=2,dt.IdNotificador is not null,
							1=1
						)
					),
					1=1
				)
			and IF(varDatoBuscar != '' and (varBuscarEn=0 or varBuscarEn is null),
									dt.idDocumentosTrabajo like CONCAT('%',varDatoBuscar,'%')
									or dt.ContratoID like CONCAT('%',varDatoBuscar,'%')
									or dt.NroDocumento like concat('%',varDatoBuscar,'%')
									or dt.Observaciones like concat('%',varDatoBuscar,'%')									
									,if(varBuscarEn=1,dt.idDocumentosTrabajo like CONCAT('%',varDatoBuscar,'%'),
										if(varBuscarEn=2,dt.ContratoID like CONCAT('%',varDatoBuscar,'%'),
											if(varBuscarEn=3,dt.NroDocumento like CONCAT('%',varDatoBuscar,'%'),
												if(varBuscarEn=4,dt.NombreCliente like CONCAT('%',varDatoBuscar,'%'),
													1=1			
												)
											)
										)
									)
				)
	order by dt.idDocumentosTrabajo desc
	limit varPaginaActual,varPaginasMostrar;
END