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
}