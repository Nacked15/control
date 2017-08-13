<?php

class AlumnoController extends Controller
{

    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();

        Registry::set('css',array('fileinput.min&assets/css', 'icons&assets/css', 'alumnos&assets/css'));
        Registry::set('js', array('fileinput.min&assets/js', 'jquery.dataTables.min&assets/js', 'alumnos&assets/js'));
    }

    public function index() {
        $this->View->render('alumnos/index', array(
            'cursos'    => CursoModel::getCourses()
            ));
    }

    public function obtenerAlumnos() {
        AlumnoModel::getStudents(Request::post('curso'));
    }

    public function obtenerAlumnosTodos() {
        AlumnoModel::getStudentsAll();
    }

    public function nuevo() {
        $this->View->render('alumnos/inscribir', array(
            'cursos'    => CursoModel::getCourses(),
            'niveles'   => CursoModel::getLevels(),
            'street'    => Session::get('addres_street'),
            'number'    => Session::get('addres_number'),
            'between'   => Session::get('addres_between'),
            'colony'    => Session::get('addres_colony'),
            'address'   => Session::get('address_id')
        ));
    }

    public function obtenerPerfilAlumno() {
        Registry::set('css',array('alumnos&assets/css'));
        $this->View->renderWithoutHeaderAndFooter('alumnos/alumnoprofile', array(
            'alumno'  => AlumnoModel::getStudentByID(Request::post('student')),
            'tutor'   => AlumnoModel::getTutorByID(Request::post('tutor')),
            'clase'   => AlumnoModel::getClaseByID(Request::post('clase')),
            'address' => AlumnoModel::getAddressByUser(Request::post('student'), Request::post('tutor')),
            'cursos'  => CursoModel::getCourses()
        ));
    }

    public function actualizarDatosAlumno(){
        if (Request::post('student_id') && Request::post('name') && Request::post('surname') && Request::post('lastname') && Request::post('genre') && Request::post('edo_civil')) {
            AlumnoModel::updateStudentData(
                Request::post('student_id'),
                Request::post('tutor_id'),
                Request::post('name'),
                Request::post('surname'),
                Request::post('lastname'),
                Request::post('birthdate'),
                Request::post('genre'),
                Request::post('edo_civil'),
                Request::post('cellphone'),
                Request::post('reference'),
                Request::post('street'),
                Request::post('number'),
                Request::post('between'),
                Request::post('colony'),
                Request::post('sickness'),
                Request::post('medication'),
                Request::post('homestay'),
                Request::post('acta'),
                Request::post('invoice'),
                Request::post('comment')
                );
            Redirect::to('alumno/index');
        } else {
            Session::add('feedback_negative', "Falta información para completar el proceso");
            Redirect::to('alumno/index');
        }
    }

    public function actualizarDatosTutos(){
        if (Request::post('nombre_tutor') && Request::post('ape_pat') && Request::post('ape_mat')) {
            updateTutosData(
                Request::post('id_tutor'),
                Request::post('nombre_tutor'),
                Request::post('ape_pat'),
                Request::post('ape_mat'),
                Request::post('ocupacion'),
                Request::post('parentesco'),
                Request::post('tel_casa'),
                Request::post('tel_celular'),
                Request::post('familiar'),
                Request::post('tel_familiar'));
        }
    }

    public function agregarAlumnoGrupo(){
        if (Request::post('alumno') && Request::post('clase')) {
            AlumnoModel::AddStudentToClass(Request::post('alumno'), Request::post('clase'));
        } else {
            echo 0;
        }
    }

    public function obtenerNivelesCurso() {
        if(Request::post('curso')){
            echo json_encode(AlumnoModel::getLevelsByClass(Request::post('curso')));
        }
    }

    public function obtenerInfoClase() {
        if(Request::post('clase')){
            echo json_encode(CursoModel::getClass(Request::post('clase')));
        }
    }

    public function obtenerDiasClase() {
        if(Request::post('clase')){
            echo json_encode(CursoModel::getDaysByClass(Request::post('clase')));
        }
    }

    public function existeTutor() {
        echo json_encode(AlumnoModel::tutorExist(
            Request::post('name'),
            Request::post('surname'),
            Request::post('lastname')
        ));
    }

    public function guardarDatosTutor(){

        if (Request::post('apellido_pat') && Request::post('apellido_mat') && Request::post('nombre_tutor') &&Request::post('parentesco') && Request::post('ocupacion') && Request::post('tel_celular') && Request::post('tel_casa') && Request::post('tel_alterno') && Request::post('parentesco_alterno')) {
            $id_tutor = AlumnoModel::addNewTutor(
                Request::post('apellido_pat'), 
                Request::post('apellido_mat'), 
                Request::post('nombre_tutor'),
                Request::post('parentesco'),
                Request::post('ocupacion'),
                Request::post('tel_celular'),
                Request::post('tel_casa'),
                Request::post('tel_alterno'), 
                Request::post('parentesco_alterno')
            );

            if ($id_tutor != 0) {
                AlumnoModel::addNewAddress(
                    $id_tutor,
                    Request::post('calle'),
                    Request::post('numero'),
                    Request::post('entre'),
                    Request::post('colonia'),
                    1);
                Redirect::to('alumno/nuevo');
            }

        } else {
            Redirect::to('alumno/nuevo');
            Session::add('feedback_negative','Falta información para terminar el proceso.');
        }
    }

    public function guardarDatosAlumno(){
        if (Request::post('surname') && Request::post('lastname') && Request::post('name') && Request::post('day') && Request::post('month') && Request::post('year')) {
            $birthday = Request::post('year').'-'.Request::post('month').'-'.Request::post('day');
            
            $student_id = AlumnoModel::saveNewStudent(
                            Request::post('surname'), 
                            Request::post('lastname'), 
                            Request::post('name'), 
                            $birthday,
                            Request::post('genero'),
                            Request::post('edo_civil'),
                            Request::post('celular'),
                            Request::post('referencia'),
                            Request::post('padecimiento'),
                            Request::post('tratamiento'),
                            Request::post('comentario'));

            if ($student_id !== false) {
                $details = AlumnoModel::saveStudentDetails(
                            $student_id,
                            Request::post('facturacion'), 
                            Request::post('homestay'),
                            Request::post('acta'));

                if ($details) {
                    if (Request::post('address') !== '') {
                        AlumnoModel::updateAddress($student_id, Request::post('address'));
                    } else {
                        AlumnoModel::addNewAddress(
                                        $student_id,
                                        Request::post('calle'),
                                        Request::post('numero'),
                                        Request::post('entre'),
                                        Request::post('colonia'),
                                        2);
                    }

                    $file = $_FILES['avatar_file'];
                    $name_avatar = 'avatar_student'.$student_id;
                    FotoModel::createAvatar($student_id, $name_avatar, $file);
                } else {
                    AlumnoModel::rollbackStudent($student_id);
                    Session::add('feedback_negative', 'No se guardo los datos del alumno, intente de nuevo por favor');
                }
                Redirect::to('alumno/nuevo');
            }
        } else {
            var_dump(Request::post('surname'), Request::post('lastname'), Request::post('name'), Request::post('day'), Request::post('month'), Request::post('year'));
        }

    }

    public function guardarDatosAcademicos(){
        if (Request::post('curso') && Request::post('grupo') && Request::post('clase')) {
            AlumnoModel::saveAcademicData(
                Request::post('clase'),
                Request::post('ocupacion'),
                Request::post('lugar_trabajo'),
                Request::post('nivel_estudio'),
                Request::post('grado_estudio'),
                Request::post('curso_previo'),
                Request::post('description_previo'),
                Request::post('f_inicio_alumno'));
            Redirect::to('alumno/nuevo');
        } else {
            Session::add('feedback_negative', 'Algo ha salido mal, intente de nuevo por favor! :(');
            Redirect::to('alumno/nuevo');
        }
    }

    public function becados() {
        $this->View->render('alumnos/becados', array(
            'user_name' => Session::get('user_name'),
        ));
    }

    public function notas() {
        $this->View->render('alumnos/calificaciones', array(
            'user_name' => Session::get('user_name'),
        ));
    }

    public function sep() {
        $this->View->render('alumnos/sep', array(
            'user_name' => Session::get('user_name'),
        ));
    }

    public function egresados() {
        $this->View->render('alumnos/egresados', array(
            'user_name' => Session::get('user_name'),
        ));
    }

    public function baja() {
        $this->View->render('alumnos/baja', array(
            'user_name' => Session::get('user_name'),
        ));
    }

    public function editUsername() {
        $this->View->render('user/editUsername');
    }

}
