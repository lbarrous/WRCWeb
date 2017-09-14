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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'cilindrada' => 'numeric',
        ]);
    }

    public function showListaCoches()
    {
        $opcionesDatatable = $this->inicializaOpcionesDatatable();

        $opcionesDatatable["aoColumns"] = array(
            array(null), //Aqui siempre el ID (PK)
            array(null),
            array(null),
        );

        if (!\Auth::guest())
            $opcionesDatatable["aoColumns"][] = array(null);

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

    public function eliminarCoche(Request $request)
    {
        $codCoche = Input::get('codCoche');

        if(!$this->repoCoche->dimeSiCocheTienePiloto($codCoche)) {
            return json_encode(["err" => "Este coche no puede ser borrado por que tiene un piloto asignado."]);
        }
        else {
            $coche = $this->repoCoche->eliminarCoche($codCoche);
            return json_encode($coche);
        }
    }

    function nuevoCoche()
    {
        return view('editaCoche')->with("nuevo_coche", 1);
    }

}