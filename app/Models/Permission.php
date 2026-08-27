<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasUuids;

    protected $table = 'permissions';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $keyType = 'string';

}
