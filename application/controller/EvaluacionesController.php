<?php

class EvaluacionesController extends Controller
{

    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();

        Registry::set('css',array('icons&assets/css', 'alumnos&assets/css'));
        Registry::set('js', array('jquery.dataTables.min&assets/js', 'evaluaciones&assets/js'));
    }

    public function index($alumno) {
        $this->View->render('evaluaciones/index', array(
            'alumno' => $alumno));
    }

    public function nuevaEvaluacion(){
        $this->View->renderWithoutHeaderAndFooter('evaluaciones/evaluarv1');
    }

    public function formNewClase() {
        $this->View->renderWithoutHeaderAndFooter('cursos/nuevaclase', array(
            'dias'      => CursoModel::getDays(),
            'cursos'    => CursoModel::getCourses(),
            'niveles'   => CursoModel::getLevels(),
            'maestros'  => MaestroModel::getTeachers()
        ));
    }

}
