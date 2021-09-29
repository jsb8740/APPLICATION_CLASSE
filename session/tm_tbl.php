<!doctype html>

<html>
<head>
	<style>
		td {height:50px;}
		input[type=text] {
			height:50px;
			width: 185px;
		}
	</style>
</head>

<body>
<h2> 2020학년도 2학기 시간표 </h2>

<a href='register.php'> 돌아가기 </a>
<table>
<tr>
	<th> 구분 </th> <th> 월 </th> <th> 화 </th> <th> 수 </th> <th> 목 </th> <th> 금 </th>
</tr>

<tr>
	<td> 1 </td>
	<td> <input type='text' name='m1' id='m1'> </td>
	<td> <input type='text' name='t1' id='t1'> </td>
	<td> <input type='text' name='w1' id='w1'> </td>
	<td> <input type='text' name='th1' id='th1'> </td>
	<td> <input type='text' name='f1' id='f1'> </td>
</tr>

<tr>
	<td> 2 </td>
	<td> <input type='text' name='m2' id='m2'> </td>
	<td> <input type='text' name='t2' id='t2'> </td>
	<td> <input type='text' name='w2' id='w2'> </td>
	<td> <input type='text' name='th2' id='th2'> </td>
	<td> <input type='text' name='f2' id='f2'> </td>
</tr>

<tr>
	<td> 3 </td>
	<td> <input type='text' name='m3' id='m3'> </td>
	<td> <input type='text' name='t3' id='t3'> </td>
	<td> <input type='text' name='w3' id='w3'> </td>
	<td> <input type='text' name='th3' id='th3'> </td>
	<td> <input type='text' name='f3' id='f3'> </td>
</tr>

<tr>
	<td> 4 </td>
	<td> <input type='text' name='m4' id='m4'> </td>
	<td> <input type='text' name='t4' id='t4'> </td>
	<td> <input type='text' name='w4' id='w4'> </td>
	<td> <input type='text' name='th4' id='th4'> </td>
	<td> <input type='text' name='f4' id='f4'> </td>
</tr>

<tr>
	<td> 5 </td>
	<td> <input type='text' name='m5' id='m5'> </td>
	<td> <input type='text' name='t5' id='t5'> </td>
	<td> <input type='text' name='w5' id='w5'> </td>
	<td> <input type='text' name='th5' id='th5'> </td>
	<td> <input type='text' name='f5' id='f5'> </td>
</tr>

<tr>
	<td> 6 </td>
	<td> <input type='text' name='m6' id='m6'> </td>
	<td> <input type='text' name='t6' id='t6'> </td>
	<td> <input type='text' name='w6' id='w6'> </td>
	<td> <input type='text' name='th6' id='th6'> </td>
	<td> <input type='text' name='f6' id='f6'> </td>
</tr>

<tr>
	<td> 7 </td>
	<td> <input type='text' name='m7' id='m7'> </td>
	<td> <input type='text' name='t7' id='t7'> </td>
	<td> <input type='text' name='w7' id='w7'> </td>
	<td> <input type='text' name='th7' id='th7'> </td>
	<td> <input type='text' name='f7' id='f7'> </td>
</tr>

<tr>
	<td> 8 </td>
	<td> <input type='text' name='m8' id='m8'> </td>
	<td> <input type='text' name='t8' id='t8'> </td>
	<td> <input type='text' name='w8' id='w8'> </td>
	<td> <input type='text' name='th8' id='th8'> </td>
	<td> <input type='text' name='f8' id='f8'> </td>
</tr>

<tr>
	<td> 9 </td>
	<td> <input type='text' name='m9' id='m9'> </td>
	<td> <input type='text' name='t9' id='t9'> </td>
	<td> <input type='text' name='w9' id='w9'> </td>
	<td> <input type='text' name='th9' id='th9'> </td>
	<td> <input type='text' name='f9' id='f9'> </td>
</tr>
</body>
</html>

<?
session_start();	//20183346 정승백

	$dbc =mysqli_connect("localhost","root","","proj20");
	
	if(isset($_SESSION['uid']))	//세션이 있다면
		$id=$_SESSION['uid'];
		
	#쿼리
	$query="select sj_code from stud_subj where sid='$id'";
	$result=mysqli_query($dbc, $query);	# 수강신청한 과목 검색
	
	while ($row=mysqli_fetch_array($result)) {
		$sj_code=$row['sj_code'];	//sj_code
		//echo $sj_code."<br>";
		
		$query1="select sj_time, sj_name, rm_num from sj_sche where sj_code='$sj_code'";
		$result1=mysqli_query($dbc, $query1);
		$row1=mysqli_fetch_array($result1);
		
		$sj_name=$row1['sj_name'];
		//echo $sj_name."<br>";
		$sj_time=$row1['sj_time'];
		//echo $sj_time."<br>";
		$rm_num=$row1['rm_num'];
		//echo $rm_num."<br>";
		
		$query2="select sj_num_class from subjects where sj_code='$sj_code'";
		$result2=mysqli_query($dbc, $query2);
		$row2=mysqli_fetch_array($result2);
		$class=$row2['sj_num_class'];	//수업시수
		
		$k=0;	//substr 제어변수
		for ($j=0; $j<$class; $j++) {	//$class 수업 시수만큼 반복문 반복함
			$day=substr($sj_time, $k, 3);
			$time=substr($sj_time, $k+3, 1);
			$seperator1=substr($sj_time, $k+4, 1);

			$day_time=$day.$time;
			//echo $day_time."<br>";
	
			$room_num=substr($rm_num, $k, 4);
			$seperator2=substr($rm_num, $k+4, 1);
			//echo $room_num.$seperator2."<br>";
				
			$k=$k+5;	
				
			#시간표 입력 부분
			echo "<script language='javascript'>";
			echo "var day='$day_time';";
			echo "var subj='$sj_name';";
			echo "var room_num=$room_num;";
		
			echo "if (day=='월1') document.getElementById('m1').value=subj+'  '+room_num;";
			echo "if (day=='월2') document.getElementById('m2').value=subj+'  '+room_num;";
			echo "if (day=='월3') document.getElementById('m3').value=subj+'  '+room_num;";
			echo "if (day=='월4') document.getElementById('m4').value=subj+'  '+room_num;";
			echo "if (day=='월5') document.getElementById('m5').value=subj+'  '+room_num;";
			echo "if (day=='월6') document.getElementById('m6').value=subj+'  '+room_num;";
			echo "if (day=='월7') document.getElementById('m7').value=subj+'  '+room_num;";
			echo "if (day=='월8') document.getElementById('m8').value=subj+'  '+room_num;";
			echo "if (day=='월9') document.getElementById('m9').value=subj+'  '+room_num;";
		
			echo "if (day=='화1') document.getElementById('t1').value=subj+'  '+room_num;";
			echo "if (day=='화2') document.getElementById('t2').value=subj+'  '+room_num;";
			echo "if (day=='화3') document.getElementById('t3').value=subj+'  '+room_num;";
			echo "if (day=='화4') document.getElementById('t4').value=subj+'  '+room_num;";
			echo "if (day=='화5') document.getElementById('t5').value=subj+'  '+room_num;";
			echo "if (day=='화6') document.getElementById('t6').value=subj+'  '+room_num;";
			echo "if (day=='화7') document.getElementById('t7').value=subj+'  '+room_num;";
			echo "if (day=='화8') document.getElementById('t8').value=subj+'  '+room_num;";
			echo "if (day=='화9') document.getElementById('t9').value=subj+'  '+room_num;";
				
			echo "if (day=='수1') document.getElementById('w1').value=subj+'  '+room_num;";
			echo "if (day=='수2') document.getElementById('w2').value=subj+'  '+room_num;";
			echo "if (day=='수3') document.getElementById('w3').value=subj+'  '+room_num;";
			echo "if (day=='수4') document.getElementById('w4').value=subj+'  '+room_num;";
			echo "if (day=='수5') document.getElementById('w5').value=subj+'  '+room_num;";
			echo "if (day=='수6') document.getElementById('w6').value=subj+'  '+room_num;";
			echo "if (day=='수7') document.getElementById('w7').value=subj+'  '+room_num;";
			echo "if (day=='수8') document.getElementById('w8').value=subj+'  '+room_num;";
			echo "if (day=='수9') document.getElementById('w9').value=subj+'  '+room_num;";
			
			echo "if (day=='목1') document.getElementById('th1').value=subj+'  '+room_num;";
			echo "if (day=='목2') document.getElementById('th2').value=subj+'  '+room_num;";
			echo "if (day=='목3') document.getElementById('th3').value=subj+'  '+room_num;";
			echo "if (day=='목4') document.getElementById('th4').value=subj+'  '+room_num;";
			echo "if (day=='목5') document.getElementById('th5').value=subj+'  '+room_num;";
			echo "if (day=='목6') document.getElementById('th6').value=subj+'  '+room_num;";
			echo "if (day=='목7') document.getElementById('th7').value=subj+'  '+room_num;";
			echo "if (day=='목8') document.getElementById('th8').value=subj+'  '+room_num;";
			echo "if (day=='목9') document.getElementById('th9').value=subj+'  '+room_num;";
			
			echo "if (day=='금1') document.getElementById('f1').value=subj+'  '+room_num;";
			echo "if (day=='금2') document.getElementById('f2').value=subj+'  '+room_num;";
			echo "if (day=='금3') document.getElementById('f3').value=subj+'  '+room_num;";
			echo "if (day=='금4') document.getElementById('f4').value=subj+'  '+room_num;";
			echo "if (day=='금5') document.getElementById('f5').value=subj+'  '+room_num;";
			echo "if (day=='금6') document.getElementById('f6').value=subj+'  '+room_num;";
			echo "if (day=='금7') document.getElementById('f7').value=subj+'  '+room_num;";
			echo "if (day=='금8') document.getElementById('f8').value=subj+'  '+room_num;";
			echo "if (day=='금9') document.getElementById('f9').value=subj+'  '+room_num;";
			
			echo "</script>";
		}		
	}
	
	/*$sj_arr=array('컴퓨터네트워크', '소프트웨어공학', '데이터베이스응용및설계');
	$sche_arr=array('월1/월2/수2', '화1/화2/목2', '수3/수4/금2');
	$room_arr=array('7507/7507/7505', '7505/7505/7507', '7301/7301/7301');*/
	
	/*for ($i=0; $i<3; $i++) {	#과목수
		$sj_name=$sj_arr[$i];
		//echo $sj_arr[$i];
		$k=0;	//substr 제어변수
		for ($j=0; $j<3; $j++) {
			$day=substr($sche_arr[$i], $k, 3);
			$time=substr($sche_arr[$i], $k+3, 1);
			$seperator1=substr($sche_arr[$i], $k+4, 1);
			
			$day_time=$day.$time;
			//echo $day_time."<br>";
			
			$room_num=substr($room_arr[$i], $k, 4);
			$seperator2=substr($room_arr[$i], $k+4, 1);
			//echo $room_num.$seperator2."<br>";
			
			$k=$k+5;
			
			echo "<script language='javascript'>";
			echo "var day='$day_time';";
			echo "var subj='$sj_name';";
			echo "var room_num=$room_num;";
			
			echo "if (day=='월1') document.getElementById('m1').value=subj+'  '+room_num;";
			echo "if (day=='월2') document.getElementById('m2').value=subj+'  '+room_num;";
			echo "if (day=='월3') document.getElementById('m3').value=subj+'  '+room_num;";
			echo "if (day=='월4') document.getElementById('m4').value=subj+'  '+room_num;";
			echo "if (day=='월5') document.getElementById('m5').value=subj+'  '+room_num;";
			echo "if (day=='월6') document.getElementById('m6').value=subj+'  '+room_num;";
			echo "if (day=='월7') document.getElementById('m7').value=subj+'  '+room_num;";
			echo "if (day=='월8') document.getElementById('m8').value=subj+'  '+room_num;";
			echo "if (day=='월9') document.getElementById('m9').value=subj+'  '+room_num;";
			
			echo "if (day=='화1') document.getElementById('t1').value=subj+'  '+room_num;";
			echo "if (day=='화2') document.getElementById('t2').value=subj+'  '+room_num;";
			echo "if (day=='화3') document.getElementById('t3').value=subj+'  '+room_num;";
			echo "if (day=='화4') document.getElementById('t4').value=subj+'  '+room_num;";
			echo "if (day=='화5') document.getElementById('t5').value=subj+'  '+room_num;";
			echo "if (day=='화6') document.getElementById('t6').value=subj+'  '+room_num;";
			echo "if (day=='화7') document.getElementById('t7').value=subj+'  '+room_num;";
			echo "if (day=='화8') document.getElementById('t8').value=subj+'  '+room_num;";
			echo "if (day=='화9') document.getElementById('t9').value=subj+'  '+room_num;";
			
			echo "if (day=='수1') document.getElementById('w1').value=subj+'  '+room_num;";
			echo "if (day=='수2') document.getElementById('w2').value=subj+'  '+room_num;";
			echo "if (day=='수3') document.getElementById('w3').value=subj+'  '+room_num;";
			echo "if (day=='수4') document.getElementById('w4').value=subj+'  '+room_num;";
			echo "if (day=='수5') document.getElementById('w5').value=subj+'  '+room_num;";
			echo "if (day=='수6') document.getElementById('w6').value=subj+'  '+room_num;";
			echo "if (day=='수7') document.getElementById('w7').value=subj+'  '+room_num;";
			echo "if (day=='수8') document.getElementById('w8').value=subj+'  '+room_num;";
			echo "if (day=='수9') document.getElementById('w9').value=subj+'  '+room_num;";
			
			echo "if (day=='목1') document.getElementById('th1').value=subj+'  '+room_num;";
			echo "if (day=='목2') document.getElementById('th2').value=subj+'  '+room_num;";
			echo "if (day=='목3') document.getElementById('th3').value=subj+'  '+room_num;";
			echo "if (day=='목4') document.getElementById('th4').value=subj+'  '+room_num;";
			echo "if (day=='목5') document.getElementById('th5').value=subj+'  '+room_num;";
			echo "if (day=='목6') document.getElementById('th6').value=subj+'  '+room_num;";
			echo "if (day=='목7') document.getElementById('th7').value=subj+'  '+room_num;";
			echo "if (day=='목8') document.getElementById('th8').value=subj+'  '+room_num;";
			echo "if (day=='목9') document.getElementById('th9').value=subj+'  '+room_num;";
			
			echo "if (day=='금1') document.getElementById('f1').value=subj+'  '+room_num;";
			echo "if (day=='금2') document.getElementById('f2').value=subj+'  '+room_num;";
			echo "if (day=='금3') document.getElementById('f3').value=subj+'  '+room_num;";
			echo "if (day=='금4') document.getElementById('f4').value=subj+'  '+room_num;";
			echo "if (day=='금5') document.getElementById('f5').value=subj+'  '+room_num;";
			echo "if (day=='금6') document.getElementById('f6').value=subj+'  '+room_num;";
			echo "if (day=='금7') document.getElementById('f7').value=subj+'  '+room_num;";
			echo "if (day=='금8') document.getElementById('f8').value=subj+'  '+room_num;";
			echo "if (day=='금9') document.getElementById('f9').value=subj+'  '+room_num;";
			
			echo "</script>";
		}
			
	}*/
	mysqli_close($dbc);
?>