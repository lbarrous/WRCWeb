<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 13/09/2017
 * Time: 11:19
 */

namespace app\Models\Entities;
use Illuminate\Database\Eloquent\Model;

class Corre extends Model
{
    protected $table = 'corre';
    protected $primaryKey = ['codPiloto', 'codTramo'];
    public $timestamps = false;
    public $incrementing = false;
}