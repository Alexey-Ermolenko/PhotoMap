<?php
use components\Helper;

class ControllerMain extends Controller
{
    public function actionIndex()
    {
        if ($_SESSION['user']) {
            $this->view->generate('main/index.php', 'template_view.php', [
                'user' => $_SESSION['user'],
            ]);
        } else {
            $oauth        = new VK\OAuth\VKOAuth($GLOBALS['config']['vk_api_version']);
            $display      = VK\OAuth\VKOAuthDisplay::PAGE;
            $scope        = [
                VK\OAuth\Scopes\VKOAuthUserScope::OFFLINE,
                VK\OAuth\Scopes\VKOAuthUserScope::WALL,
                VK\OAuth\Scopes\VKOAuthUserScope::GROUPS,
                VK\OAuth\Scopes\VKOAuthUserScope::AUDIO,
                VK\OAuth\Scopes\VKOAuthUserScope::VIDEO,
                VK\OAuth\Scopes\VKOAuthUserScope::STATS,
            ];
            $client_id    = $GLOBALS['config']['app_id'];
            $redirect_uri = $GLOBALS['config']['redirect_uri'];
            $state        = 'secret_state_code';
            $revoke_auth  = true;

            $browser_url = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state, null, $revoke_auth);

            $this->view->generate('main/index.php', 'template_view.php', [
                'browser_url' => $browser_url,
            ]);
        }
    }

    public function actionAbout()
    {
        $this->view->generate('main/about.php', 'template_view.php');
    }

    public function actionContacts()
    {
        $this->view->generate('main/contacts.php', 'template_view.php');
    }

    public function actionTemperature()
    {
        $coords['lat'] = $_POST['lat'];
        $coords['lon'] = $_POST['lon'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, 'http://api.openweathermap.org/data/2.5/find?lat=' . $coords['lat'] . '&lon=' . $coords['lon'] . '&mode=json&APPID=13457fc1cf149b8e15ac1faed8153972&lang=ru&units=metric');
        $data = curl_exec($ch);
        curl_close($ch);

        //http://api.openweathermap.org/data/2.5/find?lat=55.0084&lon=82.9357&mode=json&APPID=13457fc1cf149b8e15ac1faed8153972&lang=ru&units=metric
        $res = json_decode($data, true);
        if ($res['cod'] === '200') {
            $result['city']                   = $res['list'][0]['name'];
            $result['temp']                   = $res['list'][0]['main']['temp'];
            $result['dt']                     = $res['list'][0]['dt'];
            $result['wind']['speed']          = $res['list'][0]['wind']['speed'];
            $result['wind']['deg']            = $res['list'][0]['wind']['deg'];
            $result['weather']['description'] = $res['list'][0]['weather'][0]['description'];
            $result['weather']['icon']        = 'http://openweathermap.org/img/w/' . $res['list'][0]['weather'][0]['icon'] . '.png';

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    public function actionVerify()
    {
        if ($_GET['code']) {
            $oauth         = new VK\OAuth\VKOAuth();
            $client_id     = $GLOBALS['config']['app_id'];
            $client_secret = $GLOBALS['config']['app_secret'];
            $redirect_uri  = $GLOBALS['config']['redirect_uri'];
            $code          = $_GET['code'];


            $response     = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
            $access_token = $response['access_token'];

            Helper::setUser($response);
            Helper::redirect($GLOBALS['config']['index_url']);
        }

        if ($_GET['error']) {
            exit($_GET['error_description']);
        }
    }

    public function actionLogout()
    {
        if ($_SESSION['user']) {
            unset($_SESSION['user']);
            session_destroy();
            header('HTTP/1.1 301 Moved Permanently');
            header("Location:" . $GLOBALS['config']['index_url']);
            exit();
        }
    }
}
