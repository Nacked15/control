<?php

class MaestroModel
{

    public static function getTeachers() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, name, lastname, user_email, user_avatar
                FROM users
                WHERE user_type = 3;";
        $query = $database->prepare($sql);
        $query->execute();    

        return $query->fetchAll();
    }

    public static function getTeacher($id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT user_id, name, lastname, user_name, user_email
                FROM users 
                WHERE user_id = :id AND user_type = 3;";
        $query = $database->prepare($sql);
        $query->execute(array(':id' => $id));

        return $query->fetch();
    }

    public static function updateTeacher($teacher, $name, $lastname, $username, $useremail){
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE users SET name = :name,
                                                      lastname = :lastname,
                                                      user_name = :username,
                                                      user_email = :useremail
                                    WHERE user_id = :teacher
                                      AND user_type = 3;");
        $update = $query->execute(array(':name'      => $name,
                                        ':lastname'  => $lastname,
                                        ':username'  => $username,
                                        ':useremail' => $useremail,
                                        ':teacher'   => $teacher));

        if ($update) {
            Session::add('feedback_positive','Datos del maestro actualizados correctamente.');
        } else {
            Session::add('feedback_negative','No se pudo actualizar los datos del maestro.');
        }
    }

}
