<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Entities;
use Illuminate\Database\Eloquent\Model;

class Piloto extends Model
{
    protected $table = 'piloto';
    protected $primaryKey = 'codPiloto';
    public $incrementing = false;
    public $timestamps = false;
}