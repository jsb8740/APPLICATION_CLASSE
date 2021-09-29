<?
	$dbc=mysqli_connect("localhost", "root", "", "proj20");	//디비연결
	
	$id=$_POST['loginID'];
	$pass=$_POST['loginPW'];
	
	$query="select id, pass, sname from students where id='$id' and pass='$pass'";
	$result=mysqli_query($dbc, $query);
	
	if (mysqli_num_rows($result) == 1) {
		$row=mysqli_fetch_array($result);
		$user_id = $row['id'];
		$user_pass = $row['pass'];
		$user_name = $row['sname'];
		echo $user_name."님 환영합니다...";
	}
	else {
		echo "id와 password를 정확하게 입력해주시기 바랍니다. ..    ";
		echo "<a href='index.html'>뒤로</a>";
	}
	
	mysqli_close($dbc);
?>