<?php

session_start();

require_once('config.php');
require_once('functions.php');


if ($_SERVER['REQUEST_METHOD'] != "POST") {
	// 投稿前

	// CSRF対策
	setToken();	
} else {
	// 投稿後
	checkToken();

	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$dbh = connectDb();

	$error = array();

	// エラー処理
	
	// 名前が空かどうかチェック
	if ($name == '') {
		$error['name'] = '名前を入力してください';
	}
	if (emailExists($email, $dbh)) {
		$error['email'] = 'このメールアドレスは既に登録されています。';
	}

	//メールアドレスが正しい記述かどうか 
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error['email'] = "メールアドレスの形式が正しくありません";
	}

	// メールアドレスが空かどうか
	if ($email == '') {
		$error['email'] = 'メールアドレスを入力してください';
	}
	
	// パスワードが空かどうか
	if ($password == '') {
		$error['password'] = 'パスワードを入力してください';
	}

	// 登録処理
	if (empty($error)) {
		$sql = "insert into users
				(name, email, password, created, modified)
				values
				(:name, :email, :password, now(), now())";
		$stmt = $dbh->prepare($sql);
		$params = array(
			":name" => $name,
			":email" => $email,
			":password" => getSha1Password($password)
		);
		$stmt->execute($params);
		header('Location: '.SITE_URL.'login.php');
		exit;
	}
}

?>


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>新規ユーザー登録</title>
	</head>
	<body>
		<h1>新規ユーザー登録</h1>
		<form action="" method="POST">
			<p>お名前：<input type="text" name="name" value="<?php echo h($name); ?>"> <?php echo h($error['name']); ?></p>
			<p>メールアドレス：<input type="text" name="email" value="<?php echo h($email); ?>"> <?php echo h($error['email']); ?></p>
			<p>パスワード：<input type="password" name="password" value=""> <?php echo h($error['password']); ?></p>
			<p><input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"></p>
			<p><input type="submit" value="新規登録！"> <a href="index.php">戻る</a></p>
		</form>
	</body>
</html>