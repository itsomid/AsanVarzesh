<?php

namespace App\Model;

use Zizaco\Entrust\EntrustRole;

/**
 * App\Model\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @mixin \Eloquent
 */
class Role extends EntrustRole
{
    //
}
