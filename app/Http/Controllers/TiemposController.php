<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:24
 */

namespace app\Http\Controllers;


use App\Models\Repositories\TiempoRepository;
use App\Http\Controllers\Controller;
use App\Models\Repositories\PilotoRepository;
use App\Models\Repositories\RallyRepository;
use App\Models\Repositories\TiemposRepository;
use App\Models\Repositories\TramoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class TiemposController extends Controller
{

    public function __construct(TramoRepository $tramoRepository, TiemposRepository $tiemposRepository, TiemposRepository $resultadosRepository, RallyRepository $rallyRepository, PilotoRepository $pilotoRepository)
    {
        $this->repoTiempos = $resultadosRepository;
        $this->repoRally = $rallyRepository;
        $this->repoPiloto = $pilotoRepository;
        $this->repoTiempos = $tiemposRepository;
        $this->repoTramos = $tramoRepository;
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
                "infoFiltered"=> "(Tiempo filtrado de un total de _MAX_ registros)",
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'tiempo' => 'required|numeric',
        ]);
    }

    public function showListaTiempos()
    {
        $opcionesDatatable = $this->inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array("bVisible" => false), //Aqui siempre el ID (PK)
            array(null),
        );

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);

        $datos["tiempos"] = $this->repoTiempos->getAllTiempos();
        $pilotos = $this->repoPiloto->getAllPilotos();
        foreach ($pilotos as $piloto) {
            $datos["pilotos"][] = $piloto->codPiloto;
        }

        return view('listaTiempos')->with('datos', $datos);
    }

    public function editaTiempo($codTiempo)
    {
        $coche = $this->repoTiempo->getTiempoByCod($codTiempo);
        $datos["coche"] = $coche;

        return view('editaTiempo')->with('datos', $datos);
    }

    public function saveCambiosTiempo(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return \Response::json( array('err' => true, "msg" =>$msgerrors[0]) );
        }
        else {
            $codTiempo = Input::get('codTiempo');

            $datos = array(
                'marca' => Input::get('marca'),
                'modelo' => Input::get('modelo'),
                'cilindrada' => Input::get('cilindrada'),
            );

            if($codTiempo == "") {
                $coche = $this->repoTiempo->createTiempo();
                $nuevoTiempo = 1;
            }
            else {
                $coche = $this->repoTiempo->getTiempoByCod($codTiempo);
                $nuevoTiempo = 0;
            }

            $this->repoTiempo->updateTiempoByCod($coche->codTiempo, $datos);

            $datos["coche"] = $this->repoTiempo->getTiempoByCod($coche->codTiempo);

            return json_encode(array("result" => "ok", "codTiempo" => $coche->codTiempo, "nuevoTiempo" => $nuevoTiempo));
        }
    }

    public function eliminarTiempo(Request $request)
    {
        $codPiloto = Input::get('codPiloto');
        $codTramo = Input::get('codTramo');
        $resultado = $this->repoTiempos->eliminarTiempo($codPiloto, $codTramo);
        return json_encode($resultado);
    }

    function nuevoTiempo()
    {
        $datos["tramos"] = $this->repoTramos->getAllTramosRallies();
        $datos["pilotos"] = $this->repoPiloto->getAllPilotos();
        return view('editaTiempos')->with("datos", $datos);
    }

    public function saveCambiosTiempos(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return \Response::json( array('err' => true, "msg" =>$msgerrors[0]) );
        }
        else {
            $datos = array(
                'tramo' => Input::get('tramo'),
                'codPiloto' => Input::get('piloto'),
                'tiempo' => Input::get('tiempo'),
            );

            if($this->repoTiempos->dimeSiTiempoRepetido(Input::get('piloto'),Input::get('tramo')) > 0)
                return json_encode(array("result" => "error"));
            else {
                $tiempo = $this->repoTiempos->createTiempo($datos);

                return json_encode(array("result" => "ok"));
            }


        }
    }

}