<?php

class MaestroController extends Controller
{

    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();

        Registry::set('css',array('jquery.dataTables.min&assets/css'));
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

}
