<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use App\Models\Entities\Piloto;


class PilotoRepository
{
    public function getAllPilotos() {
        //return Piloto::all();
        return \DB::select("select * from piloto p
            inner join coche c
            on p.coche = c.codCoche");
    }

    public function getPilotoByCod($codPiloto) {
        return \DB::table('piloto')
            ->join('coche', 'piloto.coche', '=', 'coche.codCoche')
            ->where('codPiloto', $codPiloto)->first();
    }

    public function createPiloto($datos) {
        $piloto = new Piloto();
        $max_cod = Piloto::whereRaw('codPiloto = (select max(`codPiloto`) from piloto)')->first();
        $nuevoCod = "P".sprintf("%03s", intval(substr($max_cod->codPiloto, 1))+1);
        $piloto->codPiloto = $nuevoCod;

        $piloto->nombreP = $datos["nombre"];
        $piloto->grupoS = $datos["grupoS"];
        $piloto->rh = $datos["rh"];
        $piloto->nombreCop = $datos["nombreCop"];
        if($datos["coche"] != "" && $datos["coche"] != null)
            $piloto->coche = $datos["coche"];
        else
            $piloto->coche = "";

        $piloto->save();
        return $piloto;
    }

    public function updatePilotoByCod($codPiloto, $datos) {

        $piloto = Piloto::where('codPiloto', $codPiloto)->first();

        if($piloto->nombreP != $datos["nombre"])
            $piloto->nombreP = $datos["nombre"];
        $piloto->grupoS = $datos["grupoS"];
        $piloto->rh = $datos["rh"];
        $piloto->nombreCop = $datos["nombreCop"];
        $piloto->coche = $datos["coche"];

        return $piloto->save();
    }

    public function dimeSiPilotoTieneParticipacion($codPiloto) {

        $piloto_ocupado = \DB::select("select * from piloto p
            inner join corre c
            on c.codPiloto = p.codPiloto
            where p.codPiloto in (select codPiloto from corre where codPiloto = '".$codPiloto."')
            ");

        return empty($piloto_ocupado);
    }

    public function eliminarPiloto($codPiloto) {

        $piloto = Piloto::where('codPiloto', $codPiloto)->delete();

        return $codPiloto;
    }
}