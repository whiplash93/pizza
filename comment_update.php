﻿<?php
	require_once('dbconfig.php');
	$w = '';
	$coNo = 'null';
	
	//2Depth & 수정 & 삭제
	if(isset($_POST['w'])) {
		$w = $_POST['w'];
		$coNo = $_POST['co_no'];
	}
	
	//공통 변수
	$bNo = $_POST['bno'];
	$coPassword = $_POST['coPassword'];
	if($w !== 'd') {//$w 변수가 d일 경우 $coContent와 $coId가 필요 없음.
		$coContent = $_POST['coContent'];
		if($w !== 'u') {//$w 변수가 u일 경우 $coId가 필요 없음.
			$coId = $_POST['coId'];
		}
	}
	
	if(empty($w) || $w === 'w') { //$w 변수가 비어있거나 w인 경우
		$msg = '작성';
		$sql = 'insert into tb_freecomment values(null, ' .$bNo . ', "' . $tbname . '" , ' . $coNo . ', "' . $coContent . '", "' . $coId . '", password("' . $coPassword . '"))';
		if(empty($w)) { //$w 변수가 비어있다면,
			$result = $db->query($sql);
			$coNo = $db->insert_id;
			$sql = "update tb_freecomment set co_order = co_no where co_no = $coNo";
			//4번째 컬럼인 co_order는 처음글쓸때 NULL 이라는 텍스트가 들어갔다가 방금 삽입된 코멘트의 번호로 바뀌게된다. 
			
		}
		
	} else if($w === 'u') { //작성
		$msg = '수정';
		
		$sql = "select count(*) as cnt from tb_freecomment where co_password=password($coPassword) and co_no = $coNo and b_name = '$tbname'";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		
		if(empty($row['cnt'])) { //맞는 결과가 없을 경우 종료
?>
			<script>
				alert('비밀번호가 맞지 않습니다.');
				history.back();
			</script>
<?php 
			exit;	
		}
		
		$sql = "update tb_freecomment set co_content = $coContent where co_password=password($coPassword) and co_no = $coNo and b_name = '$tbname'";
		
	} else if($w === 'd') { //삭제
		$msg = '삭제';
		$sql = "select count(*) as cnt from tb_freecomment where co_password=password($coPassword) and co_no = $coNo and b_name = '$tbname'";

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		
		if(empty($row['cnt'])) { //맞는 결과가 없을 경우 종료
?>
			<script>
				alert('비밀번호가 맞지 않습니다.');
				history.back();
			</script>
<?php 
			exit;	
		}
		$sql = "delete from tb_freecomment where co_password=password($coPassword) and co_no = $coNo and b_name = '$tbname'";

	} else {
?>
		<script>
			alert('정상적인 경로를 이용해주세요.');
			history.back();
		</script>
<?php 
		exit;
	}
	
	$result = $db->query($sql);
	if($result) {
?>
		<script>
			alert('댓글이 정상적으로 <?php echo $msg?>되었습니다.');
			location.replace("./view.php?tbname=<?php echo $tbname?>&bno=<?php echo $bNo?>");
		</script>
<?php
	} else {
?>
		<script>
			alert('댓글 <?php echo $msg?>에 실패했습니다.');
			history.back();
		</script>
<?php
		exit;
	}
	
?>
