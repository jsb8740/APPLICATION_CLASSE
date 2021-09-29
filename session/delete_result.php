<?
	//20183346 정승백
	if (isset($_POST['d_submit'])) {
		$code=$_POST['delete']; // 삭제 버튼을 누른 과목 코드
		$dbc=mysqli_connect("localhost", "root", "", "proj20");

		$query="delete from subjects where sj_code='$code'"; // 해당 과목을 삭제할 질의
		$result=mysqli_query($dbc, $query);

		echo "과목이 삭제되었습니다... 3초 후에 관리자 페이지로 이동합니다... <br>";
		header('Refresh:3; url=http://localhost/proj/session/admin.php');

		mysqli_close($dbc);
	}
?>