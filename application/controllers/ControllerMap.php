<?php

use components\Helper;
use VK\Client\VKApiClient;

class ControllerMap extends Controller
{
    public function actionIndex()
    {
        $this->view->generate('map/index.php', 'template_view.php');
    }

    public function actionFullScreen()
    {
        $this->view->generate('map/fullScreen.php', 'template_view.php');
    }

    public function actionGetVkGeoPhotos()
    {
        if ($_POST['radius'] != "") {
            //ajax request data
            $latitude  = empty($_POST['latitude']) ? '' : $_POST['latitude'];
            $longitude = empty($_POST['longitude']) ? '' : $_POST['longitude'];

            $count  = empty($_POST['count']) ? '300' : $_POST['count'];
            $radius = empty($_POST['radius']) ? '30' : $_POST['radius'];

            $end_time   = empty($_POST['end_time']) ? '0000000000' : Helper::convertToUnixtime($_POST['end_time']);
            $start_time = empty($_POST['start_time']) ? '0000000000' : Helper::convertToUnixtime($_POST['start_time']);

            $params = [
                //'q'            => $_GET['q'],
                'lat'        => $latitude,
                'long'       => $longitude,
                'start_time' => $start_time,
                'end_time'   => $end_time,
                'sort'       => '0',
                'offset'     => '0',
                'count'      => $count,
                'radius'     => $radius,
                'v'          => '5.67',
            ];

            $vk     = new VKApiClient($GLOBALS['config']['vk_api_version'], VK\Client\Enums\VKLanguage::RUSSIAN);
            $photos = $vk->photos()->search($_SESSION['user']['access_token'], $params);

            $data = [];

            foreach ($photos['items'] as $i => $photo) {
                $data[$i] = [
                    'numb'         => $i,
                    'user_id'      => $photos['items'][$i]['owner_id'],
                    'photo_id'     => $photos['items'][$i]['id'],
                    'photo_coords' => [
                        'lat'  => $photos['items'][$i]['lat'],
                        'long' => $photos['items'][$i]['long'],
                    ],
                    'photo_src'    => [
                        'src'       => $photos['items'][$i]['photo_807'],
                        'src_small' => $photos['items'][$i]['photo_130'],
                        'src_big'   => $photos['items'][$i]['photo_2560'],
                    ],

                    'photo_create_date' => date('d.m.Y H:i:s', intval($photos['items'][$i]['date'])),
                    'photo_desc'        => $photos['items'][$i]['text'],
                ];
            }

            echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        }
    }
}
