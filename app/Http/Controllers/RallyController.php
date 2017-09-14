<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:24
 */

namespace app\Http\Controllers;


//use App\Http\Requests\Request;
use App\Models\Repositories\CorreRepository;
use App\Models\Repositories\RallyRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;

class RallyController extends Controller
{

    public function __construct(RallyRepository $rallyRepository, CorreRepository $correRepository)
    {
        $this->repoRally = $rallyRepository;
        $this->repoCorre = $correRepository;
    }

    public function inicializaOpcionesDatatable() {

        $opcionesDatatable = array( "responsive" => "true",
            "language" => array(
                "search" =>  "Busqueda",
                "loadingRecords"=> "Cargando...",
                "lengthMenu" => "Mostrando _MENU_",
                "zeroRecords"=> "Sin registros",
                "processing" => "Procesandp",
                "info"=> "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty"=> "Sin Registros",
                "infoFiltered"=> "(Resultado filtrado de un total de _MAX_ registros)",
                "paginate" => array (
                    "first"=> "Primera",
                    "previous"=> "<strong><</strong>",
                    "next"=> "<strong>></strong>",
                    "last"=> "Ultima",
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
            'nombre' => 'required|max:255',
            'pais' => 'required|max:255',
            'fecha' => 'required|max:255',
        ]);
    }

    public function showListaRallies()
    {
        $opcionesDatatable = $this->inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array(null), //Aqui siempre el ID (PK)
            array(null),
            array(null),
            array(null),
            array(null),
        );

        if (!\Auth::guest())
            $opcionesDatatable["aoColumns"][] = array(null);

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);

        $datos["rallies"] = $this->repoRally->getAllRallies();

        return view('listaRallies')->with('datos', $datos);
    }

    function nuevoRally()
    {
        return view('editaRally')->with("nuevo_rally", 1);
    }

    public function editaRally($codRally)
    {
        $rally = $this->repoRally->getRallyByCod($codRally);
        $tramos = $this->repoRally->getTramosByCodRally($codRally);

        $datos["rally"] = $rally;
        $datos["tramos"] = $tramos;

        return view('editaRally')->with('datos', $datos);
    }

    public function verTramos($codRally)
    {
        $tramos = $this->repoRally->getTramosByCodRally($codRally);

        if(count($tramos) < 5) {
            $datos["tramos"] = $tramos;
            $datos["codRally"] = $codRally;
            $datos["sql_compleja"] = 0;

            return json_encode($datos);
        }
        else {
            $tramos = $this->repoRally->getTramosByCodRallyCompleja($codRally);
            $datos["tramos"] = $tramos;
            $datos["codRally"] = $codRally;
            $datos["sql_compleja"] = 1;

            return json_encode($datos);
        }

    }

    public function addTramo(Request $request)
    {
        $codRally = Input::get('codRally');

        $datos = array(
            'dificultad' => Input::get('dificultad'),
            'totalKms' => Input::get('totalKms'),
        );

        $tramo = $this->repoRally->addTramoByCodRally($codRally, $datos);

        return json_encode($tramo);
    }

    public function eliminarTramo(Request $request)
    {
        $codTramo = Input::get('codTramo');

        if($this->repoCorre->dimeSiTramoEsRecorrido($codTramo)) {
            return json_encode(["err" => "El tramo no puede ser borrado por que ha sido recorrido por uno o mas pilotos."]);
        }
        else {
            $tramo = $this->repoRally->eliminarTramo($codTramo);
            return json_encode($tramo);
        }
    }

    public function eliminarRally(Request $request)
    {
        $codRally = Input::get('codRally');

        if(!$this->repoRally->dimeSiRallyTieneParticipacion($codRally)) {
            return json_encode(["err" => "Este rally no puede ser borrado por que ha sido recorrido por uno o mas pilotos."]);
        }
        else {
            $rally = $this->repoRally->eliminarRally($codRally);
            return json_encode($rally);
        }
    }

    public function saveCambiosRally(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return \Response::json( array('err' => true, "msg" =>$msgerrors[0]) );
        }
        else {
            $codRally = Input::get('codRally');

            if($codRally == "") {
                $rally = $this->repoRally->createRally();
                $nuevoRally = 1;
            }
            else {
                $rally = $this->repoRally->getRallyByCod($codRally);
                $nuevoRally = 0;
            }

            $datos = array(
                'nombre' => Input::get('nombre'),
                'pais' => Input::get('pais'),
                'fecha' => Input::get('fecha'),
            );

            $this->repoRally->updateRallyByCod($rally->codRally, $datos);

            $datos["rally"] = $this->repoRally->getRallyByCod($rally->codRally);

            return json_encode(array("result" => "ok", "codRally" => $rally->codRally, "nuevoRally" => $nuevoRally));
        }
    }

}