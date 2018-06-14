CREATE PROCEDURE `DocumentosTrabajo_BusquedaAC_1_Cantidad` (
	IN varTDD_DetalleID int,
	IN varPersonalID int,
	IN varFechaInicial varchar(50),
	IN varFechaFinal varchar(50),
	IN varEstado int,
    IN varCodigoSeal int,
	IN varFiltro int,
	IN varDatoBuscar varchar(255),
	IN varBuscarEn int
)
BEGIN
	select
		count(*) as total
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
	order by dt.idDocumentosTrabajo desc;
END