<?php
/*
    |--------------------------------------------------------------------------
    | Роли пользователей
    |--------------------------------------------------------------------------
    |
    |
    |
    */

$roles = [
    'client' => [
        'id' => 0,
        'title' => 'Клиент',
    ],
    'courier' => [
        'id' => 1,
        'title' => 'Курьер',
    ],
    'master' => [
        'id' => 2,
        'title' => 'Мастер',
    ],
    'manager' => [
        'id' => 3,
        'title' => 'Управляющий',
    ],
    'postamat' => [
        'id' => 4,
        'title' => 'Постамат',
    ],
];

foreach ($roles as $key => $item)
{
    $roles[$key]['name'] = $key;
    $roles[$item['id']] = &$roles[$key];
}

return $roles;
