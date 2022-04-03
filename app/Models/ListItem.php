<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListItem extends Model
{
    use HasFactory;

    protected $fillable = ['list_id', 'text', 'qty'];

    public static function updateOrCreate($item)
    {
        $newRow = new ListItem;

        // Check errors
        $newRow->list_id = $item->list_id;
        $newRow->text = $item->text;
        $newRow->qty = $item->qty;

        $newRow->save();
    }

    public static function remove($id){
        $item = ListItem::find($id);

        if($item){
            $item->delete();
            return true;
        }

        return false;
    }
}
