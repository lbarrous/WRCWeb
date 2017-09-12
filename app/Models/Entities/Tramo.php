<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Entities;
use Illuminate\Database\Eloquent\Model;

class Tramo extends Model
{
    protected $table = 'tramo';
    protected $primaryKey = 'codTramo';
    protected $fillable = ['totalKms', 'dificultad', 'codRally'];
    public $incrementing = false;
    public $timestamps = false;
}