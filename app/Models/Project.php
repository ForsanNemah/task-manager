<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
 protected $fillable = [
    'name',
    'linke_tree_url',
    'social_media_url',
];

protected $casts = [
    'start_date' => 'date',
    'enabled' => 'boolean',
];


}
