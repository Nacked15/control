<?php

class PagosController extends Controller
{

    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();

        Registry::set('css',array('jquery.dataTables.min&assets/css', 'pagos&assets/css'));
        Registry::set('js', array('jquery.dataTables.min&assets/js', 'pagos&assets/js'));
    }

    public function index() {
        $this->View->render('pagos/index');
    }

    public function obtenerListaPagos() {
        PagosModel::getPaylist(Request::post('lista'));
    }

}
