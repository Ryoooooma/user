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
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title><?php echo h($me['name']); ?>さんのプロフィール</title>
	</head>
	<body>
		<p>「<?php echo h($me['name']); ?>」さん、こんにちは！</p>
		<p>あなたのアドレスは「<?php echo h($me['email']); ?>」です。</p>
		<hr>
		<h1><?php echo h($me['name']); ?>さんのプロフィール</h1>
		<p>お名前：<?php echo h($me['name']); ?></p>
		<p>メールアドレス：<?php echo h($me['email']); ?></p>
		<p><a href="index.php">一覧に戻る</a></p>
		<p><a href="logout.php">ログアウト</a></p>
	</body>
</html>