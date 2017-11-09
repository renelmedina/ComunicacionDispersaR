CREATE PROCEDURE `ContratosMedidores_Busqueda` (
	IN varNroContrato varchar(10),
	IN varZonaID int,
	IN varSectorID int,
	IN varRutaID int,
	IN varHoja varchar(10),
	IN varTipoID int,
	IN varDatoBuscar varchar(255),
	IN varBuscarEn int,
	IN varPaginaActual int,
	IN varPaginasMostrar int
)
BEGIN
	select
		cm.NroContrato as NroContrato,
		cm.Sector as SectorID,
		sec.NroSector as NroSector,
		sec.NombreSector as NombreSector,
		cm.Zona as ZonaID,
		zona.NroZona as NroZona,
		zona.NombreZona as NombreZona,
		cm.Ruta as RutaID,
		ruta.NroRuta as NroRuta,
		ruta.NombreRuta as NombreRuta,
		cm.Hoja as Hoja,
		cm.Nim as Nim,
		cm.TipoID as TipoID,
		tc.NombreTipo as NombreTipo,
		cm.NombresDuenio as NombresDuenio,
		cm.DireccionMedidor as DireccionMedidor,
		cm.Sed as Sed,
		cm.Longitud as Longitud,
		cm.Latitud as Latitud
	from ContratosMedidores as cm
	left join Zona as zona on zona.idZona=cm.Zona
	left join Sector as sec on sec.idSector=cm.Sector
	left join Ruta as ruta on ruta.idRuta=cm.Ruta
	left join TipoContrato as tc on tc.idTipoContrato=cm.TipoID
	-- Aqui van las condiciones
	where IF(varZonaID != 0 or varZonaID is null, cm.Zona=varZonaID, 1=1)
			and IF(varSectorID != 0 or varSectorID is null, cm.Sector=varSectorID, 1=1)
			and IF(varRutaID != 0 or varRutaID is null, cm.Ruta=varRutaID, 1=1)
			and IF(varHoja != 0 or varHoja is null, cm.IdTipoCodigo=varHoja, 1=1)
			and IF(varTipoID != 0 or varTipoID is null, cm.TipoID=varTipoID, 1=1)
			and IF(varDatoBuscar != "" and (varBuscarEn=0 or varBuscarEn is null),
									cm.idContratosMedidores like CONCAT('%',varDatoBuscar,'%')
									or cm.Hoja like CONCAT('%',varDatoBuscar,'%')
									or cm.Nim like concat('%',varDatoBuscar,'%')
									or cm.NombresDuenio like concat('%',varDatoBuscar,'%')
									or cm.DireccionMedidor like concat('%',varDatoBuscar,'%')
									or cm.Sed like concat('%',varDatoBuscar,'%')
									or cm.Longitud like concat('%',varDatoBuscar,'%')
									or cm.Latitud like concat('%',varDatoBuscar,'%')										
									, if(varBuscarEn=1,cm.Hoja like CONCAT('%',varDatoBuscar,'%'), 
										if(varBuscarEn=2,cm.Nim like CONCAT('%',varDatoBuscar,'%'),
											if(varBuscarEn=3,cm.NombresDuenio like CONCAT('%',varDatoBuscar,'%'),
												if(varBuscarEn=4,cm.DireccionMedidor like CONCAT('%',varDatoBuscar,'%'),
													if(varBuscarEn=5,cm.Sed like CONCAT('%',varDatoBuscar,'%'),
														if(varBuscarEn=6,cm.Longitud like CONCAT('%',varDatoBuscar,'%'),
															if(varBuscarEn=7,cm.Latitud like CONCAT('%',varDatoBuscar,'%'),
																1=1
															)
														)
													)
												)
											)
										)
									)
				)
	order by cm.idContratosMedidores desc
	limit varPaginaActual,varPaginasMostrar;
END