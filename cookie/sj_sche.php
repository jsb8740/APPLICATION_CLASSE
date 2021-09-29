<!doctype html>
<html>
<body>
<head>
<title> 과목 시간표 입력 </title>

<style>
table {
	margin:auto;
    width: 80%;
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
th {
	font-size : 18px;
	color : blue;
}
h3 {
	color : blue;
	text-align : center;
}

tr:nth-child(odd) {background-color: #f2f2f2;}
input[type=submit], input[type=reset] {
	font-size : 16px;
	font-weight:bold;
}
div {
	 position:relative;
	 left:75%;
	 top:15px;
}

</style>

</head>

<body>

<form method="post" action="sj_sche.php"> 
<table> 
<tr>
  <th colspan="5"> 과목 시간표 입력 </th>
</tr>

<tr> 
  <td> 과목코드 </td> 
  <td colspan="3"> <input type="text" name="sj_code"> </td>
</tr>

<tr> <td> 시간표 </td>
     <td> <input type="text" name="day1" size="3" > 
	 <select name="t1"> 
	   <option value="0"> </option>
       <option value="1"> 1 </option>
	   <option value="2"> 2 </option>
	   <option value="3"> 3 </option>
	   <option value="4"> 4 </option>
	   <option value="5"> 5 </option>
	   <option value="6"> 6 </option>
	   <option value="7"> 7 </option>
	   <option value="8"> 8 </option>
	   <option value="9"> 9 </option>
	 </td> 
	 <td> <input type="text" name="day2" size="3" > 
	 <select name="t2"> 
	   <option value="0"> </option>
       <option value="1"> 1 </option>
	   <option value="2"> 2 </option>
	   <option value="3"> 3 </option>
	   <option value="4"> 4 </option>
	   <option value="5"> 5 </option>
	   <option value="6"> 6 </option>
	   <option value="7"> 7 </option>
	   <option value="8"> 8 </option>
	   <option value="9"> 9 </option>
	   </td>  
	 <td> <input type="text" name="day3" size="3" > 
	 <select name="t3"> 
	   <option value="0"> </option>
       <option value="1"> 1 </option>
	   <option value="2"> 2 </option>
	   <option value="3"> 3 </option>
	   <option value="4"> 4 </option>
	   <option value="5"> 5 </option>
	   <option value="6"> 6 </option>
	   <option value="7"> 7 </option>
	   <option value="8"> 8 </option>
	   <option value="9"> 9 </option>
	 </td> 
	 <td> <input type="text" name="day4" size="3" > 
	 <select name="t4"> 
	   <option value="0"> </option>
       <option value="1"> 1 </option>
	   <option value="2"> 2 </option>
	   <option value="3"> 3 </option>
	   <option value="4"> 4 </option>
	   <option value="5"> 5 </option>
	   <option value="6"> 6 </option>
	   <option value="7"> 7 </option>
	   <option value="8"> 8 </option>
	   <option value="9"> 9 </option>
	 </td> 
</tr>

<tr>
  <td> 담당교수 </td> 
  <td colspan="3"> <select name="sj_prof"> 
       <option value="최조천"> 최조천 </option>
	   <option value="김건웅"> 김건웅 </option>
	   <option value="김치연"> 김치연 </option>
	   <option value="정종면"> 정종면 </option>
	   <option value="이미라"> 이미라 </option>
	   <option value="김동관"> 김동관 </option>
	   <option value="박철수"> 박철수 </option>
	   <option value="배미숙"> 배미숙 </option>
  </td>
</tr>

<tr> 
  <td colspan="5"> <input type="submit" value="저장" name="submit"> 
                   <input type="reset" value="다시쓰기" name="reset"> </td>
</tr>

</table>
<div> <a href='admin.php'> 관리자 페이지로.. </a> </div>
</form>
</body>
</html>

<?
	$dbc=mysqli_connect("localhost", "root", "", "proj20");
	
	if (isset($_POST['submit'])) {	//저장버튼 누르면
		$code=$_POST['sj_code'];
		$prof=$_POST['sj_prof'];
		
		$sche="";	//시간표
		
		$day1=trim($_POST['day1']);
		$day2=trim($_POST['day2']);
		$day3=trim($_POST['day3']);
		$day4=trim($_POST['day4']);
		
		if (empty($day1)) $day1="N";
		if (empty($day2)) $day2="N";
		if (empty($day3)) $day3="N";
		if (empty($day4)) $day4="N";
		
		$sc1=$day1.$_POST['t1'];
		$sc2=$day2.$_POST['t2'];
		$sc3=$day3.$_POST['t3'];
		$sc4=$day4.$_POST['t4'];
		
		$days=array($sc1, $sc2, $sc3, $sc4);//모든 시간표 배열에 저장
		
		$sche=implode($days, "/");	//분리자 넣어서 저장
		
		$sj_name="";
		
		$query="select sj_name from subjects where sj_code='$code'";
		$result=mysqli_query($dbc, $query);
		$row=mysqli_fetch_array($result);
		
		$sj_name=$row['sj_name'];
		
		$query="insert into sj_sche values('$code', '$sche', '$prof', '$sj_name', 10)";
		$result=mysqli_query($dbc, $query);
		
		//foreach($days as $v)
		//	echo "$v<br>";
		
		
	}
	mysqli_close($dbc);
?>﻿