<?php

define('DSN', 'mysql:host=localhost;dbname=user_dotinstall');
define('DB_USER', 'dbuser');
define('DB_PASSWORD', 'rwrwrwrw0521');

// 相対バス、絶対パスどちらで指定しているかを認識していくこと。
// [ アドバンス ]階層が変わることを考える（拡張性）と相対パスで指定
define('SITE_URL', 'http://192.168.33.10/php/user/');
define('PASSEWORD_KEY', 'rwrwrwrw0521');

error_reporting(E_ALL & ~E_NOTICE);

session_set_cookie_params(0, '/user/');
