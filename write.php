<?php
	require_once("dbconfig.php");

	//$_GET['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}
	if(isset($bNo)) {
		$sql = "select * from $tbname where b_no = $bNo";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
	}
	
	$sql = "select * from tb_board where name = '$tbname'";
	$result = $db->query($sql);
	$tb_row = $result->fetch_assoc();
	$tbdesc = $tb_row[description];
	
	$sql = "SELECT * FROM tb_view WHERE b_tbname = '$tbname' AND b_fname != 'b_no' AND b_fname != 'b_hit' AND b_fname != 'b_date' AND b_fname != 'b_title'";
	$result = $db->query($sql);

	

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $tbdesc?> </title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<body>
	<article class="boardArticle">
		<h3><?php echo $tbdesc?> 글쓰기</h3>
		<div id="boardWrite">
			<form action="./write_update.php?tbname=<?php echo $tbname?>" enctype='multipart/form-data' method="post">
				<?php
				if(isset($bNo)) {
					echo '<input type="hidden" name="bno" value="' . $bNo . '">';
				}
				?>
				<table id="boardWrite">
					<caption class="readHide"><?php echo $tbdesc?> 글쓰기</caption>
					<tbody>
						<tr>
							<th scope="row"><label for="bID">아이디</label></th>
							<td class="id">
								<?php
								if(isset($bNo)) //$bNo가 있다는건 수정버튼을 눌렀을때 라는것
								{
									echo $row['b_id'];
								}
								else { ?>
									<input type="text" name="bID" id="bID">
								<?php } ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="bPassword">비밀번호</label></th>
							<td class="password"><input type="password" name="bPassword" id="bPassword"></td>
						</tr>
						<?php while ($view_row = $result->fetch_assoc())
	 							{$b_type = explode(",", $view_row['b_type']); 	 //콤마로 형식뒤에 있는 자료들을 잘라서 b_type변수에 [배열]로 저장한다. // count($b_type) 배열의 크기 구하기	
	 							$cnt = count($b_type);
								if($b_type[0] == 'TEXT')
								{?>
								<tr>
									<input type= "hidden" name= "b_fname" value="TEXT">
									<th 	scope="row"><?php echo $view_row['b_description']?></th> <!-- 새로 추가된 컬럼의 이름 -->
									<td class="title"><input type="text" name="<?=  $view_row['b_fname']?>">
							<?}?>
								<? if($b_type[0] == 'URL')
								{?>
								<tr>
									<th 	scope="row"><?php echo $view_row['b_description']?></th> <!-- 새로 추가된 컬럼의 이름 -->
									<td class="title"><input type="text" name="<?=  $view_row['b_fname']?>">
							<?}?>
								<? if($b_type[0] == 'EMAIL')
								{?>
								<tr>
									<th 	scope="row"><?php echo $view_row['b_description']?></th> <!-- 새로 추가된 컬럼의 이름 -->
									<td class="title"><input type="text" name="<?=  $view_row['b_fname']?>">
							<?}?>
								<? if($b_type[0] == 'PHONE')
								{?>
								<tr>
									<th 	scope="row"><?php echo $view_row['b_description']?></th> <!-- 새로 추가된 컬럼의 이름 -->
									<td><input type="text" maxlength="3" name="<?=  $view_row['b_fname'].'1'?>">
									<input type="text" maxlength="4" name="<?=  $view_row['b_fname'].'2'?>">
									<input type="text" maxlength="4" name="<?=  $view_row['b_fname'].'3'?>">
							<?}?>
								<? if($b_type[0] == 'CHECKBOX')
										{?><tr><th scope="row"><?php echo $view_row['b_description']?></th><td class="title"> <!-- 새로 추가된 컬럼의 이름 --><?
											for ($i=1;$i<$cnt;$i++)
											{?>
												
												<input type="checkbox" name="<?=  $view_row['b_fname'].$i?>" value="<?=$b_type[$i]?>"><?=$b_type[$i]?>
										<?}
										}?>
								<? if($b_type[0] == 'SELECT')
										{?>
										<tr>
											<th 	scope="row"><?php echo $view_row['b_description']?></th> <!-- 새로 추가된 컬럼의 이름 -->
											<td class="title"><select name ="<?= $view_row['b_fname']?>"><option value="<?=$view_row['b_description']?>"  selected="selected"><?=$view_row['b_description']?></option> <?
											for ($i=1;$i<$cnt;$i++)
											{?>
												<option value="<?=$b_type[$i]?>"><?=$b_type[$i]?></option>
										<?}
										}?></select>
								<? if($b_type[0] == 'RADIO')
										{?><tr><th scope="row"><?php echo $view_row['b_description']?></th><td class="id"> <?
											for ($i=1;$i<$cnt;$i++)
											{?>
												<!-- 새로 추가된 컬럼의 이름 -->
												<input type="radio" name="<?=  $view_row['b_fname']?>" value="<?=$b_type[$i]?>"><?=$b_type[$i]?>
										<?}
										}?>
								<? if($b_type[0] == 'ZIP')
								{?>
								<tr>
									<th 	scope="row"><?php echo $view_row['b_description']?></th> <!-- 새로 추가된 컬럼의 이름 -->
									<td><input type="text"  name="<?=  $view_row['b_fname'].'1'?>"></br>
									<input type="text"  name="<?=  $view_row['b_fname'].'2'?>">
							<?}?>
								<? if($b_type[0] == 'DATE')
								{?>
								<tr>
									<th 	scope="row"><?php echo $view_row['b_description']?></th> <!-- 새로 추가된 컬럼의 이름 -->
									<td><input type="text"  name="<?=  $view_row['b_fname']?>">
							<?}?>
								</br>
								<?= $view_row['b_destitle']?></td>
	 			<?php }?>
	 					</tr>
						<tr>
							<th scope="row"><label for="bTitle">제목</label></th>
							<td class="title"><input type="text" name="bTitle" id="bTitle" value="<?php echo isset($row['b_title'])?$row['b_title']:null?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="bContent">내용</label></th>
							<td class="content"><textarea name="bContent" id="bContent"><?php echo isset($row['b_content'])?$row['b_content']:null?></textarea></td>
						</tr>
						<? # 파일 업로드 시, 아래와 같이 name, id(꼭, "MAX_FILE_SIZE" 이여야 함) & value = 파일크기(즉, 1000 = 1KB) ?>
						<input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="10000000" />
						<tr>
							<th>첨부파일</th>
							<td>
							<input type='file' name='File' id='File' size='20'>
							<strong style='color:red; font-size:12px;'>★반드시 jpg, jpeg, png, gif 파일만 업로드 가능합니다.</strong><br />
							<?php
								# 'File'의 값이 true = 데이터 가져옴, 'File'의 값이 false = null
								echo isset($row['b_file'])?$row['b_file']:null
							?>
							<input type="hidden" name="b_file" value="<?php  echo isset($row['b_file'])?$row['b_file']:null?>" />
							<?php
								# $idx 값이 존재한다면,
								if(isset($bNo)){
									# 'File'가 빈값이 아니면,
									if($row['b_file'] != ""){
										# '★기존에 등록했던 파일 이름' 메시지 출력
										echo "<strong style='color:red; font-size:12px;'>★기존에 등록했던 파일 이름</strong>";
										?><br/>
										 <a href="#" onClick="location.href='delete_update.php?bNo=<?php echo $bNo?>&mode=update&tbname=<?php echo $tbname?>'">삭제</a>
										<?php
									}	
								}
							?>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="btnSet">
					<button type="submit" class="btnSubmit btn">
						<?php echo isset($bNo)?'수정':'작성'?>
					</button>
					<a href="./index.php?tbname=<?=$tbname?>" class="btnList btn">목록</a>
				</div>
			</form>
		</div>
	</article>
</body>
</html>