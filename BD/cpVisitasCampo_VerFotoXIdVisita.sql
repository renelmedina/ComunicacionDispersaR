CREATE PROCEDURE `VisitasCampo_VerFotoXIdVisita` (
	in varVisitasCampoID int
)
BEGIN
	select 
		idFotosVisita,
		VisitasCampoID,
		Fecha,
		RutaFoto
	from FotosVisita
	where VisitasCampoID=varVisitasCampoID;
END
