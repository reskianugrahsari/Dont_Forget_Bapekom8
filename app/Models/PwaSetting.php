<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PwaSetting extends Model
{
    protected $table = 'pwa_settings';

    protected $fillable = [
        'app_name',
        'short_name',
        'description',
        'theme_color',
        'background_color',
        'icon_192',
        'icon_512',
        'start_url',
        'display',
        'scope',
        'cache_version',
        'offline_enabled',
    ];

    protected function casts(): array
    {
        return [
            'offline_enabled' => 'boolean',
        ];
    }
}
