<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Entities;
use Illuminate\Database\Eloquent\Model;

class Rally extends Model
{
    protected $table = 'rally';
    protected $primaryKey = 'codRally';
    public $timestamps = false;
}