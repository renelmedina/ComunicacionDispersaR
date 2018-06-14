CREATE PROCEDURE `ListarTodoTDD_Detalle` (
	IN varTipoDocumentoDetalleID int
)
BEGIN
	select
		tddd.idTDD_Detalle as DetalleTDD_ID,
		td.idTipoDocumento as AreaID,
		td.Nombre as AreaNombre,
		tddd.IdTipoDocumentoDetalle as TipoDocumentoID,
		tdd.Nombre as NombreTD,
		tddd.Nombre as NombreTDD,
		tddd.Descripcion as DescripcionTDD, 
		tddd.ImagenReferencial as ImagenReferencialTDDD
	from TDD_Detalle as tddd
	left join TipoDocumentoDetalle as tdd on tdd.idTipoDocumentoDetalle=tddd.IdTipoDocumentoDetalle
	left join TipoDocumento as td on td.idTipoDocumento=tdd.IdTipoDocumento
	-- Aqui van las condiciones
	where IF(varTipoDocumentoDetalleID != 0 or varTipoDocumentoDetalleID is null, tddd.IdTipoDocumentoDetalle=varTipoDocumentoDetalleID, 1=1)
	order by tddd.idTDD_Detalle desc;
END