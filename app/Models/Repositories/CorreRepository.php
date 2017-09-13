<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use App\Models\Entities\Corre;


class CorreRepository
{
    public function dimeSiTramoEsRecorrido($codTramo) {
        return Corre::where("codTramo", $codTramo)->count() > 0;
    }
}