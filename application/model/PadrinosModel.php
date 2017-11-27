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

    public static function getAllSponsors(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM sponsors;";
        $query = $database->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0) {
            $sponsors = $query->fetchAll();

            echo '<div class="table-responsive card-primary">';
                echo '<table id="example" class="table table-bordered table-hover table-striped">';
                    echo '<thead>';
                        echo '<tr class="info">';
                            echo '<th>ID</th>';
                            echo '<th>Nombre</th>';
                            echo '<th>Apellido</th>';
                            echo '<th>Tipo</th>';
                            echo '<th>Correo Electronico</th>';
                            echo '<th>Descripción</th>';
                            echo '<th>Estatus</th>';
                            echo '<th>Alumnos Becados</th>';
                            echo '<th class="text-center">Opciones</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    $count = 1;
                    foreach ($sponsors as $sponsor) {
                        $status = $sponsor->sp_status === '1' ? 'Acivo' : 'Inactivo';
                        echo '<tr>';
                            echo '<td>'.$count++.'</td>';
                            echo '<td>'.$sponsor->sp_name.'</td>';
                            echo '<td>'.$sponsor->sp_surname.'</td>';
                            echo '<td>'.$sponsor->sp_type.'</td>';
                            echo '<td>'.$sponsor->sp_email.'</td>';
                            echo '<td>'.$sponsor->sp_description.'</td>';
                            echo '<td>'.$status.'</td>';
                            echo '<td>Alumnos Becados</td>';
                            echo '<td class="text-center">Opciones</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                echo '</table>';
            echo '</div>';
        } else {
            echo '<h4 class="text-center text-naatik subheader">No hay Padrinos registrados aún.</h4>';
        }
    }

    public static function addNewSponsor($name, $surname, $type, $email, $description, $becario) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO sponsors(sp_name, sp_surname, sp_type, sp_email, sp_description) 
                              VALUES(:name, :surname, :type, :email, :description);";
        $query = $database->prepare($sql);
        $query->execute(array(':name'    => $name, 
                              ':surname' => $surname, 
                              ':type'    => $type, 
                              ':email'     => $email, 
                              ':description' => $description));    

        if ($query->rowCount() > 0) {
            $padrino = $database->lastInsertId();
            $insert = $database->prepare("INSERT INTO becas(student_id, sponsor_id, period, granted_at) 
                                                      VALUES(:becario, :padrino, :periodo, :registro);");
            $insert->execute(array(':becario'  => $becario, 
                                   ':padrino'  => $padrino, 
                                   ':periodo'  => date('Y-m'), 
                                   ':registro' => H::getTime('Y-m-d')));
            if ($insert->rowCount() > 0) {
                return 1;
            }
        	return 2;
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
