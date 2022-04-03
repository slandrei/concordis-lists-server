<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age'];

    public static function updateOrCreate($name, $age)
    {
        $newRow = new Dummy;

        $newRow->name = $name;
        $newRow->age = $age;

        $newRow->save();
    }

}
