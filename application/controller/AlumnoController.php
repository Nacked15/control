<?php

class AlumnoController extends Controller
{

    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();

        Registry::set('css',array('fileinput.min&assets/css','icons&assets/css','mapa&assets/css','alumnos&assets/css'));
        Registry::set('js', array('fileinput.min&assets/js', 'jquery.dataTables.min&assets/js', 'alumnos&assets/js'));
    }

    public function index() {
        $this->View->render('alumnos/index', array(
            'u_type'    => Session::get('user_account_type'),
            'cursos'    => CursoModel::getCourses()
        ));
    }

    public function obtenerAlumnos() {
        AlumnoModel::students(Request::post('curso'));
    }

    public function obtenerCantidadAlumnosXCurso() {
        $total = array(
                    'EC' => AlumnoModel::getNumberStudentsByCourse(1),
                    'PR' => AlumnoModel::getNumberStudentsByCourse(2),
                    'AD' => AlumnoModel::getNumberStudentsByCourse(3),
                    'AV' => AlumnoModel::getNumberStudentsByCourse(4),
                    'NA'  => AlumnoModel::getNumberStudentsByCourse(5),
                    'TD'  => AlumnoModel::getNumberStudentsByCourse(6)
                );
        echo json_encode($total);
    }

    public function nuevo() {
        // Session::destroy('activo');
        if (Session::get('activo') == null) {
            Session::set('activo', 'info_tutor');
        }
        Registry::set('js', array('mapa&assets/js', 'inscripcion&assets/js'));
        $this->View->render('alumnos/inscribir', array(
            'activeView' => Session::get('activo'),
            'cursos'    => CursoModel::getCourses(),
            'niveles'   => CursoModel::getGroups(),
            'street'    => Session::get('address')['street'],
            'number'    => Session::get('address')['number'],
            'between'   => Session::get('address')['between'],
            'colony'    => Session::get('address')['colony']
        ));
    }

    //Comprobar si existe el tutor en la BD
    public function existeTutor() {
        echo json_encode(AlumnoModel::tutorExist(
            Request::post('name'),
            Request::post('surname'),
            Request::post('lastname')
        ));
    }

    //Obtener los datos de un tutor dado
    public function obtenerTutor() {
        echo json_encode(AlumnoModel::getTutorByID(
            Request::post('tutor')
        ));
    }

    public function guardarDatosTutor(){
        $tutor = array();
        if (Request::post('hasTutor') === 'si') {
                $address = array();
                $tutor['hastutor'] = true;
            if (Request::post('tutor_id') === "") {
                $tutor['exist'] = false;
            } else {
                $tutor['exist']    = true;
                $tutor['tutor_id'] = Request::post('tutor_id');
            }
                $tutor['name']         = Request::post('nombre_tutor');
                $tutor['surname']      = Request::post('apellido_pat');
                $tutor['lastname']     = Request::post('apellido_mat');
                $tutor['relationship'] = Request::post('parentesco');
                $tutor['ocupation']    = Request::post('ocupacion');
                $tutor['cellphone']    = Request::post('tel_celular');
                $tutor['phone']        = Request::post('tel_casa');
                $tutor['phone_alt']    = Request::post('tel_alterno');
                $tutor['relation_alt'] = Request::post('parentesco_alterno');

                $address['latitud']    = Request::post('lat');
                $address['longitud']   = Request::post('lng');
                $address['street']     = Request::post('calle');
                $address['number']     = Request::post('numero');
                $address['between']    = Request::post('entre');
                $address['colony']     = Request::post('colonia');
                Session::set('address', $address);
        } else {
            $tutor['hastutor'] = false;
            $tutor['latitud']  = Request::post('lat');
            $tutor['longitud'] = Request::post('lng');
        }

        Session::set('tutor', $tutor);
        Session::set('activo', 'info_student');
        Redirect::to('alumno/nuevo');
    }

    //Comprobar si existe el alumno en la BD
    public function existeAlumno() {
        echo json_encode(AlumnoModel::studentExist(
            Request::post('name'),
            Request::post('surname'),
            Request::post('lastname')
        ));
    }

    public function cancelarRegistro(){
        Session::destroy('tutor');
        Session::destroy('address');
        Redirect::to('alumno/nuevo');
    }

    public function guardarDatosAlumno(){
        if (Request::post('surname') && Request::post('lastname') && Request::post('name')) {
            $birthdate = Request::post('year').'-'.Request::post('month').'-'.Request::post('day');
            $alumno    = array();
            
            $alumno['surname']    = Request::post('surname'); 
            $alumno['lastname']   = Request::post('lastname'); 
            $alumno['name']       = Request::post('name'); 
            $alumno['birthdate']  = $birthdate;
            $alumno['genre']      = Request::post('genero');
            $alumno['civil_stat'] = Request::post('edo_civil');
            $alumno['cellphone']  = Request::post('celular');
            $alumno['reference']  = Request::post('referencia');
            $alumno['sickness']   = Request::post('padecimiento');
            $alumno['medication'] = Request::post('tratamiento');
            $alumno['comment']    = Request::post('comentario');
            $alumno['invoice']    = Request::post('facturacion'); 
            $alumno['homestay']   = Request::post('homestay');
            $alumno['acta']       = Request::post('acta');

            $id = strtotime(H::getTime());
            $name_avatar = 'student_'.$id;
            $upload = false;
            if ($_FILES['avatar_file']['tmp_name'] !== "") {
                $upload = FotoModel::createAvatar($name_avatar);
            }
            if ($upload) {
                $alumno['avatar']  = $name_avatar;
            } else {
                $alumno['avatar']  = strtolower($alumno['genre']);
            }

            if (!Session::get('tutor')['hastutor'] || Session::get('address') == null) {
                $address = array();
                $address['street']     = Request::post('calle');
                $address['number']     = Request::post('numero');
                $address['between']    = Request::post('entre');
                $address['colony']     = Request::post('colonia');
                Session::set('address', $address);
            }
            Session::set('alumno', $alumno);
            Session::set('activo', 'info_academic');
            Redirect::to('alumno/nuevo');
        } else {
            Session::add('feedback_negative', 'Error al guardar, complete la hoja correctamente e intente de nuevo.');
            Redirect::to('alumno/nuevo');
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

    public function guardarDatosAcademicos(){
        $alumno = Session::get('alumno');
        $tutor  = Session::get('tutor');

        if ($alumno && $tutor) {
            AlumnoModel::registerNewStudent(
                $tutor,
                $alumno,
                Request::post('clase'),
                Request::post('ocupacion'),
                Request::post('lugar_trabajo'),
                Request::post('nivel_estudio'),
                Request::post('grado_estudio'),
                Request::post('curso_previo'),
                Request::post('description_previo'),
                Request::post('f_inicio_alumno'));
            Session::destroy('activo');
            Redirect::to('alumno/nuevo');
        } else {
            Session::add('feedback_negative', 'Algo ha salido mal, intente de nuevo por favor! :(');
            Redirect::to('alumno/nuevo');
        }
    }

    public function actualizarDatosAlumno(){
        $alumno = Request::post('student_id');

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
            Redirect::to('alumno/perfilAlumno/'.$alumno);
        } else {
            Session::add('feedback_negative', "Falta información para completar el proceso");
            Redirect::to('alumno/perfilAlumno/'.$alumno);
        }
    }

    public function perfilAlumno($alumno) {
        Registry::set('js', array('mapa&assets/js'));
        $this->View->render('alumnos/perfil', array(
            'alumno'  => AlumnoModel::studentProfile($alumno)
        ));
    }

    public function obtenerAlumnosBaja() {
        AlumnoModel::getStudentsCheckout(); 
    }

    public function convenio(){
        $this->View->render('alumnos/convenio');
    }

    public function conveniopdf(){
        $this->View->renderWithoutHeaderAndFooter('alumnos/conveniopdf');
    }

    public function bajaAlumno(){
        AlumnoModel::checkOutStudent(Request::post('alumno'), Request::post('estado'));
    }

    public function actualizarDatosTutor(){

        if (Request::post('id_tutor') && Request::post('nombre_tutor') && Request::post('ape_pat') && Request::post('ape_mat')) {
            AlumnoModel::updateTutorData(
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
            Redirect::to('alumno/perfilAlumno/'.Request::post('alumno'));
        }  else {
            Session::add('feedback_negative', "Falta información para completar el proceso");
            Redirect::to('alumno/perfilAlumno/'.Request::post('alumno'));
        }
    }

    public function actualizarDatosAcademicos(){
        if (Request::post('alumno')) {
            AlumnoModel::updateAcademicData(
                Request::post('alumno'),
                Request::post('ocupacion'),
                Request::post('lugar_trabajo'),
                Request::post('nivel_estudio'),
                Request::post('grado_estudio')
                );
            Redirect::to('alumno/perfilAlumno/'.Request::post('alumno'));
        } else {
            Session::add('feedback_negative', "Falta información para completar el proceso");
            Redirect::to('alumno/perfilAlumno/'.Request::post('alumno'));
        }
    }

    public function agregarAlumnoGrupo(){
        if (Request::post('alumno') && Request::post('clase')) {
            AlumnoModel::AddStudentToClass(Request::post('alumno'), Request::post('clase'));
        } else {
            echo 0;
        }
    }

    public function cambiarGrupoAlumno(){
        if (Request::post('alumno') && Request::post('clase') !== "") {
            AlumnoModel::ChangeStudentGroup(Request::post('alumno'), Request::post('clase'));
        } else {
            echo 0;
        }
    }

    public function cambiarGrupoAlumnos(){
        if (Request::post('alumnos') && Request::post('clase') !== "") {
            AlumnoModel::ChangeStudentsGroup(Request::post('alumnos'), Request::post('clase'));
        } else {
            echo 0;
        }
    }

    public function obtenerListaFactura() {
        AlumnoModel::getStudentsInvoiceList();
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

    public function eliminarAlumno() {
        if (Request::post('alumno')) {
            echo json_encode(AlumnoModel::deleteStudent(Request::post('alumno')));
        }
    }

    public function eliminarAlumnos() {
        if (Request::post('alumnos')) {
            echo json_encode(AlumnoModel::deleteStudents((array)Request::post('alumnos')));
        }
    }




    /////////////////////////////////////////////////////
    // =  =   =   =  =  I M P O R T A R  =  =  =  =  = //
    /////////////////////////////////////////////////////
    public function importarGrupos() {
        echo json_encode(ImportOldDataModel::importGroups());
    }
    
    public function importarClases() {
        Registry::set('js', array('importar&assets/js'));
        $this->View->render('importar/clases');
    }

    public function getClasesList(){
        ImportOldDataModel::getClasesList();
    }

    public function importarAlumnos() {
        Registry::set('js', array('importar&assets/js'));
        $this->View->render('importar/index');
    }

    public function alumnosRepetidos() {
        H::getLibrary('paginadorLib');
        $page = 0;
        $paginator = new \Paginador();
        
        Registry::set('js', array('jquery.dataTables.min&assets/js','importar&assets/js'));
        $all_data = ImportOldDataModel::getRepeatedStudents();
        $data = $paginator->paginar($all_data, $page, 20);
        // H::p($data);
        // exit();
        // $data = $paginator->paginar($all_data, $page,20);
        $this->View->render('importar/repetidos', array(
            'repetidos'  => $paginator->paginar($all_data, 0, 20),
            'paginacion' => $paginator->getView('pagination_ajax', 'repeated')
        ));
    }

    public function corregirAlumnoRepetido(){
        ImportOldDataModel::updateNameStudent(Request::post('student'), 
                                          Request::post('name'), 
                                          Request::post('surname'), 
                                          Request::post('lastname'));
    }

    public function getAlumnosList(){
        ImportOldDataModel::importStudents(Request::post('page'));
    }

    public function importarMaestros() {
        echo json_encode(ImportOldDataModel::getTeachersList());
    }

    public function importarAlumno() {
        echo json_encode(ImportOldDataModel::importStudent(Request::post('alumno')));
    }





    public function backupDatabase() {
        GeneralModel::createBackupDatabase();
    }

}
