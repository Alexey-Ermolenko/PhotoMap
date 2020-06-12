<?php
/**
 * @var array  $user
 * @var string $browser_url
 */

use components\Helper;


if ($browser_url) {
    ?>
    <h1>Добро пожаловать!</h1>
    <a class="btn btn-default" href="<?= $browser_url ?>" role="button">Авторизоваться</a>
    <?php
}

if ($user) {
    Helper::pre($user);
}
?>