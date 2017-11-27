<?php

class PadrinosController extends Controller
{

    public function __construct() {
        parent::__construct();
        Auth::checkAuthentication();

        Registry::set('css',array('jquery.dataTables.min&assets/css', 'maestros&assets/css'));
        Registry::set('js', array('jquery.dataTables.min&assets/js', 'padrinos&assets/js'));
    }

    public function index() {
        $this->View->render('padrinos/index');
    }

    public function padrinos() {
        PadrinosModel::getAllSponsors();
    }

    public function nuevoPadrino() {
        if (Request::post('sponsor_name')) {
            echo json_encode(PadrinosModel::addNewSponsor(
                                                Request::post('sponsor_name'),
                                                Request::post('sponsor_lastname'),
                                                Request::post('sponsor_type'),
                                                Request::post('sponsor_email'),
                                                Request::post('description'),
                                                Request::post('becario')
            ));
        }
    }

}
