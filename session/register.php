<?
session_start();	//20183346 정승백
	
	$dbc =mysqli_connect("localhost","root","","proj20");
	
	if(isset($_SESSION['uid']))	//세션이 있다면
		$id=$_SESSION['uid'];
	//echo "$id";
	$code="";	#초기값
	
	$query ="select id, sname, sgrade from students where id='$id'";
	$result =mysqli_query($dbc, $query);
	
	$row=mysqli_fetch_array($result);
	$id=$row['id'];
	$sname=$row['sname'];
	$sgrade=$row['sgrade'];	#로그인한 학생정보
	
	echo "<h3> 수강 신청 - 과목 추가 및 삭제 </h3> <br><br>";
	
	echo "<span> <a href='myinfo.php'> 개인 정보 수정 </a> </span> &nbsp; &nbsp;";
	echo "<span> <a href='logout.php'> 로그아웃 </a> </span> <br>";
	
	echo "<table> <tr>";
	echo "<td> 학년 </td>";
	
	echo "<td> <input type='text' name='kd' value='$sgrade' size='5'> </td>";
	echo "<td> 학번 </td>";
	echo "<td> <input type='text' name='id' value='$id' size='15'></td>";
	echo "<td> 이름 </td>";
	echo "<td> <input type='text' name='name' value='$sname' size='20'</td>";
	echo "</tr>";
	echo "</table>";
	
	$tot_grade=0;	//수강 신청 총 학점수, 21 못넘김...
	echo "<br>";
	echo "<h3> 신청한 과목 </h3><br>";
	
	echo "<form method='post' action='reg_result.php'>";
	echo "<table>";
	echo "<tr>";
	echo "<th> 과목이름 </th> <th size='9'> 학점수 </th> <th> 강의시수 </th>";
	echo "<th> 시간표 </th> <th> 대상학년 </th> <th> 이수구분 </th> <th> 신청학생수 </th> <th> 선택 </th> </tr>";
	
	//이미 신청한 과목이 저장된 stud_subj 테이블로부터, 조인을 통해 과목 정보 가져오기
	$query2="select ss.sj_code, sj_name, sj_credit, sj_grade, sj_cate, sj_limit, sj_num_class from subjects as sj, stud_subj as ss where ss.sid='$id' and ss.sj_code=sj.sj_code and sj_sem=2";
	$result2=mysqli_query($dbc, $query2);	# 필수 과목 검색
	/*if (!$result2) {
		printf("Error: %s\n", mysqli_error($dbc));
		exit();
	}*/
	
	while($row2=mysqli_fetch_array($result2)) {	#신청한 과목 정보 출력
		echo "<tr>";
		echo "<td> <input type='text' value=".$row2['sj_name']." size='20'> </td>";
		echo "<td> <input type='text' value=".$row2['sj_credit']." size='5'> </td>";
		echo "<td> <input type='text' value=".$row2['sj_num_class']." size='5'> </td>";
		
		#시간표 가져오기
		$code=$row2['sj_code'];
		
		$query3="select sj_time from sj_sche where sj_code='$code'";
		$result3=mysqli_query($dbc, $query3);
		$row3=mysqli_fetch_array($result3);
		$str=$row3[0];
		
		/*if (!$row3) {	에러가 있는 확인
			printf("Error: %s\n", mysqli_error($dbc));	
			exit();
		}*/
		
		$class=$row2['sj_num_class'];
		if ($class==3) {	//시수가 3이면
			$str=substr($str, 0, 14);	//N부분 빼고 추출
		}
		
		echo "<td> <input type='text' value='$str'> </td>";
		echo "<td> <input type='text' value=".$row2['sj_grade']." size='5'> </td>";
		echo "<td> <input type='text' value=".$row2['sj_cate']." size='8'> </td>";
		
		#수강신청한 학생 수
		$sql="select stud_count from sj_sche where sj_code='$code'";
		$rlt=mysqli_query($dbc, $sql);
		$temp=mysqli_fetch_array($rlt);
		echo "<td>".$temp[0]."/".$row2['sj_limit']."</td>";
		
		# 선택 과목만 활성화되는 라이도 버튼
//		if ($row2['sj_cate'] == '필수') {
//			echo "<td> <input type='radio' name='delete' value='".$row2['sj_code']."' disabled> 선택 </td>";
//		}
	//	else {
			echo "<td> <input type='radio' name='delete' value='".$row2['sj_code']."'> 선택 </td>";
//		}
		
		$tot_grade+=intval($row2['sj_credit']); //학점 누적
		echo "</tr>";
	}
	
	echo "<tr> <td colspan='6'> </td>";
	echo "<td colspan='2'> <input type='submit' name='sub_delete' value='삭제'> &nbsp; <input type='reset' name='reset' value='취소'> </td> </tr>";
	echo "<tr> <td allgn='center' colspan='9'> <b>총 학점수 : ".$tot_grade."</b> </td></tr>";
	echo "<input type='hidden' name='sj_code' value='".$code."'>";
	echo "</table>";
	echo "</form>";
	echo "<span> <a href='tm_tbl.php'> <input type='button' value='시간표보기'> </a> </span> ";
	
	
	#	선택 과목 출력 루틴	#
	# 로그인한 학년보다 같거나 낮은 학년의 모든 선택과목을 골라서 출력
	
	# 해당 학년의 선택과목과 낮은 학년의 선택 과목 출력하기
	$g=intval($sgrade);	//3학년이면...
	echo "<br><h3> 선택 가능 과목 </h3><br>";
	//echo "$g";	값 제대로 넘어오는지 확인
	
	echo "<form method='post' action='register.php'>";
	echo "<div><select name='grade' style='height:25px;'>
    <option value='none'>--학년 선택--</option>
	<option value='1'>1</option>
    <option value='2'>2</option>
    <option value='3'>3</option>
    <option value='4'>4</option></select> <input type='submit' name='g_submit' value='확인'></div>";
	echo "</form>";
	
	if (isset($_POST['g_submit'])) #확인 누르면 select 값 가져옴
		$grade=$_POST['grade'];
	$grade=intval($grade);
	//echo "$grade";
	
	
	echo "<form method='post' action='reg_result.php'>";
	echo "<table>";
	echo "<tr>";
	echo "<th> 과목이름 </th> <th size='9'> 학점수 </th> <th> 강의시수 </th>";
	echo "<th> 시간표 </th> <th> 대상학년</th> <th> 이수구분 </th> <th> 신청학생수 </th> <th> 선택 </th> </tr>";
	
	#추가하는 과목 처리 출력
	//while ($g>=1) {	//3>=1
		$query="select sj_code, sj_name, sj_credit, sj_num_class, sj_limit, sj_grade, sj_cate from subjects where sj_grade=$grade and sj_sem=2"; //and sj_cate='선택'
		$result=mysqli_query($dbc, $query);	#선택 과목 검색
		
		while ($row=mysqli_fetch_array($result)) {	#모든 선택 과목 출력
		
			$code=$row['sj_code'];
			
			#sid와 내 학번이 같고 sj_code와 이미수강신청한 과목의 코드가 같으면...
			$query5="select * from stud_subj where sid='$id' and sj_code='$code'";
			$result5=mysqli_query($dbc, $query5);
			$row5=mysqli_fetch_array($result5);
			if ($row5) {	#결과값이 있으면 컨티뉴해라.. 추가한 과목들은 더이상 보이지 않음.
				continue;
			}
			
			echo "<tr>";
			echo "<td> <input type='text' value=".$row['sj_name']." size='20'> </td>";
			echo "<td> <input type='text' value=".$row['sj_credit']." size='5'> </td>";
			echo "<td> <input type='text' value=".$row['sj_num_class']." size='5'> </td>";
			
			#시간표 가져오기
			//$code=$row['sj_code'];
			
			$query4="select sj_time from sj_sche where sj_code='$code'";
			$result4=mysqli_query($dbc, $query4);
			$row4=mysqli_fetch_array($result4);
			/*if (!$row4) {
				printf("Error: %s\n", mysqli_error($dbc));
				exit();
			}*/
			$str=$row4[0];
			
			$class=$row['sj_num_class'];
			if ($class==3) {	//시수가 3이면
				$str=substr($str, 0, 14);	//N부분 빼고 추출
			}
		
			echo "<td> <input type='text' value='$str'> </td>";	#시간표 출력
			echo "<td> <input type='text' value=".$row['sj_grade']." size='5'> </td>";
			echo "<td> <input type='text' value=".$row['sj_cate']." size='8'> </td>";
			
			
			#수강신청한 학생 수
			$sql="select stud_count from sj_sche where sj_code='$code'";
			$rlt=mysqli_query($dbc, $sql);
			$temp=mysqli_fetch_array($rlt);
			
			echo "<td>".$temp[0]."/".$row['sj_limit']."</td>";
			
			echo "<td> <input type='radio' name='insert' value='".$row['sj_code']."'> 추가 </td>";
			$code=$row['sj_code'];
			echo "</tr>";
		}	#선택 과목 수만큼 출력
		
		//$g--;	#학년 감수 3학년 -> 2학년
	//}
	
	echo "<tr> <td colspan='6'> </td>";
	echo "<td colspan='2'> <input type='submit' name='sub_insert' value='추가'> &nbsp;";
	echo "<input type='reset' name='reset' value='취소'> </td> </tr>";
	echo "<input type='hidden' name='sj_code' value='".$code."'>";
	echo "</table>";
	echo "</form>";
	mysqli_close($dbc);
?>
<!doctype html>
<html> 
<head>
<style>
h3 {
	margin:auto;
	color:blue;
	width:80%;
	text-align:center;
}
table {
	margin:auto;
	width:80%;
	border : 3px solid gray;
	padding:4px;
}
span {
	position:relative;
	left:80%;
	bottom:10px;
}
input[type=submit], input[type=reset] {
	font-size : 16px;
	font-weight:bold;
}
.reg {
	top : 20px;
	position:relative;
	left:80%;
}
b {
	color:red;
}
td {
	text-align:center;
}
div {
	position:relative;
	left:74%;
	bottom:10px;
}
</style>
</head>

<body>

</body>
</html>