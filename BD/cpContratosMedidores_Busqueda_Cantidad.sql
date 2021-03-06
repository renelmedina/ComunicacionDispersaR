CREATE PROCEDURE `ContratosMedidores_Busqueda_Cantidad` (
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
	from ContratosMedidores as cm
	left join Zona as zona on zona.idZona=cm.Zona
	left join Sector as sec on sec.idSector=cm.Sector
	left join Libro as libro on libro.idLibro=cm.Libro
	left join Hoja as hoja on hoja.idHoja=cm.Hoja
	left join TipoContrato as tc on tc.idTipoContrato=cm.TipoID
	-- Aqui van las condiciones
	where IF(varZonaID != 0 or varZonaID is null, cm.Zona=varZonaID, 1=1)
			and IF(varSectorID != 0 or varSectorID is null, cm.Sector=varSectorID, 1=1)
			and IF(varLibroID != 0 or varLibroID is null, cm.Libro=varLibroID, 1=1)
			and IF(varHoja != 0 or varHoja is null, cm.Hoja=varHoja, 1=1)
			and IF(varTipoID != 0 or varTipoID is null, cm.TipoID=varTipoID, 1=1)
			and IF(varDatoBuscar != '' and (varBuscarEn=0 or varBuscarEn is null),
									cm.idContratosMedidores like CONCAT('%',varDatoBuscar,'%')
									or cm.Hoja like CONCAT('%',varDatoBuscar,'%')
									or cm.Nim like concat('%',varDatoBuscar,'%')
									or cm.NombresDuenio like concat('%',varDatoBuscar,'%')
									or cm.DireccionMedidor like concat('%',varDatoBuscar,'%')
									or cm.Sed like concat('%',varDatoBuscar,'%')
									or cm.Longitud like concat('%',varDatoBuscar,'%')
									or cm.Latitud like concat('%',varDatoBuscar,'%')										
									,if(varBuscarEn=1,cm.Nim like CONCAT('%',varDatoBuscar,'%'),
										if(varBuscarEn=2,cm.NombresDuenio like CONCAT('%',varDatoBuscar,'%'),
											if(varBuscarEn=3,cm.DireccionMedidor like CONCAT('%',varDatoBuscar,'%'),
												if(varBuscarEn=4,cm.Sed like CONCAT('%',varDatoBuscar,'%'),
													if(varBuscarEn=5,cm.Longitud like CONCAT('%',varDatoBuscar,'%'),
														if(varBuscarEn=6,cm.Latitud like CONCAT('%',varDatoBuscar,'%'),
															1=1
														)
													)
												)
											)
										)
									)
				)
	order by cm.idContratosMedidores desc;
END