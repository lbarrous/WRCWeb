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
}