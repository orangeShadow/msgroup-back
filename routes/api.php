<?php

use App\Models\Api\User;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Создаём токен авторизации
Route::post('/auth/token', function (Request $request) {
    $request->validate([
        'verify_token' => 'required',
        'device_name' => 'required',
    ]);

    // Подключаем Firebase SDK
    $auth = app('firebase.auth');

    // Проверяем Firebase токен
    try {
        $verifiedIdToken = $auth->verifyIdToken($request->verify_token);
    }
    catch (InvalidToken $e) {
        return $e->getMessage();
    }
    catch (\InvalidArgumentException $e) {
        return $e->getMessage();
    }

    // Получаем данные пользователя Firebase
    $uid = $verifiedIdToken->claims()->get('sub');
    $fb_user = $auth->getUser($uid);

    // Вытаскиваем номер телефона
    $phone = preg_replace('~[^0-9]+~', '', $fb_user->phoneNumber);
    if (!$phone) abort(400, 'Не указан номер телефона');

    // Проверяем, есть ли такой пользователь у нас в БД
    $user = User::query()->where('phone', '=', $phone)->first();

    // Если такого пользователя нет, регаем его
    if (!$user)
    {
        User::query()->insert([
            'phone' => $phone,
            'role' => config('roles.client.id'),
        ]);
        $user = User::query()->where('phone', '=', $phone)->first();
    }

    // Возвращаем токен
    return $user->createToken($request->device_name)->plainTextToken;
});


// Возвращаем данные авторизованного пользователя
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new \App\Http\Resources\UserResource($request->user());
});


// Методы, требующие авторизацию
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResources([
        // Пользователи
        'users' => UsersController::class,

        // Статусы заказа
        'statuses' => StatusController::class,

        // Меняем статус заказа
//        'deals/{deal_id}/status/{status}' => DealStatusController::class,


        // Заказы
        // - Список
        // - Просмотр заказа
        // - Создание
        // - Правка
        // - "Удаление"
        'deals' => DealController::class,

        // Отзывы
        // - Список отзывов
        // - Добавление отзыва о клиенте
        // - Добавление отзыва о мастере
        'reviews/client' => ReviewClientController::class,
        'reviews/master' => ReviewMasterController::class,

        // Чат
        // - Список сообщений чата
        // - Отправка сообщения в чат
        'chat/command' => ChatCommandController::class,
        'chat/client'  => ChatClientController::class,

        // ** Прикрепление видео
        // - Просто ссылка или загрузка на Ютуб?
//    'video' => VideoController::class,

        // Список клиентов
        // - Список
        // - Карточка клиента
        // - Добавляем скидку
        'clients' => ClientsController::class,

        // Список мастеров
        // - Список
        // - Карточка мастера
        // - Штрафуем мастера
        'masters' => MastersController::class,

        // * Статистика
        'stats' => StatsController::class,

        // PUSH
        // - Список push-уведомлений
        // - Просмотр push-уведомления, отметка о прочтении push
        'pushes' => PushController::class,
    ]);

    // Меняем статусы сделок
    Route::post('deals/{deal_id}/status/{status}',
        [App\Http\Controllers\Api\V1\DealController::class, 'set_status']);

    // Загрузка видео
    Route::post('video/{type}/{deal_id}',
        [App\Http\Controllers\Api\V1\VideoController::class, 'update']);
});


// Методы, работающие без авторизации
Route::apiResources([
    // Производители устройств
    'manufacturers' => ManufacturerController::class,

    // * Модели устройств
//    'models' => DeviceModelsController::class,

    // Состояния устройств
    'conditions' => ConditionController::class,

    // Виды неисправностей
    'malfunctions' => MalfunctionController::class,

    // Откуда узнали про нас?
    'sources' => SourceController::class,

    // Правила обработки персональных данных
    'tos' => TosController::class,

    // Список пунктов приёмки/выдачи
    'points' => PointController::class,
]);
