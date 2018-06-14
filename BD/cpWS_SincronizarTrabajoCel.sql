CREATE PROCEDURE `WS_SincronizarTrabajoCel` (
	IN varPersonalID int
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
		dt.CodBarra as CodBarra,
		dt.NroDocumento as NroDocumento,
		dt.NombreCliente as NombreCliente,
		dt.Direccion as Direccion,
		dt.FechaTrabajo as FechaTrabajo,
		dt.FechaAsignacion as FechaAsignacion,
		dt.FechaEjecucion as FechaEjecucion,
		dt.Estado as Estado,
		cm.NombresDuenio as CMNombreCliente,
		cm.DireccionMedidor as CMDireccionMedidor,
		cm.Sed as CMSed,
		cm.Longitud as CMLongitud,
		cm.Latitud as CMLatitud,
        case
			when dt.Estado=1 then "Doc. Registrado"
            when dt.Estado=2 then "Doc. Asignado"
            when dt.Estado=3 then "Doc. Rezagado"
            when dt.Estado=4 then "Doc. E. Cliente"
            when dt.Estado=5 then "Doc.R.E. a Seal"
            when dt.Estado=6 then "Doc. E. Seal"
            else "Desconocido"
		end as NombreEstado
	from DocumentosTrabajo as dt
	left join TDD_Detalle as TDDD on TDDD.idTDD_Detalle=dt.IdTDD_Detalle
    left join accsac_personal_acc.personal_acc as ac on ac.id=dt.IdNotificador
    left join accsac_seal_gen.ContratosMedidores as cm on cm.NroContrato=dt.ContratoID
	-- Aqui van las condiciones
	where dt.IdNotificador=varPersonalID and dt.Estado<=3
	order by dt.idDocumentosTrabajo desc;
END