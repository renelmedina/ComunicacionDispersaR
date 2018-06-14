-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `DocumentosTrabajo_BusquedaXFechaSinAsignarMapa2` (
	IN varFechaInicio varchar(45),
	IN varFechaFin varchar(45)
)
BEGIN
	select
		dt.idDocumentosTrabajo as idDocumentosTrabajo,
		dt.IdTDD_Detalle as IdTDD_Detalle,
		TDDD.Nombre as NombreTDDD,
		dt.IdNotificador as IdNotificador,
		dt.ContratoID as NroContrato,
		(select ContratosMedidores.Latitud from accsac_seal_gen.ContratosMedidores where ContratosMedidores.NroContrato=NroContrato limit 1) as Latitud,
		(select ContratosMedidores.Longitud from accsac_seal_gen.ContratosMedidores where ContratosMedidores.NroContrato=NroContrato limit 1) as Longitud,
		(select ContratosMedidores.NombresDuenio from accsac_seal_gen.ContratosMedidores where ContratosMedidores.NroContrato=NroContrato limit 1) as NombresDuenio,
		(select ContratosMedidores.DireccionMedidor from accsac_seal_gen.ContratosMedidores where ContratosMedidores.NroContrato=NroContrato limit 1) as DireccionMedidor,
		(select ContratosMedidores.Sed from accsac_seal_gen.ContratosMedidores where ContratosMedidores.NroContrato=NroContrato limit 1) as Sed,
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
	where IF(varFechaInicio != '' and varFechaFin!='',DATE(dt.FechaEmisionDoc) between varFechaInicio and varFechaFin, 1=1)
    and dt.IdNotificador is null
	order by dt.idDocumentosTrabajo desc;
END