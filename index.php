<?php
session_start();

// セッションにtodoリストがなければ空の配列を初期化
if (!isset($_SESSION['todos'])) {
	$_SESSION['todos'] = [];
}

// To-Doの追加処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['todo'])) {
	$todo = trim($_POST['todo']);
	if (!empty($todo)) {
		$_SESSION['todos'][] = $todo;
	}
}

// To-Doの削除処理
if (isset($_GET['delete'])) {
	$deleteIndex = (int)$_GET['delete'];
	if (isset($_SESSION['todos'][$deleteIndex])) {
		unset($_SESSION['todos'][$deleteIndex]);
		$_SESSION['todos'] = array_values($_SESSION['todos']); // 配列を再インデックス化
	}
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP To-Do List</title>
</head>

<body>
	<h1>To-Doリスト</h1>

	<!-- To-Do追加フォーム -->
	<form action="index.php" method="post">
		<input type="text" name="todo" placeholder="新しいTo-Doを追加">
		<button type="submit">追加</button>
	</form>

	<h2>To-Do一覧</h2>
	<ul>
		<?php foreach ($_SESSION['todos'] as $index => $todo): ?>
			<li>
				<?php echo htmlspecialchars($todo, ENT_QUOTES, 'UTF-8'); ?>
				<a href="index.php?delete=<?php echo $index; ?>" onclick="return confirm('このTo-Doを削除しますか？')">削除</a>
			</li>
		<?php endforeach; ?>
	</ul>
</body>

</html>