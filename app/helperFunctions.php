<?php

/**
 * check if a user has permission to see this route
 *
 * @param $Routename
 */

 function hasPermission($Routename)
{
    $permissions = \App\Permission_Role::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();

    foreach ($permissions as $perm) {
        if ($perm->permission->name == $Routename) {
            return true;
        }
    }
    return false;
}

function getRegionName($id){
     return \App\Region::find($id)->name;
}
function getCustomer($id){
    return \App\Customer::find($id)->account_name;
}

?>