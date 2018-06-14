CREATE PROCEDURE `VisitasCampo_Buscar_VerFotos` (
	in varDocumentosTrabajoID int,
	in varNotificadorID int,
	in varFechaInicial varchar(45),
	in varFechaFinal varchar(45),
	in varEstadoSeal varchar(45),
	in varDatoBuscar varchar(255),
	in varBuscarEn varchar(45)
	
)
BEGIN
	select
		fv.idFotosVisita, 
		vc.idVisitasCampo,
		vc.DocumentosTrabajoID,
        vc.NroSuministro,
		dt.ContratoID,
        fv.RutaFoto,
        fv.Fecha,
        fv.VisitasCampoID

	from FotosVisita as fv
	left join VisitasCampo as vc on vc.idVisitasCampo=fv.VisitasCampoID
	left join accsac_personal_acc.personal_acc as per on per.id=vc.IdNotificador
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
	order by vc.idVisitasCampo desc;
END