<?php

session_start();

require_once('config.php');
require_once('functions.php');


if (empty($_SESSION['me'])) {
	header('Location:' .SITE_URL.'login.php');
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>ホーム画面</title>
	</head>
	<body>
		<h1>ユーザー一覧</h1>
	</body>
</html>