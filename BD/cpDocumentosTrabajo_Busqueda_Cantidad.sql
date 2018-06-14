CREATE PROCEDURE `DocumentosTrabajo_Busqueda_Cantidad` (
	IN varTDD_DetalleID int,
	IN varTipoID int,
	IN varZonaID int,
	IN varSectorID int,
	IN varLibroID int,
	IN varHoja int,
	IN varDatoBuscar varchar(255),
	IN varBuscarEn int
)
BEGIN
	select
		count(*) as total
	from DocumentosTrabajo as dt
	left join TDD_Detalle as TDDD on TDDD.idTDD_Detalle=dt.IdTDD_Detalle
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
	order by dt.idDocumentosTrabajo desc;
END