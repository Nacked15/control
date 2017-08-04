<?php

class MaestroModel
{

    public static function getTeachers() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, name, lastname, user_email
                FROM users
                WHERE user_type = 3;";
        $query = $database->prepare($sql);
        $query->execute();    

        return $query->fetchAll();
    }

    public static function getTeacher($id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT user_id, name, lastname, user_email
                FROM users 
                WHERE user_id = :id AND user_type = 3;";
        $query = $database->prepare($sql);
        $query->execute(array(':id' => $id));

        return $query->fetch();
    }

}
