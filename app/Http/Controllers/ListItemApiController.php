<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListItem;

class ListItemApiController extends Controller
{
    //
    public function index(Request $request, $list_id){
        return ListItem::where('list_id', $list_id)
            ->get();
    }

    public function create(Request $request){
        //return $request;

        $fields = $request->validate([
            'list_id' => 'required|integer|exists:shared_lists,id',
            'text' => 'required|string',
            'qty' => 'required|integer|',
        ]);

        $item = array(
            "list_id" => $fields["list_id"],
            "qty" => $fields["qty"],
            "text" => $fields["text"]
        );

        return ListItem::create($item);
    }

    public function update(Request $request, $id){
        $item = ListItem::find($id);

        if($item){
            $item->update($request->all());
            return $item;
        }

        return response(['message'=>'Update item failed'], 404);
    }

    public function delete(Request $request, $id){
        $status = ListItem::remove($id);

        return [
            "success" => $status
        ];
    }
}
