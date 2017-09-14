<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use app\Models\Entities\Piloto;
use App\Models\Entities\Posicion;
use App\Models\Entities\Rally;


class ResultadosRepository
{
    public function getAllResultados() {
        $rallies = Rally::all();

        $posiciones = array();
        foreach ($rallies as $rally) {
            $posiciones_rally = \DB::table('piloto')->join('posicion', 'posicion.codPiloto', '=', 'piloto.codPiloto')->select('nombreP', 'posicion', 'posicion.codPiloto')
                ->where('codRally', $rally->codRally)->get();
            $posiciones[$rally->codRally]["nombre_rally"] = $rally->nombre;
            $posiciones[$rally->codRally]["codRally"] = $rally->codRally;
            $posiciones[$rally->codRally]["posiciones"][] = $posiciones_rally;
        }
        return $posiciones;
    }

    public function eliminarResultado($codRally, $codPiloto) {

        $resultado = Posicion::where('codPiloto', $codPiloto)->where('codRally', $codRally)->delete();

        return $codRally.$codPiloto;
    }

    public function createResultado($datos) {
        $posicion = new Posicion();
        $posicion->codRally = $datos["codRally"];
        $posicion->codPiloto = $datos["codPiloto"];
        $posicion->posicion = $datos["posicion"];
        $posicion->save();
        return $posicion;
    }

    public function dimeSiResultadoRepetido($codRally, $codPiloto) {
        return Posicion::where("codRally", $codRally)->where("codPiloto", $codPiloto)->count() > 0;
    }
}