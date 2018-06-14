-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `InsertarContratos2` (
	in varOrden varchar(45),
    in varNroSector varchar(45),
    in varNroZona varchar(45),
    in varNroLibro varchar(45),
    in varHoja varchar(45),
	in varNroContrato varchar(45),
    in varNim varchar(45),
    in varTipoID int,
    in varNombresDuenio varchar(255),
    in varDireccionMedidor varchar(255),
    in varSed varchar(45),
	in varLatitud varchar(45),
    in varLongitud varchar(45)
    
)
BEGIN
	# Declaracion de variables
	# Esta line es importante para que permita hacer actualizaciones en la clausula WHERE sin usan la clave primaria
	# SET SQL_SAFE_UPDATES=0;
	if not exists(select 1 from ContratosMedidores where NroContrato=varNroContrato) then
		# No hay contrato registrado
		insert into ContratosMedidores(
			Orden,
			Sector,
            Zona,
            Libro,
            Hoja,
			NroContrato,
            Nim,
            TipoID,
            NombresDuenio,
            DireccionMedidor,
            Sed,
			Latitud,
            Longitud
            
        )values(
        	varOrden,
    		varNroSector,
    		varNroZona,
    		varNroLibro,
    		varHoja,
    		varNroContrato,
    		varNim,
    		varTipoID,
    		varNombresDuenio,
    		varDireccionMedidor,
    		varSed,
			varLatitud,
			varLongitud
        );
	else
		# El contrato existe, verificamos si todo lo demas existe y si no se crean.
		update ContratosMedidores set
			Orden=varOrden,
			Sector=varNroSector,
            Zona=varNroZona,
            Libro=varNroLibro,
            Hoja=varHoja,
			NroContrato=varNroContrato,
            Nim=varNim,
            TipoID=varTipoID,
            NombresDuenio=varNombresDuenio,
            DireccionMedidor=varDireccionMedidor,
            Sed=varSed,
			Latitud=varLatitud,
            Longitud=varLongitud
            
        where NroContrato=varNroContrato;
	end if;
	# Esta linea es importante para que permita hacer las actualizaciones en  con clave primaria
	# SET SQL_SAFE_UPDATES=1;
    # Ejemplo de uso en PHP
    # if($resultado['demo']==0){
	#	echo 'Se registro correctamente';
    # }
    # if($resultado['demo']==1){
	#	echo 'ya existe el contrato, no puede haber duplicados';
    # }
END