<?php

session_start();

require_once('config.php');
require_once('functions.php');

if (!empty($_SESSION['me'])) {
	header('Location:'.SITE_URL);
}

function getUser($email, $password, $dbh) {
	$sql = "select * from users where email = :email and password = :password limit 1";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(":email"=>$email, ":password"=>getSha1Password($password)));
	$user = $stmt->fetch();
	return $user ? $user : false;
}

if ($_SERVER['REQUEST_METHOD'] != "POST") {
	// 投稿前

	// CSRF対策
	setToken();	
} else {
	// 投稿後
	checkToken();

	$email = $_POST['email'];
	$password = $_POST['password'];

	$dbh = connectDb();

	$error = array();

	// エラー処理
	// メールアドレスが登録されていない
	if (!emailExists($email, $dbh)) {
		$error['email'] = 'このメールアドレスは登録されていません';
	}

	// メールアドレスの形式が不正
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error['email'] = "メールアドレスの形式が正しくありません";
	}

	// メールアドレスが空
	if ($email == '') {
		$error['email'] = 'メールアドレスを入力してください';
	}

	// メールアドレスメールアドレスとパスワードが正しくない
	// この書き方でもOK → if (!$me = getUser($email, $password, $dbh)) {
	$me = getUser($email, $password, $dbh);
	if (!$me) {
		$error['password'] = 'パスワードとメールアドレスが正しくありません。';
	}

	// パスワードが空
	if ($password == '') {
		$error['password'] = 'パスワードを入力してください';
	}

	if (empty($error)) {
		// セッションハイジャック
		$_SESSION['me'] = $me;
		header('Location: '.SITE_URL.'/index.php');
		exit;
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>ログイン画面</title>
	</head>
	<body>
		<h1>ログイン</h1>
		<form action="" method="POST">
			<p>メールアドレス：<input type="text" name="email" value="<?php echo h($email); ?>"> <?php echo h($error['email']); ?></p>
			<p>パスワード：<input type="password" name="password" value=""> <?php echo h($error['password']); ?></p>
			<p><input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"></p>
			<p><input type="submit" value="ログイン！"> <a href="signup.php">新規登録はこちら！</a></p>
		</form>
	</body>
</html>