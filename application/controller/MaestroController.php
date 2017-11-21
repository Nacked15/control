<?php

class MaestroController extends Controller
{

    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();

        Registry::set('css',array('jquery.dataTables.min&assets/css', 'maestros&assets/css'));
        Registry::set('js', array('jquery.dataTables.min&assets/js', 'maestros&assets/js'));
    }

    public function index() {
        $this->View->render('maestros/index', array(
            'maestros'    => MaestroModel::getTeachers()
        ));
    }

    public function maestro() {
        if(Request::post('maestro')){
            echo json_encode(MaestroModel::getTeacher(Request::post('maestro')));
        }
    }

    public function editarMaestro() {
        if(Request::post('user_id') && Request::post('name') && Request::post('lastname') && Request::post('user_name')){
            MaestroModel::updateTeacher(Request::post('user_id'),
                                        Request::post('name'),
                                        Request::post('lastname'),
                                        Request::post('user_name'),
                                        Request::post('user_email'));
            Redirect::to('maestro/index');
        } else {
            Session::add('feedback_negative','No se pudo actualizar los datos del maestro por falta de información.');
            Redirect::to('maestro/index');
        }
    }

    public function nuevoMaestro(){
        RegistrationModel::registerNewUser();

        Redirect::to('maestro/index');
    }

}
