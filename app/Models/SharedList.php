<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedList extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'owner', 'allowedUsers'];

    public static function updateOrCreate($list)
    {
        $newRow = new SharedList;

        // Check errors

        $newRow->title = $list->title;
        $newRow->owner = $list->owner;
        $newRow->allowedUsers = $list->allowedUsers;

        $newRow->save();
    }

    public static function remove($id){
        $list = SharedList::find($id);

        if($list){
            $list->delete();
            return true;
        }

        return false;
    }

}
