CREATE PROCEDURE `AccesosLogin_PersonalID` (
	in varAccesoLoginID int,
	in varPersonalID varchar(45)
)
BEGIN
	update AccesoLogin set
		PersonalID=varPersonalID
	where idAccesoLogin=varAccesoLoginID;
END