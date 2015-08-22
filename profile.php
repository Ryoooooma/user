<?php

session_start();

require_once('config.php');
require_once('functions.php');


if (empty($_SESSION['me'])) {
	header('Location:' .SITE_URL.'login.php');
}

$me = $_SESSION['me'];

$dbh = connectDb();

$sql = "select * from users where id = :id limit 1";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(":id" => (int)$_GET['id']));
$user = $stmt->fetch();

if (!$user) {
	echo "そのようなユーザーは存在しません。";
	exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title><?php echo h($user['name']); ?>さんのプロフィール</title>
	</head>
	<body>
		<h1><?php echo h($user['name']); ?>さんのプロフィール</h1>
		<p>お名前：<?php echo h($user['name']); ?></p>
		<p>メールアドレス：<?php echo h($user['email']); ?></p>
		<p><a href="index.php">一覧に戻る</a></p>
		<p><a href="logout.php">ログアウト</a></p>
	</body>
</html>