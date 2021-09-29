<?
	//20183346 정승백
	echo "<h3>This is a admin's page... </h3>";
	echo "과목 정보의 입력, 수정 및 삭제 ";
	echo "&nbsp; &nbsp; <a href='logout.php'> logout </a> <br><br><br>";
?>

<!doctype html>
<html>
<head> <title> Admin's Page</title>
<style>
input[type=submit], input[type=reset] {
	background-color: blue;
	border: none;
	color: yellow;
	padding: 16px 32px;
	text-decoration: none;
	margin: 4px 2px;
	cursor: pointer;
	font-size: 16px;
}
form, h3 {
	display: inline;
}
</style>
</head>
<body>

<form method="post" action="sj_insert.php">
	<input type="submit" value="과목 입력" name="insert">
</form>

<form method="post" action="sj_update.php">
	<input type="submit" value="과목 수정" name="update">
</form>

<form method="post" action="sj_delete.php">
	<input type="submit" value="과목 삭제" name="delete">
</form>

<form method="post" action="sj_sche.php">
	<input type="submit" value="시간표 입력" name="sche_insert">
</form>

</body>
</html>