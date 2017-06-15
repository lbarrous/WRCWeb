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
        return Piloto::all();
    }
}