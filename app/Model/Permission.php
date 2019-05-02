<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

/**
 * App\Model\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Role[] $roles
 * @mixin \Eloquent
 */
class Permission extends EntrustPermission
{
    //
}
