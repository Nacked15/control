<?php

class MaestroModel
{

    public static function getTeachers() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, name, lastname, user_email, user_avatar
                FROM users
                WHERE user_type = 3
                  AND user_deleted = 0;";
        $query = $database->prepare($sql);
        $query->execute();    

        return $query->fetchAll();
    }

    public static function teachersTable($page){
        H::getLibrary('paginadorLib');
        $paginator = new \Paginador();
        $page      = (int)$page;
        $rows      = 10;

        $teachers  = self::getTeachers();
        
        if (count($teachers) > 0) {
            $maestros   = $paginator->paginar($teachers, $page, $rows);
            $counter    = $page > 0 ? (($page*$filas)-$filas) + 1 : 1;
            $paginacion = $paginator->getView('pagination_ajax', 'teachers');

            // Tabla de maestros
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-hover table-striped">';
                echo '<thead>';
                   echo '<tr class="info">';
                      echo '<th>ID</th>';
                      echo '<th>Foto</th>';
                      echo '<th>Nombre</th>';
                      echo '<th>Apellido</th>';
                      echo '<th>Correo Electronico</th>';
                      echo '<th class="text-center">Opciones</th>';
                   echo '</tr>';
                echo '</thead>';
                echo '<tbody>'; 
                    foreach ($maestros as $maestro) {
                        $img = $maestro->user_avatar === NULL ? 'male' : $maestro->user_avatar;
                        $file = Config::get('URL').Config::get('PATH_AVATAR_USER').$img;
                        $avatar = '<img class="foto-mini" src="'.$file.'.jpg" alt="avatar">';
                        echo '<tr>';
                        echo '<td>'.$maestro->user_id.'</td>';
                        echo '<td>'.$avatar.'</td>';
                        echo '<td>'.$maestro->name.'</td>';
                        echo '<td>'.$maestro->lastname.'</td>';
                        echo '<td>'.$maestro->user_email.'</td>';
                        echo '<td class="text-center">
                                <button type="button" 
                                        class="btn btn-xs btn-info btn-raised editTeacher"
                                        data-teacher="'.$maestro->user_id.'">
                                            Editar
                                </button>
                                <button type="button" 
                                        class="btn btn-xs btn-danger btn-raised btn_delete_teacher"
                                        data-teacher="'.$maestro->user_id.'"
                                        data-name="'.$maestro->name.' '.$maestro->lastname.'"
                                        data-toggle="tooltip"
                                        title="Delete teacher">Eliminar</button>
                             </td>';
                        echo '</tr>';
                    }
                echo '</tbody>';
            echo '</table>';
            echo '</div>';

            // Páginacion
            echo '<div class="row">';
                echo '<div class="col-sm-12 text-center">';
                    echo $paginacion;
                echo '</div>';
            echo '</div>';
        }
    }

    public static function getTeacher($id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT user_id, name, lastname, user_name, user_email, user_access_code
                FROM users 
                WHERE user_id = :id AND user_type = 3;";
        $query = $database->prepare($sql);
        $query->execute(array(':id' => $id));

        return $query->fetch();
    }

    public static function updateTeacher($teacher, $name, $lastname, $useremail, $username, $password){
        $database = DatabaseFactory::getFactory()->getConnection();
        $user_password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = $database->prepare("UPDATE users SET name       = :name,
                                                      lastname   = :lastname,
                                                      user_name  = :username,
                                                      user_password_hash = :user_password,
                                                      user_email = :useremail,
                                                      user_access_code   = :user_code
                                    WHERE user_id = :teacher
                                      AND user_type = 3;");
        $update = $query->execute(array(':name'      => $name,
                                        ':lastname'  => $lastname,
                                        ':username'  => $username,
                                        ':user_password' => $user_password_hash,
                                        ':useremail' => $useremail,
                                        ':user_code' => $password,
                                        ':teacher'   => $teacher));

        if ($update) {
            Session::add('feedback_positive','Datos del maestro actualizados correctamente.');
        } else {
            Session::add('feedback_negative','No se pudo actualizar los datos del maestro.');
        }
    }

    public static function deleteTeacher($teacher){
        $database = DatabaseFactory::getFactory()->getConnection();

        $delete  = $database->prepare("UPDATE users SET user_deleted = 1 WHERE user_id = :user;");
        $deleted = $delete->execute(array(':user' => $teacher));

        return $deleted;
    }

}
