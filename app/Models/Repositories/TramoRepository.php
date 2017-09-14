<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use App\Models\Entities\Rally;
use App\Models\Entities\Tramo;


class TramoRepository
{

    public function getAllTramosRallies() {
        $rallies = Rally::all();
        $tramos = array();

        foreach ($rallies as $rally) {
            $tramos_rally = Tramo::where('codRally', $rally->codRally)->get();
            foreach ($tramos_rally as $tramo) {
                $tramos[$rally->codRally]["nombre_rally"] = $rally->nombre;
                $tramos[$rally->codRally]["tramos"][] = $tramo;
            }
        }

        return $tramos;
    }
}