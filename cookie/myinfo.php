<!doctype html>
<!--20183346 정승백 -->
<html>
<body>
<head>
<title> 개인정보 수정하기 </title>

<style>
table {
	margin:auto;
    width: 700px;
    border: 3px solid #73AD21;
    padding: 10px;
}
tr {
	height:50px;
}
td {	
	text-align : center;
	font-weight : bold;
	width : 200px;
}
th {
	font-size : 18px;
	color : blue;
}
h3 {
	color : blue;
	text-align : center;
}

tr:nth-child(odd) {background-color: #f2f2f2;}
input[type=submit], input[type=reset] {
	font-size : 16px;
	font-weight:bold;
}

form{
	position:relative;
	top:5px;
}
</style>

</head>

<body>
</body>
</html>

<?
	//20183346 정승백
	$dbc=mysqli_connect("localhost", "root", "", "proj20");
	//$id='20181111';
	
	if (isset($_COOKIE['uid']))
		$id=$_COOKIE['uid'];
	$query="select pass, sname, sgrade, tel from students where id='$id'";
	$result=mysqli_query($dbc, $query);
	
	$row=mysqli_fetch_array($result);
	$pass=$row['pass'];
//	echo "$pass";
	$sname=$row['sname'];
	$grade=$row['sgrade'];
	$tel=$row['tel'];
	
	echo "<div> <a href='logout.php'> 로그아웃 </a> </div>";
	
	echo "<h3> 개인 정보 수정하기</h3><br>";
	echo "<table><tr>";
	echo "<td>학년</td>";
	echo "<td><input type='text' name='id' value='$grade' size='2'></td>";	//name??
	echo "<td>학번</td>";
	echo "<td><input type='text' name='id' value='$id' size='8'></td>";	//name??
	echo "<td>이름</td>";
	echo "<td><input type='text' name='name' value='$sname' size='12'></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<form method='post' action='myinfo.php'>";
	echo "<table><tr>";
	echo "<td>현재 비밀번호</td>";
	echo "<td><input type='text' name='cur_pass' size='15'></td>";
	echo "<td>변경할 비밀번호</td>";
	echo "<td><input type='text' name='new_pass' size='15'></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>현재 전화번호</td>";
	echo "<td><input type='text' value='$tel' size='15'></td>";
	echo "<td>변경할 전화번호</td>";
	echo "<td><input type='text' name='new_tel' size='15'></td>";
	echo "</tr>";
	echo "<tr> <td colspan='4'> <input type='submit' name='submit' value='수정'> &nbsp;";
	echo "<input type='reset' name='reset' value='취소'>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
	
	$new_tel=""; $new_pass=""; $cur_pass="";
	if (isset($_POST['submit'])) {	//수정 버튼 눌러지면
		$cur_pass=SHA1($_POST['cur_pass']);	//현재 비밀번호 암호화
		if ($cur_pass == $pass)	{	//비밀번호가 같으면
			$new_pass=$_POST['new_pass'];
			$new_tel=$_POST['new_tel'];
			if (empty($new_pass))	//수정할 비번을 입력X
				$new_pass=$pass;	//기존의 것을 다시 저장
			else
				$new_pass=SHA1($_POST['new_pass']);
			
			
			if (empty($new_tel))	//수정할 전화번호를 입력X
				$new_tel=$tel;	//기존의 것을 다시 저장
			else
				$new_tel=$_POST['new_tel'];
			
			
			$query="update students set pass='$new_pass', tel='$new_tel' where id='$id'";
			$result=mysqli_query($dbc, $query);
		}
		else {	//비밀번호 다르면
			echo "비밀번호를 정확하게 입력해주시기 바랍니다...<br>";
		}
		
		/*if($result) 	//확인
			echo "ok";*/
			
	}
	mysqli_close($dbc);
	
?>