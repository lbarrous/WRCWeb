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
use App\Models\Repositories\PilotoRepository;
use App\Models\Repositories\RallyRepository;
use App\Models\Repositories\ResultadosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class ResultadosController extends Controller
{

    public function __construct(ResultadosRepository $resultadosRepository, RallyRepository $rallyRepository, PilotoRepository $pilotoRepository)
    {
        $this->repoResultados = $resultadosRepository;
        $this->repoRally = $rallyRepository;
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'posicion' => 'numeric',
        ]);
    }

    public function showListaResultados()
    {
        $opcionesDatatable = $this->inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array("bVisible" => false), //Aqui siempre el ID (PK)
            array(null),
        );

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);

        $datos["resultados"] = $this->repoResultados->getAllResultados();
        $rallies = $this->repoRally->getAllRallies();
        foreach ($rallies as $rally) {
            $datos["rallies"][] = $rally->codRally;
        }

        return view('listaResultados')->with('datos', $datos);
    }

    public function editaCoche($codCoche)
    {
        $coche = $this->repoCoche->getCocheByCod($codCoche);
        $datos["coche"] = $coche;

        return view('editaCoche')->with('datos', $datos);
    }

    public function saveCambiosCoche(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return \Response::json( array('err' => true, "msg" =>$msgerrors[0]) );
        }
        else {
            $codCoche = Input::get('codCoche');

            $datos = array(
                'marca' => Input::get('marca'),
                'modelo' => Input::get('modelo'),
                'cilindrada' => Input::get('cilindrada'),
            );

            if($codCoche == "") {
                $coche = $this->repoCoche->createCoche();
                $nuevoCoche = 1;
            }
            else {
                $coche = $this->repoCoche->getCocheByCod($codCoche);
                $nuevoCoche = 0;
            }

            $this->repoCoche->updateCocheByCod($coche->codCoche, $datos);

            $datos["coche"] = $this->repoCoche->getCocheByCod($coche->codCoche);

            return json_encode(array("result" => "ok", "codCoche" => $coche->codCoche, "nuevoCoche" => $nuevoCoche));
        }
    }

    public function eliminarResultado(Request $request)
    {
        $codPiloto = Input::get('codPiloto');
        $codRally = Input::get('codRally');
        $resultado = $this->repoResultados->eliminarResultado($codRally, $codPiloto);
        return json_encode($resultado);
    }

    function nuevoResultado()
    {
        $datos["rallies"] = $this->repoRally->getAllRallies();
        $datos["pilotos"] = $this->repoPiloto->getAllPilotos();
        return view('editaResultados')->with("datos", $datos);
    }

    public function saveCambiosResultados(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return \Response::json( array('err' => true, "msg" =>$msgerrors[0]) );
        }
        else {
            $datos = array(
                'codRally' => Input::get('rally'),
                'codPiloto' => Input::get('piloto'),
                'posicion' => Input::get('posicion'),
            );

            if($this->repoResultados->dimeSiResultadoRepetido(Input::get('rally'),Input::get('piloto')) > 0)
                return json_encode(array("result" => "error"));
            else {
                $coche = $this->repoResultados->createResultado($datos);

                return json_encode(array("result" => "ok"));
            }

        }
    }

}