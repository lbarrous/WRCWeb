<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:24
 */

namespace app\Http\Controllers;


class RallyController extends Controller
{

    public function __construct()
    {

    }

    public function showListaRallies()
    {
        $opcionesDatatable = \GlobalUtils::inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array("bVisible" => false), //Aqui siempre el ID (PK)
            array(null),
        );

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);
    }


}