CREATE PROCEDURE `ModificarHoja` (
	in HojaID int,
    in varNroHoja varchar(10),
	in varNombreHoja varchar(45),
    in varDescripcionHoja text
)
BEGIN
	update Hoja set
		NroHoja=varNroHoja,
		NombreHoja=varNombreHoja,
        DescripcionHoja=varDescripcionHoja
	where idHoja=HojaID;
END