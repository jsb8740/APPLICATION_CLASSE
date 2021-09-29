<?
	//20183346 정승백
	if (isset($_COOKIE['uid'])) {
		setcookie('uid', "", time()-3600);
		echo "안전하게 로그아웃 되었습니다. <br>";
	}
	echo "<a href='index.html'> 처음으로 </a>";


?>