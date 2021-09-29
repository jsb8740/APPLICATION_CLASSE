<?
	//20183346 정승백
	$dbc =mysqli_connect("localhost","root","","proj20");
   

   //$id="20183346";
   if(isset($_COOKIE['uid']))
      $id=$_COOKIE['uid'];
   
   $query ="select id, sname, sgrade from students where id='$id'";
   $result =mysqli_query($dbc, $query);
	echo "<div> <a href='myinfo.php'> 개인 정보 수정 </a> </div>"; // 개인 정보 수정하기
?>