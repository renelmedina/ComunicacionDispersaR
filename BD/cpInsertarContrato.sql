CREATE PROCEDURE `InsertarContrato` (
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
	if not exists(select 1 from ContratosMedidores where NroContrato=varNroContrato) then
		insert into ContratosMedidores(
				NroContrato,
				Sector,
                Zona,
                Ruta,
                Hoja,
                Nim,
                TipoID,
                NombresDuenio,
                DireccionMedidor,
                Sed,
                Longitud,
                Latitud
            )values(
				varNroContrato,
                varSectorID,
                varZonaID,
                varRutaID,
                varHoja,
                varNim,
                varTipoID,
                varNombresDuenio,
                varDireccionMedidor,
                varSed,
                varLongitud,
                varLatitud
            );
		# errno 0, significa que se ingreso con normalidad
		select 0 as errno;
	else
		# errno 1, significa que ya existe el numero de contrato.
		select 1 as errno;
	end if;
    #Ejemplo de uso en PHP
    /*if($resultado['errno']==0){
		echo 'Se registro correctamente';
    }
    if($resultado['errno']==1){
		echo 'ya existe el contrato, no puede haber duplicados';
    }*/
END