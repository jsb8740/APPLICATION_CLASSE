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
div {
 margin:auto;
 width: 500px;
 border: 3px solid #73AD21;
 padding: 10px;
 }
h3 {
color : blue;
text-align : center;
}
tr:nth-child(odd) {background-color: #f2f2f2;}
span {
 margin:auto;
 position:relative;
 left : 80%; }
</style>
</head>
<?php
 if (!isset($_POST['sub_search'])) { // 수정 내용 작성 전,
?>
<body>
<h3> 과목 정보 수정하기 </h3>
<div>
 <form method="post" action="sj_modify.php">
 <input type="text" class="srch" name="search">
 <input type="submit" name="sub_search" value="코드찾기">
 </form>
</body>
</html>
<?php
} // end of if
else { // 찾기 버튼이 눌러졌다면
	$dbc=mysqli_connect("localhost", "root", "", "proj20");

	if (!empty($_POST['search'])) { // 찾기 버튼을 누르지 않았을 때 검색 창 출력
		echo "<h3> 과목 정보 수정하기 </h3>";
		$code=$_POST['search'];
		
		$query="select sj_code, sj_name, sj_limit, sj_credit, sj_num_class, sj_grade, sj_cate from subjects where sj_code='$code'";
 // subjects 테이블로부터 검색한 과목의 과목 코드, 이름, 수강인원, 학점, 강의시수, 학년, 이수구분 가져오기
		$result=mysqli_query($dbc, $query);

			if ( mysqli_num_rows($result) == 0 ) { // 입력된 과목 코드로 검색되지 않았을 때
				echo "존재하지 않는 과목 코드입니다... 3초후에 다시 돌아갑니다...<br>";
				header('Refresh:3; url=http://localhost/proj/cookie/sj_modify.php');
			}
			else {
			$row=mysqli_fetch_array($result);
	
			echo "<form method='post' action='modify_result.php'>";
			echo "<table>";

			echo "<tr> <th colspan='2'> 현재 과목 정보 </th> <th> 수정 정보 </th> </tr>";
			echo "<tr> <td> 과목코드 </td>";
			echo "<td>".$row['sj_code']."</td>";
			echo "<td> <input type='text' name='ucode'> </td></tr>";
			$send_code=$row['sj_code'];

			echo "<tr> <td> 과목이름 </td>";
			echo "<td>".$row['sj_name']."</td>";
			echo "<td> <input type='text' name='uname'> </td></tr>";

			echo "<tr> <td> 수강인원 </td>";
			echo "<td>".$row['sj_limit']."</td>";
			echo "<td> <input type='text' name='ulimit'> </td></tr>";

			echo "<tr><td> 학점수 </td>";
			echo "<td>".$row['sj_credit']."</td>";
			echo "<td> <input type='text' name='ucredit'> </td></tr>";
 
			echo "<tr><td> 강의시수 </td>";
			echo "<td>".$row['sj_num_class']."</td>";
			echo "<td> <input type='text' name='uclass'> </td></tr>";

			echo "<tr><td> 대상학년 </td>";
			echo "<td>".$row['sj_grade']."</td>";
			echo "<td> <input type='text' name='ugrade'> </td></tr>";

			echo "<tr><td> 이수구분 </td>";
			echo "<td>".$row['sj_cate']."</td>";
			echo "<td> <input type='text' name='ucate'> </td></tr>";

			echo "<tr> <td colspan=3'> <input type='submit' name='usubmit' value='수정'> &nbsp;";
			echo "<input type='reset' name='ureset' value='취소'></td> </tr>";
			echo "<input type='hidden' name='sj_code' value='$send_code' >";
			echo "</table>";
			echo "</form>";
			echo "<span> <a href='admin.php'> 관리자 페이지로.. </a> </span> <br> ";
		}
	}
	else {
		echo "코드가 입력되지 않았습니다... 3초 후에 다시 돌아갑니다.. <br> ";
		header('Refresh:3; url=http://localhost/proj/cookie/sj_modify.php');
	} // else
}
?>