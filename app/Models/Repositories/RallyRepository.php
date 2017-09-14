<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:44
 */

namespace app\Models\Repositories;
use App\Models\Entities\Rally;
use App\Models\Entities\Tramo;


class RallyRepository
{

    public function getAllRallies() {
        return Rally::all();
    }

    public function getRallyByCod($codRally) {
        return Rally::where('codRally', $codRally)->first();
    }

    public function createRally() {
        $rally = new Rally;
        $max_cod = Rally::whereRaw('codRally = (select max(`codRally`) from rally)')->first();
        $nuevoCod = "R".sprintf("%03s", intval(substr($max_cod->codRally, 1))+1);
        $rally->codRally = $nuevoCod;
        $rally->nombre = mt_rand();
        $rally->save();
        return $rally;
    }

    public function updateRallyByCod($codRally, $datos) {

        $rally = Rally::where('codRally', $codRally)->first();

        if($rally->nombre != $datos["nombre"])
            $rally->nombre = $datos["nombre"];
        $rally->pais = $datos["pais"];
        $date = str_replace('/', '-', $datos["fecha"]);
        $date = date('Y-m-d', strtotime($date));
        $rally->fecha = $date;

        return $rally->save();
    }

    public function getTramosByCodRally($codRally) {

        $tramos = Tramo::where('codRally', $codRally)->get();

        return $tramos;
    }

    public function getTramosByCodRallyCompleja($codRally) {

        $tramos = \DB::select("SELECT * FROM rally r
                                inner join tramo t
                                on t.codRally = r.codRally
                                
                                inner join corre c
                                on c.codTramo = t.codTramo
                                
                                inner join piloto p
                                on p.codPiloto = c.codPiloto
                                
                                where r.codRally = '".$codRally."'");

        return $tramos;
    }

    public function addTramoByCodRally($codRally, $datos) {

        if(Tramo::where('codRally', $codRally)->count() > 0) {
            $ultimo_tramo = Tramo::where('codRally', $codRally)->orderBy('codTramo', 'DESC')->first();

            $ultimo_tramo = intval(substr($ultimo_tramo->codTramo,1,1))+1;
            $rally = 'R'.intval(substr($codRally, 1));
            $codTramo = "T".$ultimo_tramo."-".$rally;

            $tramo = new Tramo;
            $tramo->totalKms = $datos["totalKms"];
            $tramo->dificultad = $datos["dificultad"];
            $tramo->codTramo = $codTramo;
            $tramo->codRally = $codRally;
            $tramo->save();

            return $tramo;
        }
        else {
            $rally = 'R'.intval(substr($codRally, 1));
            $codTramo = "T1-".$rally;

            $tramo = new Tramo;
            $tramo->totalKms = $datos["totalKms"];
            $tramo->dificultad = $datos["dificultad"];
            $tramo->codTramo = $codTramo;
            $tramo->codRally = $codRally;
            $tramo->save();

            return $tramo;
        }
    }

    public function eliminarTramo($codTramo) {

        $tramo = Tramo::where('codTramo', $codTramo)->delete();

        return $codTramo;
    }

    public function eliminarRally($codRally) {

        $rally = Rally::where('codRally', $codRally)->delete();

        return $codRally;
    }

    public function dimeSiRallyTieneParticipacion($codRally) {

            $rally_ocupado = \DB::select("select * from rally r
            inner join tramo t
            on t.codRally = r.codRally
            inner join corre c
            on c.codTramo = t.codTramo
            where t.codTramo in (select codTramo from tramo where codRally = '".$codRally."')
            ");

            return empty($rally_ocupado);
    }
}