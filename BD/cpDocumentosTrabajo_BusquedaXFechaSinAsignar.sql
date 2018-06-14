CREATE PROCEDURE `DocumentosTrabajo_BusquedaXFechaSinAsignar` (
	IN varFechaInicio date,
	IN varFechaFin date
)
BEGIN
	select
		dt.idDocumentosTrabajo as idDocumentosTrabajo,
		dt.IdTDD_Detalle as IdTDD_Detalle,
		TDDD.Nombre as NombreTDDD,
		dt.IdNotificador as IdNotificador,
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
	left join accsac_seal_gen.ContratosMedidores as cm on cm.NroContrato=dt.ContratoID
	left join accsac_seal_gen.Zona as zona on zona.idZona=cm.Zona
	left join accsac_seal_gen.Sector as sector on sector.idSector=cm.Sector
	left join accsac_seal_gen.Libro as libro on libro.idLibro=cm.Libro
	left join accsac_seal_gen.Hoja as hoja on hoja.idHoja=cm.Hoja
	left join accsac_seal_gen.TipoContrato as tc on tc.idTipoContrato=cm.TipoID
	-- Aqui van las condiciones
	where FechaEmisionDoc>=varFechaInicio and FechaEmisionDoc<=varFechaFin and dt.IdNotificador is null
	order by dt.idDocumentosTrabajo desc;
END
