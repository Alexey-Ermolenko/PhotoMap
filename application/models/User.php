<?php

use VK\Client\VKApiClient;

/**
 *
 * Класс для работы с пользователем вк
 *
 */
class User extends Model
{
    public static function getUser()
    {
        return $_SESSION['user'];
    }

    public static function setUser()
    {
        $vk = new VKApiClient($GLOBALS['config']['vk_api_version'], VK\Client\Enums\VKLanguage::RUSSIAN);
        $user = $_SESSION['user'];
        $user['extra_fields'] = $vk->users()->get($user['access_token'], [
            'user_ids' => $user['user_id'],
            'fields' => [
                'first_name',
                'last_name',
                'nickname',
                'screen_name',
                'sex',
                'bdate',
                'city', 'country',
                'timezone',
                'photo',
                'photo_medium',
                'photo_big',
                'has_mobile',
                'rate',
                'contacts',
                'education',
                'online',
                'counters',
            ],
        ]);

        $_SESSION = $user;
    }

    public static function login()
    {

    }

    public static function logout()
    {

    }
}
