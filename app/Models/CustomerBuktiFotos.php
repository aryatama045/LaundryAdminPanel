<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBuktiFotos extends Model
{

    use HasFactory;
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function getTime($time)
    {
        $times = [
            '8' => '08 - 09:59',
            '9' => '08 - 09:59',
            '10' => '10 - 11:59',
            '11' => '10 - 11:59',
            '12' => '12 - 13:59',
            '13' => '12 - 13:59',
            '14' => '14 - 15:59',
            '15' => '14 -1 5:59',
            '16' => '16 - 17:59',
            '17' => '16 - 17:59',
            '18' => '18 - 19:59',
            '19' => '18 - 19:59',
            '20' => '20 - 21:59',
            '21' => '20 - 21:59',
        ];
        foreach($times as $key => $item){
            if($key == $time){
                return $item;
            }
        }
    }
}
