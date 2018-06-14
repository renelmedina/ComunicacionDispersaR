CREATE PROCEDURE `InsertarContrato` (
	in varNroContrato varchar(10),
    in varNroSector varchar(10),
    in varNroZona varchar(10),
    in varNroLibro varchar(10),
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
	#Declaracion de variables
	set @SectorID=null;
	set @ZonaID=null;
	set @LibroID=null;
	set @HojaID=null;
	# Esta line es importante para que permita hacer actualizaciones en la clausula WHERE sin usan la clave primaria
	SET SQL_SAFE_UPDATES=0;
	if not exists(select 1 from ContratosMedidores where NroContrato=varNroContrato) then
		if not exists(select 1 from Sector where NroSector=varNroSector)then
			if not exists(select 1 from Zona where NroZona=varNroZona)then
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 1 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 2 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que existe el libro, pero no la hoja, se procede a crear una.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 3 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 4 as demo;
					end if;
				end if;
			else
				# La Zona existe, ahora verificaremos que lo demas exista y si no se procede a crear una.
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, solo la zona existe
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 5 as demo;
					else
						# Significa que no existe libro, solo existe la hoja.
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 7 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 8 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 9 as demo;
					end if;
				end if;
			end if;
		else
			#El Sector existe, verificamos que lo demas existe y si no, les creamos
			if not exists(select 1 from Zona where NroZona=varNroZona)then
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 10 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 11 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 12 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 13 as demo;
					end if;
				end if;
			else
				# La Zona existe, ahora verificaremos que lo demas exista y si no se procede a crear una.
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 14 as demo;	
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 15 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );	
			            select 16 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Seleccionando Zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Insertando el contrato
						insert into ContratosMedidores(
							NroContrato,
							Sector,
			                Zona,
			                Libro,
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
		            		@SectorID,
		            		@ZonaID,
		            		@LibroID,
		            		@HojaID,
		            		varNim,
		            		varTipoID,
		            		varNombresDuenio,
		            		varDireccionMedidor,
		            		varSed,
							varLongitud,
							varLatitud
			            );
			            select 17 as demo;
					end if;
				end if;
			end if;
		end if;
	else
		# El contrato existe, verificamos si todo lo demas existe y si no se crean.
		# comenzaremos a enumerar los errores desde el nro 20.
		if not exists(select 1 from Sector where NroSector=varNroSector)then
			if not exists(select 1 from Zona where NroZona=varNroZona)then
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 20 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 21 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 22 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 23 as demo;
					end if;
				end if;
			else
				# La Zona existe, ahora verificaremos que lo demas exista y si no se procede a crear una.
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 24 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 25 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 26 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Seleccionando zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Insertando Sector
						insert into Sector(
							NroSector,
							NombreSector,
							DescripcionSector
						)values(
							varNroSector,
							varNroSector,
							varNroSector
							
						);
						select @SectorID:= max(idSector) from Sector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 27 as demo;
					end if;
				end if;
			end if;
		else
			#El Sector existe, verificamos que lo demas existe y si no, les creamos
			if not exists(select 1 from Zona where NroZona=varNroZona)then
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 28 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 29 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 30 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Insertando zona nueva
						insert into Zona(
							NroZona,
							NombreZona,
							DescripcionZona
						)values(
							varNroZona,
							varNroZona,
							varNroZona
						);
						select @ZonaID:= max(idZona) from Zona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 31 as demo;
					end if;
				end if;
			else
				# La Zona existe, ahora verificaremos que lo demas exista y si no se procede a crear una.
				if not exists(select 1 from Libro where NroLibro=varNroLibro)then
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 32 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Insertar Libro
						insert into Libro(
							NroLibro,
							NombreLibro,
							DescripcionLibro
						)values(
							varNroLibro,
							varNroLibro,
							varNroLibro
						);
						select @LibroID:= max(idLibro) from Libro;
						# Seleccionamos la Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 33 as demo;
					end if;
				else
					# El Libro existe, verificamos si existe la hoja y si no, creamos una hoja nueva
					if not exists(select 1 from Hoja where NroHoja=varHoja)then
						# Significa que no existe ningun dato de este contrato, se procede a crear todo
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Selecionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Insertar Hoja
						insert into Hoja(
							NroHoja,
							NombreHoja,
							DescripcionHoja
						)values(
							varHoja,
							varHoja,
							varHoja
						);
						select @HojaID:= max(idHoja) from Hoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 34 as demo;
					else
						# Significa que no existe ningun dato de este contrato, solo existe la hoja.
						# Seleccionando la zona
						select @ZonaID:= idZona from Zona where NroZona=varNroZona;
						# Selecionando Sector
						select @SectorID:= idSector from Sector where NroSector=varNroSector;
						# Seleccionando Libro
						select @LibroID:= idLibro from Libro where NroLibro=varNroLibro;
						# Seleccionando Hoja
						select @HojaID:= idHoja from Hoja where NroHoja=varHoja;
						# Actualizando el contrato
						update ContratosMedidores set
							NroContrato=varNroContrato,
							Sector=@SectorID,
			                Zona=@ZonaID,
			                Libro=@LibroID,
			                Hoja=@HojaID,
			                Nim=varNim,
			                TipoID=varTipoID,
			                NombresDuenio=varNombresDuenio,
			                DireccionMedidor=varDireccionMedidor,
			                Sed=varSed,
			                Longitud=varLongitud,
			                Latitud=varLatitud
			            where NroContrato=varNroContrato;
			            select 35 as demo;
					end if;
				end if;
			end if;
		end if;
	end if;
	# Esta linea es importante para que permita hacer las actualizaciones en  con clave primaria
	SET SQL_SAFE_UPDATES=1;
    #Ejemplo de uso en PHP
    /*if($resultado['demo']==0){
		echo 'Se registro correctamente';
    }
    if($resultado['demo']==1){
		echo 'ya existe el contrato, no puede haber duplicados';
    }*/
    /*
    Codigos de consulta
    si= si existe el dato, solo se actualizara el dato.
    no= el dato no existe, se procede a crearlo.
    ╔══════════════════════════════════════════════════════╗
    ║CONTRATO	SESCTOR 	ZONA 	LIBRO 	HOJA 	CODIGO ║	
    ║═════════╬══════════╬════════╬═══════╬═══════╬════════║
    ║  no     ║    no    ║   no   ║  no   ║  no   ║   1    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    no    ║   no   ║  no   ║  si   ║   2    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    no    ║   no   ║  si   ║  no   ║   3    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    no    ║   no   ║  si   ║  si   ║   4    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    no    ║   si   ║  no   ║  no   ║   5    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    no    ║   si   ║  no   ║  si   ║   7    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    no    ║   si   ║  si   ║  no   ║   8    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    no    ║   si   ║  si   ║  si   ║   9    ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   no   ║  no   ║  no   ║   10   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   no   ║  no   ║  si   ║   11   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   no   ║  si   ║  no   ║   12   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   no   ║  si   ║  si   ║   13   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   si   ║  no   ║  no   ║   14   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   si   ║  no   ║  si   ║   15   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   si   ║  si   ║  no   ║   16   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  no     ║    si    ║   si   ║  si   ║  si   ║   17   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   no   ║  no   ║  no   ║   20   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   no   ║  no   ║  si   ║   21   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   no   ║  si   ║  no   ║   22   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   no   ║  si   ║  si   ║   23   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   si   ║  no   ║  no   ║   24   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   si   ║  no   ║  si   ║   25   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   si   ║  si   ║  no   ║   26   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    no    ║   si   ║  si   ║  si   ║   27   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   no   ║  no   ║  no   ║   28   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   no   ║  no   ║  si   ║   29   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   no   ║  si   ║  no   ║   30   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   no   ║  si   ║  si   ║   31   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   si   ║  no   ║  no   ║   32   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   si   ║  no   ║  si   ║   33   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   si   ║  si   ║  no   ║   34   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    ║  si     ║    si    ║   si   ║  si   ║  si   ║   35   ║
    ╠═════════╬══════════╬════════╬═══════╬═══════╬════════╣
    */
END