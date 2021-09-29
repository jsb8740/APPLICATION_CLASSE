<?php
	//20183346 정승백

	$dbc=mysqli_connect("localhost", "root", "", "proj20");	//디비연결
	
	$id=$_POST['id'];
	$pass=$_POST['pass'];
	
	//아이디에 대해 쿠키생성
	
	if (!isset($_COOKIE['uid'])) {	//쿠키 설정이 되어 있지 않고
		if (isset($_POST['submit'])) {	//index.html에서 login 버튼이 눌러졌다면..
			if (($id == 'admin') and ($pass == '1111')) {	//관리자 로그인
				header("Location:http://localhost/proj/cookie/admin.php");	//자동으로 링크 넘어감
			}
			else {	//학생 로그인
				$query="select id, pass, sname from students where id='$id' and pass=SHA1('$pass')";
				$result=mysqli_query($dbc, $query);
		
				if (mysqli_num_rows($result) == 1) {	//성공 
					setcookie('uid', $id);	//id로 쿠키설정
				
					$row = mysqli_fetch_array($result);
					$user_id = $row['id'];
					$user_pass = $row['pass'];
					$user_name = $row['sname'];
					echo $user_name."님 환영합니다...";
			
					header ("Location:http://localhost/proj/cookie/register.php");	//수강신청 화면으로 넘어감
				}
				else {
					echo "id와 password를 정확하게 입력해주시기 바랍니다. ..  ";
					echo "<a href='index.html'>뒤로</a>";
				}
			}
		}
	}
	
	mysqli_close($dbc);
?>