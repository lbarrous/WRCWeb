<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:24
 */

namespace app\Http\Controllers;


use App\Models\Repositories\CocheRepository;
use App\Http\Controllers\Controller;

class CocheController extends Controller
{

    public function __construct(CocheRepository $cocheRepository)
    {
        $this->repoCoche = $cocheRepository;
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

    public function showListaCoches()
    {
        $opcionesDatatable = $this->inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array("bVisible" => false), //Aqui siempre el ID (PK)
            array(null),
        );

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);

        $datos["coches"] = $this->repoCoche->getAllCoches();

        return view('listaCoches')->with('datos', $datos);
    }

    public function editaCoche($codCoche)
    {
        $coche = $this->repoCoche->getCocheByCod($codCoche);
        $datos["coche"] = $coche;

        return view('editaCoche')->with('datos', $datos);
    }

    public function saveCambiosCoche(Request $request)
    {
        /*$validator = $this->validator($request->all());

        if ($validator->fails()) {
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return \Response::json( array('err' => true, "msg" =>$msgerrors[0]) );
        }
        else {
            $codPiloto = Input::get('codPiloto');

            $datos = array(
                'nombre' => Input::get('nombre'),
                'grupoS' => Input::get('grupoS'),
                'rh' => Input::get('rh'),
                'nombreCop' => Input::get('nombreCop'),
                'coche' => Input::get('coche'),
            );

            if($codPiloto == "") {
                $piloto = $this->repoPiloto->createPiloto($datos);
                $nuevoPiloto = 1;
            }
            else {
                $piloto = $this->repoPiloto->getPilotoByCod($codPiloto);
                $nuevoPiloto = 0;
            }

            $this->repoPiloto->updatePilotoByCod($piloto->codPiloto, $datos);

            $datos["piloto"] = $this->repoPiloto->getPilotoByCod($piloto->codPiloto);

            return json_encode(array("result" => "ok", "codPiloto" => $piloto->codPiloto, "nuevoPiloto" => $nuevoPiloto));
        }*/
    }


}