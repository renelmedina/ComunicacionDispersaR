CREATE PROCEDURE `ListarTodo_TipoDocumentoDetalle` (
	IN varTipoDocumentoID int
)
BEGIN
	select
		tdd.idTipoDocumentoDetalle as TipoDocumentoDetalleID,
		tdd.IdTipoDocumento as TipoDocumentoID,
		td.Nombre as NombreTD,
		tdd.Nombre as NombreTDD,
		tdd.Descripcion as DescripcionTDD,
		tdd.ImagenReferencial as ImagenReferencialTDD
	from TipoDocumentoDetalle as tdd
	left join TipoDocumento as td on td.idTipoDocumento=tdd.IdTipoDocumento
	-- Aqui van las condiciones
	where IF(varTipoDocumentoID != 0 or varTipoDocumentoID is null, tdd.IdTipoDocumento=varTipoDocumentoID, 1=1)
	order by cm.idContratosMedidores desc;
END