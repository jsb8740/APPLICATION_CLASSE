<?
session_start();	//20183346 정승백

if (isset($_SESSION['uid'])) {
	$id=$_SESSION['uid'];
}

$dbc=mysqli_connect("localhost", "root", "", "proj20");
$err_msg="";


#	신청한 과목들을 삭제하는 경우		#
if(isset($_POST['sub_delete'])) {
	#취소 버튼을 누른 과목을 읽어와서
	# stud_subj에서 삭제
	# stud_count 감소
	
	$code=$_POST['delete'];	#삭제할 과목의 코드를 받아서
	
	$query2="select stud_count from sj_sche where sj_code='$code'";	#현재 신청 인원 읽어오기
	$result2=mysqli_query($dbc, $query2);
	$row2=mysqli_fetch_array($result2);
	
	$dcnt=intval($row2[0]);
	$dcnt--;	#취소를 위해 신청 인원 감소
	
	$query3="update sj_sche set stud_count='$dcnt' where sj_code='$code'";
	$result3=mysqli_query($dbc, $query3);
	
	$query="delete from stud_subj where sid='$id' and sj_code='$code'";
	$result=mysqli_query($dbc, $query);
	
	header("Location:http://localhost/proj/session/register.php");
}




#	새로운 선택 과목을 추가하는 경우
#	12학점을 넘지 않으며, 시간표 중복이 없고, 인원 제한에 걸리지 않는다면 신청 가능
# 	alter table sj_sche add column stu_count int;
#	필수 과목은 default로 증가하게
if (isset($_POST['sub_insert'])) {
	
	$code=$_POST['insert'];	#추가할 과목의 코드
	//echo "$code";
	
	#자기 학번으로 자신의 학년을 가져오는 쿼리문
	$query9="select sgrade from students where id='$id'";
	$result9=mysqli_query($dbc, $query9);
	$row9=mysqli_fetch_array($result9);
	
	$grade=$row9['sgrade'];	//현재 수강 신청한 학생의 학년
	
	#추가할 과목의 코드로 추가할 과목의 학년을 알아내는 쿼리문
	$query10="select sj_grade from subjects where sj_code='$code'";
	$result10=mysqli_query($dbc, $query10);
	$row10=mysqli_fetch_array($result10);
	
	$sj_grade=$row10['sj_grade'];	//수강 신청할 과목의 학년
	
	
	#신청한 과목의 학년이 학생의 학년보다 높으면
	#이걸 안하면 stud_subj에 학번은 있는데 과목번호가 없는 테이블이 생김
	if ($code=="" or $grade < $sj_grade) {	//register.php에서 라디오버튼을 체크안하고 추가했을경우와 신청한 과목의 학년이 학생의 학년보다 높으면
		if ($code=="")
			echo "라디오 버튼을 누르고 추가해주세요<br>";
		else
			echo "자신의 학년보다 높은 학년의 과목을 신청할 수 없습니다.<br>";
			
		echo "3초 후에 이전 화면으로 이동합니다...";
		
		#header()를 사용할 경우에 출력이 이상해진다..
		#그래서 javascript를 사용해서 3초뒤에 다시 열리게 했다.
		echo "<script>	
				function move() {
					location.replace('http://localhost/proj/session/register.php');
				}
				setTimeout(move, 3000);	
			</script>";	//3초 뒤에 다시 register.php가 열림
		return;
	}
	
	$tot_grade=0;		#신청한 과목의 학점 수 계산
	$count_flag=0;		#수강 인원 확인
	$grade_flag=0;		#학점 확인
	$rep_flag=0;		#시간표 중복 확인
	$max_grade_cnt=12;	#총 수강신청할 수 있는 학점은 12학점
	$max_class_cnt=20;	#수강 인원 제한은 20명
	
	$sch_arr=array(array());	#시간표를 저장할 배열, 2차워, 5(월~금) by 9(1~9교시)
	for ($i=0; $i<=5; $i++) {
		for ($j=0; $j<=9; $j++) {
			$sch_arr[$i][$j]=0;
		}
	}	#배열 초기화 0행 0열 사용안함 월 1교시는 [1][1]
	
	
	#	신청한 과목에 대한 시간표 중복 확인				#
	#	이미 신청된 과목들의 시간표 배열 만들어 검사하기	#
	$query0="select sj_time from stud_subj as ss, sj_sche as sc where sid='$id' and ss.sj_code=sc.sj_code";
	$result0=mysqli_query($dbc, $query0);
	
	while ($row=mysqli_fetch_array($result0)) {
		$each=explode('/', $row['sj_time']);	#문자열을 쪼개서
		
		$day=array();	#요일을 저장하는 배열
		$t_day=array();	#교시를 저장하는 배열
		$i=0;			##매 시간을 접근하는 첨자
		foreach($each as $v) {	#월1/화1/화2/NO
			$day[$i]=substr($v, 0, 3);	#화	
			$t_day=substr($v, 3, 1);	#3
			$a=$day[$i];
			
			switch($day[$i]) {
				case "월": $j=1; break;	#월요일은 1
				case "화": $j=2; break;	#월요일은 1
				case "수": $j=3; break;	#월요일은 1
				case "목": $j=4; break;	#월요일은 1
				case "금": $j=5; break;	#월요일은 1
				default: $j=0;
			}
			
			if ($j!=0) {
				$k=intval($t_day);	#교시를 숫자로
				if ($sch_arr[$j][$k]==0) {	#시간표 중복
					$sch_arr[$j][$k]=1;	#수업이 있다
				}
			}
			$i++;
		} 
	}
	
	# 추가할 과목으로 인한 시간표 중복 확인
	$query="select sj_time from sj_sche where sj_code='$code'";
	$result=mysqli_query($dbc, $query);
	
	$row=mysqli_fetch_array($result);
	$each=explode('/', $row['sj_time']);	#문자열을 쪼갬
	
	# 화3 substr("화3",0 ,3) 화, substr('화3', 3, 1)
	$day=array();	#요일을 저장하는 배열
	$t_day=array();	#교시를 저장하는 배열
	$i=0;	#매 시간을 접근하는 첨자
	foreach($each as $v) {
		$day[$i]=substr($v, 0, 3);	#화
		$t_day=substr($v, 3, 1);	#3
		
		switch($day[$i]) {
			case "월": $j=1; break;
			case "화": $j=2; break;
			case "수": $j=3; break;
			case "목": $j=4; break;
			case "금": $j=5; break;
			default: $j=0;
		}
		if ($j!=0) {
			$k=intval($t_day);	#교시를 숫자로
			if($sch_arr[$j][$k]==0) {#시간표 중복이 아니면
				$sch_arr[$j][$k]=1;
			}
			else {#시간표 중복
				$rep_flag=1;
				$err_msg.="시간표가 중복되었습니다... <br>";
				break;
			}
		}
		$i++;
	}
	
	
	#학점이 초과되는지 확인
	$query2="select sj.sj_credit from stud_subj as ss, subjects as sj where sid='$id' and ss.sj_code=sj.sj_code";
	$result2=mysqli_query($dbc, $query2);
	
	while ($row2=mysqli_fetch_array($result2)) {	#신청한 과목들에 대해 학점 계산
		$tot_grade+=intval($row2[0]);
	}
	
	#추가할 과목이 12학점을 넘지 않는지 확인
	
	$query3="select sj_credit from subjects where sj_code='$code'";
	$result3=mysqli_query($dbc, $query3);
	$row3=mysqli_fetch_array($result3);
	
	if ($tot_grade + intval($row3[0]) > $max_grade_cnt) {	#12학점 제한
		$err_msg.="12 학점을 초과하였습니다. <br>";
		$grade_flag=1;	#추가실패
	}
	
	#인원 제한 확인
	$query4="select sj_limit from subjects where sj_code='$code'";	#추가할 과목의 제한인원 확인
	$result4=mysqli_query($dbc, $query4);
	$row4=mysqli_fetch_array($result4);
	
	$query5="select stud_count from sj_sche where sj_code='$code'";	#현재 신청인원
	$result5=mysqli_query($dbc, $query5);
	$row5=mysqli_fetch_array($result5);
	//echo "$row5[0]";
	if (intval($row5[0]) >= $max_class_cnt) {
		$err_msg.="수강 인원을 초과하였습니다. <br>";
		$count_flag=1;	#추가 실패
	}
	
	#모든 조건이 맞을 때, 추가가 가능하다면
	if (($grade_flag==0) and ($count_flag==0) and ($rep_flag==0)) {	#추가할 수 있으므로 데이터베이스에 저장
		$query6="select stud_count from sj_sche where sj_code='$code'";
		$result6=mysqli_query($dbc, $query6);
		$row6=mysqli_fetch_array($result6);
		
		$cnt=intval($row6[0]);
		$cnt++;
		
		$query7="update sj_sche set stud_count='$cnt' where sj_code='$code'";	#해당 과목의 인원수 증가
		$result7=mysqli_query($dbc, $query7);
		
		$query8="insert into stud_subj values ('$id', '$code')";	#과목 추가
		$result8=mysqli_query($dbc, $query8);
		
		echo "과목 추가에 성공하였습니다.";
	}
	else {
		echo $err_msg."<br>";
	}
	
	echo "3초 후에 이전 화면으로 이동합니다...";
	header('Refresh:3; url=http://localhost/proj/session/register.php');
}
?>