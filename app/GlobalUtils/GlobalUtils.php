<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 01/06/2017
 * Time: 19:29
 */


class GlobalUtils
{
    public static function inicializaOpcionesDatatable() {

        $opcionesDatatable = array( "responsive" => "true",
            "language" => array(
                "search" =>  "Busqueda",
                "loadingRecords"=> "Cargando...",
                "lengthMenu" => "Mostrando _MENU_",
                "zeroRecords"=> "Sin registros",
                "processing" => "Procesandp",
                "info"=> "Mostrando pÃ¡gina _PAGE_ de _PAGES_",
                "infoEmpty"=> "Sin Registros",
                "infoFiltered"=> "(Resultado filtrado de un total de _MAX_ registros)",
                "paginate" => array (
                    "first"=> "Primera",
                    "previous"=> "<strong><</strong>",
                    "next"=> "<strong>></strong>",
                    "last"=> "Última",
                )
            ),
            "aoColumns"	=> array(//Poblar en cada respectivo metodo de tabla)
            ),
            "columnDefs" => array(
                array ("className" => 'never', "targets"=> 0 )
            ),
            "order" => array ( array(0, 'desc') )
        );

        return $opcionesDatatable;
    }
}
