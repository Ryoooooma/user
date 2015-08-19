<?php

define('DSN', 'mysql:host=localhost;dbname=user_dotinstall');
define('DB_USER', 'dbuser');
define('DB_PASSWORD', 'rwrwrwrw0521');

define('SITE_URL', '192.168.33.10/contact/');
define('PASSEWORD_KEY', 'rwrwrwrw0521');

error_reporting(E_ALL & ~E_NOTICE);

session_set_cookie_params(0, '/user/');
