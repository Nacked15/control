<?php

class PadrinosModel
{
	public static function getActiveSponsors() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT *
                FROM sponsors
                WHERE sp_status = 1;";
        $query = $database->prepare($sql);
        $query->execute();    

        return $query->fetchAll();
    }

    public static function getInactiveSponsors() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT *
                FROM sponsors
                WHERE sp_status = 0;";
        $query = $database->prepare($sql);
        $query->execute();    

        return $query->fetchAll();
    }

    public static function addNewSponsor($name, $surname, $type, $email, $description) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO sponsors(sp_name, sp_surname, sp_type, sp_email, sp_description) VALUES(:name, :surname, :type, :email, :description);";
        $query = $database->prepare($sql);
        $query->execute(array(':name' => $name, ':surname' => $surname, ':type' => $type, ':email' => $email, ':description' => $description));    

        if ($query->rowCount() > 0) {
        	return 1;
        }
        return 0;
    }

    public static function updateSponsor($sponsor, $name, $surname, $type, $email, $description) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE sponsors 
		        SET sp_name = :name,
			        sp_surname = :surname,
			        sp_type = :type,
			        sp_email = :email,
			        sp_description = :description
			    WHERE sponsor_id = :sponsor;";
        $query = $database->prepare($sql);
        $update = $query->execute(array(':name' => $name, ':surname' => $surname, ':type' => $type, ':email' => $email, ':description' => $description));    

        if ($update) {
        	return 1;
        }
        return 0;
    }

    public static function setActiveSponsor($sponsor) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE sponsors 
		        SET sp_status = 1,
			    WHERE ;";
        $query = $database->prepare($sql);
        $update = $query->execute(array(':name' => $name, ':surname' => $surname, ':type' => $type, ':email' => $email, ':description' => $description));    

        if ($update) {
        	return 1;
        }
        return 0;
    }

    public static function deleteSponsor($sponsor){
    	$database = DatabaseFactory::getFactory()->getConnection();

    	$delete = $database->prepare("DELETE sponsors WHERE sponsor_id = :sponsor;");
    	$delete->execute(array(':sponsor' => $sponsor));

    	if ($delete->rowCount() > 0) {
    		return 1;
    	}
    	return 0;
    }
}
