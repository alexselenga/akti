<?php

namespace App\Models;

use App\Contracts\Captions;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements Captions
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'level1',
        'level2',
        'level3',
        'price',
        'price_sp',
        'amount',
        'prop_fields',
        'joint_purchases',
        'unit',
        'image',
        'show_on_main',
        'description',
    ];

    protected $casts = [
        'price'        => 'float',
        'price_sp'     => 'float',
        'amount'       => 'integer',
        'show_on_main' => 'integer',
    ];

    static public function getCaptions(): array
    {
        return [
            'code'            => 'Код',
            'name'            => 'Наименование',
            'level1'          => 'Уровень1',
            'level2'          => 'Уровень2',
            'level3'          => 'Уровень3',
            'price'           => 'Цена',
            'price_sp'        => 'Цена СП',
            'amount'          => 'Количество',
            'prop_fields'     => 'Поля свойств',
            'joint_purchases' => 'Совместные покупки',
            'unit'            => 'Ед. изм.',
            'image'           => 'Картинка',
            'show_on_main'    => 'Выводить на главной',
            'description'     => 'Описание',
        ];
    }
}
