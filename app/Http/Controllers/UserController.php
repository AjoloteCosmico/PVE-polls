<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Spatie\Permission\Traits\HasRoles;
class UserController extends Controller
{
    public function give_permission($id,$permission){
        $user=User::find($id);
        // dd($user);
        $user->givePermissionTo($permission);
    }
    public function revoke_permission($id,$permission){
        $user=User::find($id);
        $user->revokePermissionTo($permission);
    }
}
