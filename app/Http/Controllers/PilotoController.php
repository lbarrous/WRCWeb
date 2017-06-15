<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:24
 */

namespace app\Http\Controllers;


use App\Models\Repositories\PilotoRepository;
use App\Http\Controllers\Controller;

class PilotoController extends Controller
{

    public function __construct(PilotoRepository $pilotoRepository)
    {
        $this->repoPiloto = $pilotoRepository;
    }

    public function inicializaOpcionesDatatable() {

        $opcionesDatatable = array( "responsive" => "true",
            "language" => array(
                "search" =>  "Búsqueda",
                "loadingRecords"=> "Cargando...",
                "lengthMenu" => "Mostrando _MENU_",
                "zeroRecords"=> "Sin registros",
                "processing" => "Procesandp",
                "info"=> "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty"=> "Sin Registros",
                "infoFiltered"=> "(Resultado filtrado de un total de _MAX_ registros)",
                "paginate" => array (
                    "first"=> "Primera",
                    "previous"=> "<strong><</strong>",
                    "next"=> "<strong>></strong>",
                    "last"=> "Última",
                )
            ),
            "aoColumns"	=> array(//Poblar en cada respectivo metodo de tabla)
            ),
            "columnDefs" => array(
                array ("className" => 'never', "targets"=> 0 )
            ),
            "order" => array ( array(0, 'desc') )
        );

        return $opcionesDatatable;
    }

    public function showListaPilotos()
    {
        $opcionesDatatable = $this->inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array("bVisible" => false), //Aqui siempre el ID (PK)
            array(null),
        );

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);

        $datos["pilotos"] = $this->repoPiloto->getAllPilotos();

        return view('listaRallies')->with('datos', $datos);
    }


}