<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use App\Models\Entities\Coche;


class CocheRepository
{
    public function getAllCoches() {
        return Coche::all();
    }

    public function getCocheByCod($codCoche) {
        return Coche::where("codCoche", $codCoche)->first();
    }

    public function getCochesLibres() {
        return \DB::select("select * from coche c
            where c.codCoche not in (select coche from piloto)
            ");
    }

    public function dimeSiCocheTienePiloto($codCoche) {

        $piloto_ocupado = \DB::select("select codCoche from coche c
            inner join piloto p
            on p.coche = c.codCoche
            where codCoche = '".$codCoche."'");

        return empty($piloto_ocupado);
    }

    public function eliminarCoche($codCoche) {

        $coche = Coche::where('codCoche', $codCoche)->delete();

        return $codCoche;
    }

    public function createCoche() {
        $coche = new Coche();
        $max_cod = Coche::whereRaw('codCoche = (select max(`codCoche`) from coche)')->first();
        $nuevoCod = "C".sprintf("%03s", intval(substr($max_cod->codCoche, 1))+1);
        $coche->codCoche = $nuevoCod;
        $coche->marca = mt_rand();
        $coche->save();
        return $coche;
    }

    public function updateCocheByCod($codCoche, $datos) {

        $coche = Coche::where('codCoche', $codCoche)->first();

        $coche->marca = $datos["marca"];
        $coche->modelo = $datos["modelo"];
        $coche->cilindrada = $datos["cilindrada"];

        return $coche->save();
    }
}