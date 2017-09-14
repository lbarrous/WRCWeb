<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use App\Models\Entities\Corre;
use App\Models\Entities\Piloto;
use App\Models\Entities\Posicion;
use App\Models\Entities\Rally;


class TiemposRepository
{
    public function getAllTiempos() {
        $pilotos = Piloto::all();

        $tiempos = array();
        foreach ($pilotos as $piloto) {
            $tiempos_piloto = \DB::table('piloto')->join('corre', 'corre.codPiloto', '=', 'piloto.codPiloto')->join('tramo', 'tramo.codTramo', '=', 'corre.codTramo')
                ->join('rally', 'rally.codRally', '=', 'tramo.codRally')
                ->select('piloto.codPiloto', 'nombreP', 'corre.codTramo', 'corre.tiempo', 'tramo.dificultad', 'tramo.totalKms')
                ->where('piloto.codPiloto', $piloto->codPiloto)->get();
            $tiempos[$piloto->codPiloto]["nombre"] = $piloto->nombreP;
            $tiempos[$piloto->codPiloto]["codPiloto"] = $piloto->codPiloto;
            $tiempos[$piloto->codPiloto]["tiempos"] = $tiempos_piloto;
        }
        return $tiempos;
    }

    public function eliminarTiempo($codPiloto, $codTramo) {

        $resultado = Corre::where('codPiloto', $codPiloto)->where('codTramo', $codTramo)->delete();

        return $codPiloto.$codTramo;
    }

    public function createTiempo($datos) {
        $tramo = new Corre();
        $tramo->codTramo = $datos["tramo"];
        $tramo->codPiloto = $datos["codPiloto"];
        $tramo->tiempo = $datos["tiempo"];
        $tramo->save();
        return $tramo;
    }

    public function dimeSiTiempoRepetido($codPiloto, $codTramo) {
        return Corre::where("codTramo", $codTramo)->where("codPiloto", $codPiloto)->count() > 0;
    }
}