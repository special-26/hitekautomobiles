<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopBrandProfile extends Model
{
    protected $fillable = [
        'name',
        'logo_path',
        'phone',
        'email',
        'address',
        'website',
        'primary_color',
        'secondary_color',
        'instagram_handle',
        'facebook_handle',
        'default_call_to_action',
    ];
}
