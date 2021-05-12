<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interval extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'created_at',
        'updated_at',
    ];

    /**
     * Função para retornar metade do intervalo que foi definido.
     * @param string       $interval
     */
    public static function halfInterval($interval)
    {
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $interval);

        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

        $half_time_seconds = ($hours * 3600 + $minutes * 60 + $seconds)/2;

        return gmdate("H:i:s", $half_time_seconds);
    }

    /**
     * Função para converter o horário do formato H:m:s para milissegundos
     * @param string       $time
     */
    public static function convertToMilis($time)
    {
        $temp = explode(":", $time);
        
        $time = $temp[0] * 3600000 + $temp[1] * 60000 + $temp[2] * 1000;

        return $time;
    }
}
