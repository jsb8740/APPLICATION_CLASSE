<?php
	//20183346 정승백
	$dbc=mysqli_connect("localhost", "root", "", "proj20");
	
	if (isset($_POST['usubmit'])) {
		$code=$_POST['sj_code']; // hidden으로 받은 수정할 과목의 코드
		
		
		/*echo "$ucode <br>";
		echo "$uname <br>";
		echo "$ulimit <br>";
		echo "$ucredit <br>";
		echo "$uclass <br>";
		echo "$ugrade <br>";
		echo "$ucate<br>";*/
		// echo $code."<br>";
		if(!empty($_POST['ucode'])) { // 코드 수정
			$ucode=$_POST['ucode'];
			$query1="update subjects set sj_code='$ucode' where sj_code='$code'"; // 코드를 수정할 질의 (폼에서 넘어온 값으로)
			$result1=mysqli_query($dbc, $query1);
			
		}
		if(!empty($_POST['uname'])) { // 이름 수정
			$uname=$_POST['uname'];
			$query2="update subjects set sj_name='$uname' where sj_code='$code'"; // 이름을 수정할 질의
			$result2=mysqli_query($dbc, $query2);
		}
		if(!empty($_POST['ulimit'])) { // 수강 인원 수정
			$ulimit=$_POST['ulimit'];
			$query3="update subjects set sj_limit='$ulimit' where sj_code='$code'"; // 수강 인원을 수정할 질의
			$result3=mysqli_query($dbc, $query3);
		}
		if(!empty($_POST['ucredit'])) { // 학점수 수정
			$ucredit=$_POST['ucredit'];
			$query4="update subjects set sj_credit='$ucredit' where sj_code='$code'"; // 학점 수를 수정할 질의 
			$result4=mysqli_query($dbc, $query4);
		}
		if(!empty($_POST['uclass'])) { // 강의시수 수정
			$uclass=$_POST['uclass'];
			$query5="update subjects set sj_num_class='$uclass' where sj_code='$code'"; // 강의 시수를 수정할 질의
			$result5=mysqli_query($dbc, $query5);
		}
		if(!empty($_POST['ugrade'])) { // 대상 학년 수정
			$ugrade=$_POST['ugrade'];
			$query6="update subjects set sj_grade=$ugrade where sj_code='$code'"; // 대상 학년을 수정할 질의
			$result6=mysqli_query($dbc, $query6);
		}
		if(!empty($_POST['ucate'])) { // 이수 구분 수정
			$ucate=$_POST['ucate'];
			$query7="update subjects set sj_cate='$ucate' where sj_code='$code'"; // 이수 구분
			$result7=mysqli_query($dbc, $query7);
		}
		echo "정상적으로 수정되었습니다... 3초 후에 관리자 화면으로 이동합니다... <br>";
		header('Refresh:3; url=http://localhost/proj/cookie/admin.php');
	} // usubmit가 눌러진 경우
?>