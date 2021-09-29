<!doctype html>
<html>
<head>
<style>
input[type=text] {
  width: 100px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  background-color: white;
  /*background-image: url('searchicon.png'); */
  background-position: 10px 10px; 
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px;
  transition: width 0.4s ease-in-out;
}
input[type=submit], input[type=reset] {
	font-size : 16px;
	font-weight:bold;
}
input[type=text]:focus {
  width: 70%;
}
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
h3 {
	color : blue;
	text-align : center;
}
div {
	 margin:auto;
     width: 500px;
     border: 3px solid #73AD21;
     padding: 10px;
	 
}
tr:nth-child(odd) {background-color: #f2f2f2;}
span {
	 margin:auto;
	 top:5px;
     position:relative;
     left : 70%;	 
}

</style>
</head>
<body>
<h3> 과목 정보 삭제하기 </h3>
<?php
	//20183346 정승백
	if (!isset($_POST['submit'])) { // 검색 버튼이 눌러지기 전 : 검색 폼 출력
?>
<div>
<form method="post" action="sj_delete.php">
 <input type="text" name="subject">
 <input type="submit" name="submit" value="검색">
</form>
</div>
</body>
</html>
<?php
	} // if
	else { // 검색 버튼이 눌러졌다면
		$dbc=mysqli_connect("localhost", "root", "", "proj20");
		$sj_name=$_POST['subject']; // 삭제할 과목 이름 
// 검색어를 포함한 모든 과목 찾기
		$query="select * from subjects where sj_name like '%$sj_name%'"; // 과목 이름을 포함한 모든 과목 찾기
		$result=mysqli_query($dbc, $query);
		if ( mysqli_num_rows($result) == 0 ) { // 검색 결과가 없는 경우
			echo "검색어가 입력되지 않았거나, 존재하지 않는 과목입니다... 3초 후에 다시 돌아갑니다... <br>";
			header('Refresh:3; url=http://localhost/proj/cookie/sj_delete.php');
		}
		else { // 과목이 검색된 경우
			echo "<form method='post' action='delete_result.php'>";
			echo "<table>";
			while ($row=mysqli_fetch_array($result)) {
				echo "<tr> <td> 과목코드 </td> <td>".$row['sj_code']."</td>";
				echo "<td> 과목이름 </td> <td>".$row['sj_name']."</td>";
				echo "<td> 학년 </td> <td>".$row['sj_grade']."</td>";
				$code=$row['sj_code'];
				echo "<td> <input type='radio' name='delete' value='".$code."'> 선택 </td>";
				echo "</tr>";
			} // while
			echo "</table>";
			echo "<span> <input type='submit' name='d_submit' value='삭제'></span> &nbsp;";
			echo "<span> <input type='reset' name='reset' value='취소'> </span>";
			echo "</form>";
			mysqli_close($dbc);
		}
	}
?>