<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SharedList;
use App\Models\User;
use function Symfony\Component\String\length;


class SharedListsApiController extends Controller
{
    //
    public function index(Request $request, $id){
        return SharedList::where('owner', $id)
            ->orWhere('allowedUsers', 'like', "%<${id}>%")
            ->get();

    }

    public function index_allowedUsers(Request $request, $id){
        $data = SharedList::select('allowedUsers')
            ->where('id', $id)
            ->first();

        if($data->allowedUsers !== ":"){
            $decodedUsers = $this->decodeAllowedUsers($data->allowedUsers);
            $users = [];

            foreach ($decodedUsers as $user_id){
                $users[] = User::select('name')
                            ->where('id', $user_id)
                            ->first();
            }

            return response($users, 200);
        }

        return response([], 204);

    }

    public function create(Request $request){
        $fields = $request->validate([
            'title' => 'required|string',
            'owner' => 'required|integer|exists:users,id',
            'allowedUsers' => 'string'
        ]);

        $list = array(
            "title" => $fields["title"],
            "owner" => $fields["owner"],
            "allowedUsers" => $fields["allowedUsers"]
        );

        return SharedList::create($list);
    }

    public function update(Request $request, $id){
        $list = SharedList::find($id);

        if($list){
            $all = $request->all();

            if(isset($all['allowedUsers'])){
                if($this->allowedUserExists($all['allowedUsers'])){ //Check if last user already is allowed
                    return response([
                        'success'=> false,
                        'message'=>'User already allowed!'
                    ], 200);
                }
            }

            $list->update($all);

            return
                response([
                    'success'=> true,
                    ...$list->toArray()
                ]);
        }

        return response([
            'success'=> false,
            'message'=>'Update list failed. List id not found!'
        ], 200);
    }

    public function delete(Request $request, $id){
        $status = SharedList::remove($id);

        return [
            "deleted" => $status
        ];
    }

    // Utilities functions -------------

    public function decodeAllowedUsers($toDecode){
        $arr = explode(',', $toDecode);
        $users = [];

        foreach ($arr as $user){
            if($user && $user !== ':'){
                $users[] = substr($user, 1, strlen($user) - 2);
            }
        }

        return $users;
    }

    public function encodeAllowedUsers($toEncode){
        $allowedUsers = "";

        foreach ($toEncode as $user_id){
            $allowedUsers .= ",<{$user_id}>";
        }

        return $allowedUsers;
    }

/*    public function removeDuplicatesAllowedUsers($toRemove){
        $users = $this->decodeAllowedUsers($toRemove);
        $users = array_unique($users);
        return $this->encodeAllowedUsers($users);
    }*/

    public function allowedUserExists($allowedUsers){
        $allowedUsers = $this->decodeAllowedUsers($allowedUsers);
        $user = array_pop($allowedUsers);
        return in_array($user, $allowedUsers);
    }

    //----------------------------------
}
