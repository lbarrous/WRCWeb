<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Entities;
use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    protected $table = 'coche';
    protected $primaryKey = 'codCoche';
    public $timestamps = false;
}