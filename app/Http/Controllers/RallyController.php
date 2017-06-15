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
use Illuminate\Support\Facades\Input;

class RallyController extends Controller
{

    public function __construct(RallyRepository $rallyRepository)
    {
        $this->repoRally = $rallyRepository;
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
            array("bVisible" => false), //Aqui siempre el ID (PK)
            array(null),
            array(null),
            array(null),
            array(null),
        );

        $datos["opcionesDatatable"] = json_encode($opcionesDatatable);

        $datos["rallies"] = $this->repoRally->getAllRallies();

        return view('listaRallies')->with('datos', $datos);
    }

    function nuevoRally()
    {
        return view('editaRally');
    }

    public function editaRally($codRally)
    {
        $rally = $this->repoRally->getRallyByCod($codRally);

        $datos["rally"] = $rally;

        return view('editaRally')->with('datos', $datos);
    }

    public function saveCambiosRally()
    {
        $codRally = Input::get('codRally');

        if($codRally == "") {
            $rally = $this->repoRally->createRally();
        }
        else {
            $rally = $this->repoRally->getRallyByCod($codRally);
        }

        $datos = array(
            'nombre' => Input::get('nombre'),
            'pais' => Input::get('pais'),
            'fecha' => Input::get('fecha'),
        );

        $this->repoRally->updateRallyByCod($rally->codRally, $datos);

        $datos["rally"] = $this->repoRally->getRallyByCod($rally->codRally);

        return json_encode(array("result" => "ok", "codRally" => $rally->codRally));
    }


}