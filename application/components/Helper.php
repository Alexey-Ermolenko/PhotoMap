<?php

namespace components;

use VK\Client\VKApiClient;
use VK\Client\Enums\VKLanguage;

class Helper
{
    /**
     * @return mixed
     */
    public static function getRealIpAddr()
    { //получаем ip
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   // Определение IP
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { // Если пользователь использует прокси
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * @return mixed|string
     */
    public static function detectSearchBots()
    {
        //определяем поисковых ботов
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'YandexBot')) {
            return $bot = 'YandexBot';
        } elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {
            return $bot = 'Googlebot';
        } else {
            return $bot = $_SERVER['HTTP_USER_AGENT'];
        }
    }

    /**
     * @param $coords
     *
     * @return mixed
     */
    public static function getLocWeather($coords)
    {
        //http://api.openweathermap.org/data/2.5/find?lat=55.0084&lon=82.9357&mode=json&APPID=13457fc1cf149b8e15ac1faed8153972&lang=ru&units=metric
        $res = json_decode(fileGetContentsCurl('http://api.openweathermap.org/data/2.5/find?lat=' . $coords['lat'] . '&lon=' . $coords['lon'] . '&mode=json&APPID=13457fc1cf149b8e15ac1faed8153972&lang=ru&units=metric'), true);
        if ($res['cod'] === '200') {
            $result['city']                   = $res['list'][0]['name'];
            $result['temp']                   = $res['list'][0]['main']['temp'];
            $result['dt']                     = $res['list'][0]['dt'];
            $result['wind']['speed']          = $res['list'][0]['wind']['speed'];
            $result['wind']['deg']            = $res['list'][0]['wind']['deg'];
            $result['weather']['description'] = $res['list'][0]['weather'][0]['description'];
            $result['weather']['icon']        = 'http://openweathermap.org/img/w/' . $res['list'][0]['weather'][0]['icon'] . '.png';
        }

        return $result;
    }

    /**
     * @param $coords
     *
     * @return array
     */
    public static function getUserLocCity($coords): array
    {
        //	http://maps.google.com/maps/api/geocode/json?latlng=55.030197143555,82.920433044434&sensor=false
        $res = json_decode(fileGetContentsCurl('http://maps.google.com/maps/api/geocode/json?latlng=' . $coords['lat'] . ',' . $coords['lon'] . '&sensor=false&language=ru'));
        /*	if ($res=$res->status == 'OK') {
                $res=$res->results[0]->address_components[2]->long_name;
            } else {
                $res='null';
            }*/
        $city_name  = $res->results[0]->address_components[2]->long_name; //город
        $dist_name  = $res->results[0]->address_components[4]->long_name; //область
        $state_name = $res->results[0]->address_components[5]->long_name; //страна

        return ['city_name' => $city_name, 'dist_name' => $dist_name, 'state_name' => $state_name];
    }

    /**
     * @param string $unixtime
     *
     * @return false|string
     */
    public static function convertFromUnixtime($unixtime = '0000000000')
    {
        $timeMask = 'd.m.Y H:i:s';// ДД-ММ-ГГГГ чч:мм:сс
        $time     = date($timeMask, intval($unixtime));

        return $time;
    }

    /**
     * @param string $time
     *
     * @return false|int
     */
    public static function convertToUnixtime($time = '01.01.1970 00:00:00')
    {
        $dt_elements   = explode(' ', $time);
        $date_elements = explode('.', $dt_elements[0]);
        $time_elements = explode(':', $dt_elements[1]);

        return mktime(($time_elements[0]), ($time_elements[1]), (0), ($date_elements[1]), ($date_elements[0]), ($date_elements[2]));
    }

    /**
     * @param bool $arr
     */
    public static function pre($arr = false)
    {
        $debug = debug_backtrace();
        echo "<pre  style='background:#fff; color:#000; border:1px solid #CCC;padding:10px;border-left:4px solid red; font:normal 11px Arial;'><small>" . str_replace($_SERVER['DOCUMENT_ROOT'], "", $debug[0]['file']) . " : {$debug[0]['line']}</small>\n" . print_r($arr, true) . "</pre>";
    }

    /**
     * @param $url
     */
    public static function redirect($url)
    {
        header('HTTP/1.1 301 Moved Permanently');
        header("Location:" . $url);
        exit();
    }

    public static function getResult()
    {
        return $result = 0;
    }

    /**
     * @param $array
     */
    public static function setUser($array)
    {
        $vk = new VKApiClient($GLOBALS['config']['vk_api_version'], VKLanguage::RUSSIAN);

        $user = $vk->users()->get($array['access_token'], [
            'uids'         => $array['user_id'],
            'v'            => $GLOBALS['config']['vk_api_version'],
            'fields'       => 'first_name,last_name,nickname,screen_name,sex,bdate,city,country,timezone,photo,photo_medium,photo_big,has_mobile,rate,contacts,education,online,counters',
            'access_token' => $array['access_token'],
        ]);

        $array['extra_fields'] = reset($user);

        $_SESSION['user'] = $array;
    }

    /**
     * @return mixed
     */
    public static function getUser()
    {
        return $_SESSION['user'];
    }

    /**
     * @return bool
     */
    public static function isAuthUser(): bool
    {
        return !!$_SESSION['user'];
    }
}
	