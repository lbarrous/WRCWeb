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
        return Rally::where('codRally', $codRally)->get();
    }

    public function updatetRallyByCod($codRally, $datos) {

        $rally = Rally::where('codRally', $codRally)->first();

        $rally->nombre = $datos["nombre"];
        $rally->pais = $datos["pais"];
        $date = str_replace('/', '-', $datos["fecha"]);
        $date = date('Y-m-d', strtotime($date));
        $rally->fecha = $date;

        return $rally->save();
    }
}