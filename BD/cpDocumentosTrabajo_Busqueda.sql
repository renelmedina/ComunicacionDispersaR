CREATE PROCEDURE `DocumentosTrabajo_Busqueda` (
	IN varTDD_DetalleID int,
	IN varTipoID int,
	IN varZonaID int,
	IN varSectorID int,
	IN varLibroID int,
	IN varHoja int,
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
        ac.nombre_completo as NombreCompletoNotificador,
        ac.apellido_paterno as ApellidoPaternoNotificador,
        ac.apellido_materno as ApellidoMaternoNotificador,
		dt.ContratoID as NroContrato,
		cm.NombresDuenio as CMNombreCliente,
		cm.DireccionMedidor as CMDireccionMedidor,
		cm.Sed as CMSed,
		cm.Longitud as CMLongitud,
		cm.Latitud as CMLatitud,
		zona.NroZona as zonaNroZona,
		zona.NombreZona as zonaNombreZona,
		sector.NroSector as sectorNroSector,
		sector.NombreSector as sectorNombreSector,
		libro.NroLibro as libroNroLibro,
		libro.NombreLibro as libroNombreLibro,
		hoja.NroHoja as hojaNroHoja,
		hoja.NombreHoja as hojaNombreHoja,
		tc.NombreTipo as tcNombreTipo,/*Tipo de Contrato*/
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
		dt.Observaciones as Observaciones
	from DocumentosTrabajo as dt
	left join TDD_Detalle as TDDD on TDDD.idTDD_Detalle=dt.IdTDD_Detalle
    left join accsac_personal_acc.personal_acc as ac on ac.id=dt.IdNotificador
	left join accsac_seal_gen.ContratosMedidores as cm on cm.NroContrato=dt.ContratoID
	left join accsac_seal_gen.Zona as zona on zona.idZona=cm.Zona
	left join accsac_seal_gen.Sector as sector on sector.idSector=cm.Sector
	left join accsac_seal_gen.Libro as libro on libro.idLibro=cm.Libro
	left join accsac_seal_gen.Hoja as hoja on hoja.idHoja=cm.Hoja
	left join accsac_seal_gen.TipoContrato as tc on tc.idTipoContrato=cm.TipoID
	-- Aqui van las condiciones
	where IF(varTDD_DetalleID != 0 or varTDD_DetalleID is null, dt.IdTDD_Detalle=varTDD_DetalleID, 1=1)
			and IF(varZonaID != 0 or varZonaID is null, cm.Zona=varZonaID, 1=1)
			and IF(varSectorID != 0 or varSectorID is null, cm.Sector=varSectorID, 1=1)
			and IF(varLibroID != 0 or varLibroID is null, cm.Libro=varLibroID, 1=1)
			and IF(varHoja != 0 or varHoja is null, cm.Hoja=varHoja, 1=1)
			and IF(varTipoID != 0 or varTipoID is null, cm.TipoID=varTipoID, 1=1)
			and IF(varDatoBuscar != '' and (varBuscarEn=0 or varBuscarEn is null),
									dt.idDocumentosTrabajo like CONCAT('%',varDatoBuscar,'%')
									or dt.ContratoID like CONCAT('%',varDatoBuscar,'%')
									or dt.CodBarra like concat('%',varDatoBuscar,'%')
									or dt.NroDocumento like concat('%',varDatoBuscar,'%')
									or dt.NombreCliente like concat('%',varDatoBuscar,'%')
									or dt.Direccion like concat('%',varDatoBuscar,'%')
									or dt.SE like concat('%',varDatoBuscar,'%')
									or dt.Zona like concat('%',varDatoBuscar,'%')
									or dt.Sector like concat('%',varDatoBuscar,'%')
									or dt.Libro like concat('%',varDatoBuscar,'%')
									or dt.Observaciones like concat('%',varDatoBuscar,'%')									
									,if(varBuscarEn=1,dt.idDocumentosTrabajo like CONCAT('%',varDatoBuscar,'%'),
										if(varBuscarEn=2,dt.ContratoID like CONCAT('%',varDatoBuscar,'%'),
											if(varBuscarEn=3,dt.CodBarra like CONCAT('%',varDatoBuscar,'%'),
												if(varBuscarEn=4,dt.NroDocumento like CONCAT('%',varDatoBuscar,'%'),
													if(varBuscarEn=5,dt.NombreCliente like CONCAT('%',varDatoBuscar,'%'),
														if(varBuscarEn=6,dt.Direccion like CONCAT('%',varDatoBuscar,'%'),
															if(varBuscarEn=7,dt.SE like CONCAT('%',varDatoBuscar,'%'),
																if(varBuscarEn=8,dt.Zona like CONCAT('%',varDatoBuscar,'%'),
																	if(varBuscarEn=9,dt.Sector like CONCAT('%',varDatoBuscar,'%'),
																		if(varBuscarEn=10,dt.Libro like CONCAT('%',varDatoBuscar,'%'),
																			if(varBuscarEn=11,dt.Observaciones like CONCAT('%',varDatoBuscar,'%'),
																				1=1
																			)
																		)
																	)
																)
															)
														)
													)
												)
											)
										)
									)
				)
	order by dt.idDocumentosTrabajo desc
	limit varPaginaActual,varPaginasMostrar;
END