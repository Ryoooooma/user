<?php

session_start();

require_once('config.php');
require_once('functions.php');


if (empty($_SESSION['me'])) {
	header('Location:' .SITE_URL.'login.php');
}

$me = $_SESSION['me'];

$dbh = connectDb();

$users = array();

$sql = "select * from users order by created desc";
foreach ($dbh->query($sql) as $row) {
	array_push($users, $row);
} 

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>ホーム画面</title>
	</head>
	<body>
		<p>「<?php echo h($me['name']); ?>」さん、こんにちは！</p>
		<p>あなたのアドレスは「<?php echo h($me['email']); ?>」です。</p>
		<hr>
		<h1>ユーザー一覧</h1>
		<ul>
			<?php foreach ($users as $user) : ?>
				<li><a href="profile.php?id=<?php echo h($user['id']); ?>"><?php echo h($user['name']); ?></a></li>
			<?php endforeach ; ?>
		</ul>
		<p><a href="logout.php">ログアウト</a></p>
	</body>
</html>