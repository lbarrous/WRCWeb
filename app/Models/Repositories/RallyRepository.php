<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use App\Models\Entities\Rally;


class RallyRepository
{
    public function getAllRallies() {
        return Rally::all();
    }

    public function getRallyByCod($codRally) {
        return Rally::where('codRally', $codRally)->first();
    }

    public function createRally() {
        $rally = new Rally;
        $max_cod = Rally::whereRaw('codRally = (select max(`codRally`) from rally)')->first();
        $nuevoCod = "R".sprintf("%03s", intval(substr($max_cod->codRally, 1))+1);
        $rally->codRally = $nuevoCod;
        $rally->nombre = mt_rand();
        $rally->save();
        return $rally;
    }

    public function updateRallyByCod($codRally, $datos) {

        $rally = Rally::where('codRally', $codRally)->first();

        if($rally->nombre != $datos["nombre"])
            $rally->nombre = $datos["nombre"];
        $rally->pais = $datos["pais"];
        $date = str_replace('/', '-', $datos["fecha"]);
        $date = date('Y-m-d', strtotime($date));
        $rally->fecha = $date;

        return $rally->save();
    }
}