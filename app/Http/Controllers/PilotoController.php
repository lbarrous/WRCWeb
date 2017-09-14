<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:24
 */

namespace app\Http\Controllers;


use App\Models\Repositories\CocheRepository;
use App\Models\Repositories\PilotoRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;

class PilotoController extends Controller
{

    public function __construct(PilotoRepository $pilotoRepository, CocheRepository $cocheRepository)
    {
        $this->repoPiloto = $pilotoRepository;
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
            'nombre' => 'required|max:255',
            'nombreCop' => 'required|max:255',
        ]);
    }

    public function showListaPilotos()
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

        $datos["pilotos"] = $this->repoPiloto->getAllPilotos();

        return view('listaPilotos')->with('datos', $datos);
    }

    function nuevoPiloto()
    {
        $coches_libres = $this->repoCoche->getCochesLibres();
        $datos["coches_libres"] = $coches_libres;
        $datos["nuevo_piloto"] = 1;

        return view('editaPiloto')->with("datos", $datos);

    }

    public function editaPiloto($codPiloto)
    {
        $piloto = $this->repoPiloto->getPilotoByCod($codPiloto);
        $coches_libres = $this->repoCoche->getCochesLibres();

        $datos["piloto"] = $piloto;

        $datos["coches_libres"] = $coches_libres;

        return view('editaPiloto')->with('datos', $datos);
    }

    public function verCochePiloto($codCoche)
    {
        $coche = $this->repoCoche->getCocheByCod($codCoche);

        $datos["coche"] = $coche;

        return json_encode($datos);
    }

    public function saveCambiosPiloto(Request $request)
    {
        $validator = $this->validator($request->all());

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
        }
    }

    public function eliminarPiloto(Request $request)
    {
        $codPiloto = Input::get('codPiloto');

        if(!$this->repoPiloto->dimeSiPilotoTieneParticipacion($codPiloto)) {
            return json_encode(["err" => "Este piloto no puede ser borrado por que tiene uno o varios resultados asignados."]);
        }
        else {
            $piloto = $this->repoPiloto->eliminarPiloto($codPiloto);
            return json_encode($piloto);
        }
    }

    public function dimeSiPuedoCrearPilotos()
    {
        var_dump(1);exit;
        return count($this->repoCoche->getAllCoches()) > count($this->repoPiloto->getAllPilotos());
    }

}