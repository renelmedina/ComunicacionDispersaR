CREATE PROCEDURE `ModificarContrato` (
	in varContratosID int,
	in varNroContrato varchar(10),
    in varSectorID int,
    in varZonaID int,
    in varRutaID int,
    in varHoja varchar(10),
    in varNim varchar(10),
    in varTipoID int,
    in varNombresDuenio varchar(255),
    in varDireccionMedidor varchar(255),
    in varSed varchar(10),
    in varLongitud varchar(45),
    in varLatitud varchar(45)
)
BEGIN
	update ContratosMedidores set
		NroContrato=varNroContrato,
        Sector=varSectorID,
        Zona=varZonaID,
        Ruta=varRutaID,
        Hoja=varHoja,
        Nim=varNim,
        TipoID=varTipoID,
        NombresDuenio=varNombresDuenio,
        DireccionMedidor=varDireccionMedidor,
        Sed=varSed,
        Longitud=varLongitud,
        Latitud=varLatitud
	where idContratosMedidores=varContratosID;
        
END