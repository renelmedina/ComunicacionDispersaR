CREATE PROCEDURE `WS_Registrarfoto` (
  in varVisitasCampoID int,
  in varFecha datetime,
  in varRutaFoto varchar(225)
  
)
BEGIN
  insert into FotosVisita(
    VisitasCampoID,
    Fecha,
    RutaFoto
  )values(
    varVisitasCampoID,
    varFecha,
    varRutaFoto
  );
END
