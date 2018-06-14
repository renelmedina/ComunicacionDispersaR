-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `ContratosMedidores_Busqueda_Cantidad2` (
	IN varTipoID int,
	IN varZonaNro varchar(45),
	IN varSectorNro varchar(45),
	IN varLibroNro varchar(45),
	IN varHojaNro varchar(45),
	IN varDatoBuscar varchar(255),
	IN varBuscarEn int,
	IN varPaginaActual int,
	IN varPaginasMostrar int
)
BEGIN
	select
		count(*) as total
	from ContratosMedidores as cm
	left join TipoContrato as tc on tc.idTipoContrato=cm.TipoID
	-- Aqui van las condiciones
	where IF(varZonaNro != 0 or varZonaNro is null, cm.Zona=varZonaNro, 1=1)
			and IF(varSectorNro != 0 or varSectorNro is null, cm.Sector=varSectorNro, 1=1)
			and IF(varLibroNro != 0 or varLibroNro is null, cm.Libro=varLibroNro, 1=1)
			and IF(varHojaNro != 0 or varHojaNro is null, cm.Hoja=varHojaNro, 1=1)
			and IF(varTipoID != 0 or varTipoID is null, cm.TipoID=varTipoID, 1=1)
			and IF(varDatoBuscar != '' and (varBuscarEn=0 or varBuscarEn is null),
									# cm.idContratosMedidores like CONCAT('%',varDatoBuscar,'%')
									cm.NroContrato like CONCAT('%',varDatoBuscar,'%')
									or cm.Hoja like CONCAT('%',varDatoBuscar,'%')
									or cm.Nim like concat('%',varDatoBuscar,'%')
									or cm.NombresDuenio like concat('%',varDatoBuscar,'%')
									or cm.DireccionMedidor like concat('%',varDatoBuscar,'%')
									or cm.Sed like concat('%',varDatoBuscar,'%')
									or cm.Longitud like concat('%',varDatoBuscar,'%')
									or cm.Latitud like concat('%',varDatoBuscar,'%')
									,if(varBuscarEn=1,cm.NroContrato like CONCAT('%',varDatoBuscar,'%'),									
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
	order by cm.idContratosMedidores desc;
END