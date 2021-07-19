<?php
/*
    |--------------------------------------------------------------------------
    | Статусы заказов
    |--------------------------------------------------------------------------
    |
    |
    |
    */

$statuses = [
    'acceptance' => [
        'id' => 0,
        'title' => 'Приёмка'
    ],
    'delivery_a' => [
        'id' => 1,
        'title' => 'Доставка на диагностику'
    ],
    'diagnostics' => [
        'id' => 2,
        'title' => 'Диагностика'
    ],
    'negotiation' => [
        'id' => 3,
        'title' => 'Согласование'
    ],
    'agreed' => [
        'id' => 4,
        'title' => 'Ожидает ремонт'
    ],
    'waiting' => [
        'id' => 5,
        'title' => 'Ожидание запчастей'
    ],
    'repair' => [
        'id' => 6,
        'title' => 'Ремонт'
    ],
    'delivery_b' => [
        'id' => 7,
        'title' => 'Доставка на выдачу'
    ],
    'payment' => [
        'id' => 8,
        'title' => 'Ожидает оплату'
    ],
    'ready' => [
        'id' => 9,
        'title' => 'Готово к выдаче'
    ],
    'completed' => [
        'id' => 10,
        'title' => 'Завершено'
    ],
];

foreach ($statuses as $key => $item)
{
    $statuses[$key]['name'] = $key;
    $statuses[$item['id']] = &$statuses[$key];
}

return $statuses;
