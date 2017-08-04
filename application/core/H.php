<?php

class H
{
    public static function getTime($formatTime = 'Y-m-d H:i:s'){
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Cancun'));

        $fdate = $date->format($formatTime);
        return $fdate;
    }

    public static function formatDate($fecha){
        $dia = explode('-', $fecha);

        $mes = $dia[1];
        switch ($dia[1]) {
            case '01': $mes = 'Enero'; break;
            case '02': $mes = 'Febrero'; break;
            case '03': $mes = 'Marzo'; break;
            case '04': $mes = 'Abril'; break;
            case '05': $mes = 'Mayo'; break;
            case '06': $mes = 'Junio'; break;
            case '07': $mes = 'Julio'; break;
            case '08': $mes = 'Agosto'; break;
            case '09': $mes = 'Septiembre'; break;
            case '01': $mes = 'Octubre'; break;
            case '01': $mes = 'Noviembre'; break;
            case '01': $mes = 'Diciembre'; break;
        }

        $day = $dia[2].'-'.$mes.'-'.$dia[0];
        return $day;
    }

    public static function formatShortDate($fecha){
        $dia = explode('-', $fecha);

        $mes = $dia[1];
        switch ($dia[1]) {
            case '01': $mes = 'Ene'; break;
            case '02': $mes = 'Feb'; break;
            case '03': $mes = 'Mar'; break;
            case '04': $mes = 'Abr'; break;
            case '05': $mes = 'May'; break;
            case '06': $mes = 'Jun'; break;
            case '07': $mes = 'Jul'; break;
            case '08': $mes = 'Ago'; break;
            case '09': $mes = 'Sep'; break;
            case '01': $mes = 'Oct'; break;
            case '01': $mes = 'Nov'; break;
            case '01': $mes = 'Dic'; break;
        }

        $day = $dia[2].'-'.$mes.'-'.$dia[0];
        return $day;
    }

    public static function getAge($birthday){
        $nacimiento = explode('-', $birthday);

        $anio_dif = date("Y") - $nacimiento[0];
        $mes_dif  = date("m") - $nacimiento[1];
        $dia_dif  = date("d") - $nacimiento[2];

        if (($dia_dif < 0 && $mes_dif == 0) || ($mes_dif < 0)) 
            $anio_dif--;
        
        return $anio_dif; //edad
    }
}
