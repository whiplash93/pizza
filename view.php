<?php
	require_once("pizza-master/pizza-master/dbconfig.php");
	$bNo = $_GET['bno'];
	$tbname = $_GET['tbname'];
	if(!empty($bNo) && empty($_COOKIE[$tbname.'_' . $bNo])) {
		$sql = "update ".$tbname." set b_hit = b_hit + 1 where b_no = ".$bNo;
		$result = $db->query($sql);
		if(empty($result)) {
			?>
			<script>
				alert('오류가 발생했습니다.');
				history.back();
			</script>
			<?php 
		} else {
			setcookie($tbname.'_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
		}
	}
	
	$sql = "select * from "."$tbname"." where b_no = ".$bNo; //해당 테이블에서 해당 넘버의 컬럼데이터를 select
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	$filename = $row['b_file'];
	$filedate = $row['b_filedate'];
	
	$sql = " select * from tb_board where name = '$tbname'";
	$result = $db->query($sql);
	$tbdesc = $result->fetch_assoc();
	$tbdesc = $tbdesc['description'];
	//테이블 이름과 테이블 설명을 가져오기 위한 쿼리
	
	$sql = " select * from tb_view where b_tbname = '$tbname' AND b_visible = '1'";
	$result = $db->query($sql);
	$tbdesc = $result->fetch_assoc();
	//tb_view 테이블에서 해당하는 테이블과 노출이 설정된 컬럼들만 select
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>dd</title>
	<link rel="stylesheet" href="pizza-master/pizza-master/css/normalize.css" />
	<link rel="stylesheet" href="pizza-master/pizza-master/css/board.css" />
	<script src="pizza-master/pizza-master/js/jquery-2.1.3.min.js"></script>
	<script>
	</script>
</head>
<body>
	<table width="720px">
    <tr>
    	<td>제목</td> 
        <td><?php echo $row['b_title']?></td> 
    </tr>
    <tr>
    	<td>작성자</td>
        <td><?php echo $row['b_id']?></td>
    </tr>
    <tr>
    	<td>작성일</td>
        <td><?php echo $row['b_date'] ?></td>
    </tr>
    <tr>
    	<td>조회수</td>
        <td><?php echo $row['b_hit']?></td>
    </tr>
    <tr>
    	<td>첨부파일</td>
        <td><?php ?></td>
    </tr>
    <tr>
    	<td>내용</td>
        <td><?php ?></td>
    </tr>
</table>
	<article class="boardArticle">
		<h3><?php echo $tbdesc?></h3>
		<div id="boardView">
			<h3 id="boardTitle"><?php echo $row['b_title']?></h3>
			<div id="boardInfo">
				<span id="boardID">작성자: <?php echo $row['b_id']?></span>
				<span id="boardDate">작성일: <?php echo $row['b_date']?></span>
				<span id="boardHit">조회: <?php echo $row['b_hit']?></span>
			</div>
			<div id = "component">
			<span ><?= $row['b']?></span>
			<span >asd</span>
			</div>
			<div id="boardContent"><?php echo $row['b_content']?></div>
			<div id="boardFile">첨부된 파일 :
			<a href="pizza-master/pizza-master/down_Load.php?tbname=<?php echo $tbname?>&fileName=<?php echo $filedate?>&num=<?php echo $bNo ?>"><?php echo $filename ?>
				<?php 
 				if($filename != null)
 					echo $filename;
 	 	 		    else echo "</a> 첨부된 파일 없음";
				?></a>
			</div>
			<div class="btnSet">
				<a href="pizza-master/pizza-master/write.php?tbname=<?php echo $tbname?>&bno=<?php echo $bNo?>">수정</a>
				<a href="pizza-master/pizza-master/delete.php?tbname=<?php echo $tbname?>&bno=<?php echo $bNo?>&filedate=<?php echo $filedate?>">삭제</a>
				<a href="pizza-master/pizza-master/index.php?tbname=<?php echo $tbname?>">목록</a>
			</div>
		<div id="boardComment">
			<?php require_once("pizza-master/pizza-master/comment.php")?>
		</div>
		</div>
	</article>
</body>
</html>