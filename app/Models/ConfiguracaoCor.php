<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoCor extends Model
{
    protected $table = 'configuracoes_cores';

    protected $fillable = [
        'primary_color',
        'secondary_color',
        'accent_color',
        'border_color',
        'background_color',
    ];

    protected $casts = [
        'primary_color' => 'string',
        'secondary_color' => 'string',
        'accent_color' => 'string',
        'border_color' => 'string',
        'background_color' => 'string',
    ];

    public static function global()
    {
        return self::firstOrCreate([], [
            'primary_color' => '#76877D',
            'secondary_color' => '#96958A',
            'accent_color' => '#88B8A9',
            'border_color' => '#B2CBAE',
            'background_color' => '#F8F6F0',
        ]);
    }
}