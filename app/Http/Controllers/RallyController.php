<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:24
 */

namespace app\Http\Controllers;


use App\Models\Repositories\RallyRepository;
use App\Http\Controllers\Controller;

class RallyController extends Controller
{

    public function __construct(RallyRepository $rallyRepository)
    {
        $this->repoRally = $rallyRepository;
    }

    public function showListaRallies()
    {
        $opcionesDatatable = \App\GlobalUtils::inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array("bVisible" => false), //Aqui siempre el ID (PK)
            array(null),
        );

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);

        //$datos["rallies"] = $this->repoRally->getAllRallies();

        return view('listaRallies')->with('datos', $datos);
    }


}