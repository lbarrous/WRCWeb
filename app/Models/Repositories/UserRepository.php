<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 24/05/2017
 * Time: 12:01
 */

namespace App\Models\Repositories;

use App\Models\Entities\User;

class UserRepository
{
    public function createUser($datos) {
        return User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => bcrypt($datos['password']),
            'birth' => $datos["birth"],
        ]);
    }

    public function getUserByID($id) {
        return User::find($id);
    }
}