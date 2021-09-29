<?
session_start();
	//20183346 정승백
	if (isset($_SESSION['uid'])) {
		$_SESSION=array();	//세션을 빈배열로 초기화함
		
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), "", time()-3600);
		}
		session_destroy();
		echo "안전하게 로그아웃 되었습니다. <br>";
	}
	echo "<a href='index.html'> 처음으로 </a>";


?>