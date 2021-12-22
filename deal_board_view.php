<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>중고거래 플랫폼</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<script>
  function check_input() {
      if (!document.comment_form.comment.value)
      {
          alert("댓글을 작성하세요!");
          document.comment_form.comment.focus();
          return;
      }
      document.comment_form.submit();
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section>

	
	<div id="main_img_bar">
        <img src="./img/main_img.png">
    </div>
   	<div id="board_box">
	    <h3 class="title">
			거래게시판 > 내용보기
		</h3>
<?php
	$num  = $_GET["num"];
	$page  = $_GET["page"];

	$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from dealboard where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$id      = $row["id"];
	$name      = $row["name"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];
	$productname = $row["productname"];
	$realprice = $row["realprice"];
	$sellprice = $row["sellprice"];
	$status = $row["status"];
	$file_name    = $row["file_name"];
	$file_type    = $row["file_type"];
	$file_copied  = $row["file_copied"];
	$hit          = $row["hit"];
	
	$discountrate = round(100 - ($sellprice / $realprice * 100));

	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);

	$new_hit = $hit + 1;
	$sql = "update dealboard set hit=$new_hit where num=$num";   
	mysqli_query($con, $sql);
?>		
	    <ul id="view_content">
			<li >
				<span class="col1"><b>제목 :</b> <?=$subject?></span>
				<span class="col2"><?=$name?> | <?=$regist_day?></span>
			</li>
			<li style="padding:15px 15px 15px 15px;">
				<span><b>상품명 :</b> <?=$productname?></span><br/>
				<span><b>정가 :</b> <?=$realprice?></span><br/>
				<span><b>판매가 :</b> <?=$sellprice?></span><br/>
				<span><b>할인율 :</b> <?=$discountrate?>%</span>
			</li>
			<li style="padding:15px 15px 15px 15px; border-bottom: solid 1px #cccccc;">
			<?php
					if($file_name) {
						$real_name = $file_copied;
						$file_path = "./data/".$real_name;
						$file_size = filesize($file_path);

						echo "▷ 이미지 파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
			           	}
						   else{
							   $file_path = "./data/noImage.png";
						   }
				?>
				<div><img class="colImage" src="<?=$file_path?>"></div>
				<div><?=$content?></div>
				<?php
					if($userid != $id && $status == "sale"){
				?>
				<div>
					<button style="padding:5px 20px;margin:5px;" type="button" onclick="location.href='buy_product.php?num=<?=$num?>&page=<?=$page?>'">구매하기</button>
					<button style="padding:5px 20px;margin:5px;" type="button" onclick="location.href='message_form.php?id=<?=$id?>&num=<?=$num?>&page=<?=$page?>'">쪽지보내기</button>
				</div>
				<?php
					}
					elseif($status != "sale"){
				?>
				<div>
					<button style="padding:5px 20px;margin:5px;" type="button">판매완료</button>
				<?php					
					}elseif($userid != $id){
				?>
					<button style="padding:5px 20px;margin:5px;" type="button" onclick="location.href='message_form.php?id=<?=$id?>&num=<?=$num?>&page=<?=$page?>'">쪽지보내기</button>
				<?php
					}
				?>
				</div>
			</li>
			
			
			
			
			
	    </ul>
		
		
		<ul style="margin-top:10px;margin-bottom:10px;" id="comment_content">
			<div style="margin-bottom:10px;">
				<span>댓글목록</span>
			</div>
			<form name="comment_form" method="post" action="deal_comment_insert.php" enctype="multipart/form-data">
				<input type="hidden" name="num" value="<?=$num?>">
				<input type="hidden" name="page" value="<?=$page?>">
				<li>
					<textarea name="comment" cols="80" rows="5"></textarea>
				</li>
				<li style="text-align:left;">
					<button type="button" onclick="check_input()">댓글 작성</button>
				</li>
			</form>
			<li>
				<?php
					if (isset($_GET["page"]))
					$page = $_GET["page"];
				else
					$page = 1;
			
				$con = mysqli_connect("localhost", "user1", "12345", "sample");
				$sql = "select * from dealcomment where boardnum = '$num' order by num desc";
				$result = mysqli_query($con, $sql);
				$total_record = mysqli_num_rows($result); // 전체 글 수
			
				$scale = 50;
			
				// 전체 페이지 수($total_page) 계산 
				if ($total_record % $scale == 0)     
					$total_page = floor($total_record/$scale);      
				else
					$total_page = floor($total_record/$scale) + 1; 
			
				// 표시할 페이지($page)에 따라 $start 계산  
				$start = ($page - 1) * $scale;      
			
				$number = $total_record - $start;

				for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
					{
						mysqli_data_seek($result, $i);
						// 가져올 레코드로 위치(포인터) 이동
						$row = mysqli_fetch_array($result);
						// 하나의 레코드 가져오기
						$commentnum         = $row["num"];
						$boardnum    = $row["boardnum"];
						$commentid          = $row["id"];
						$commentname        = $row["name"];
						$comment     = $row["content"];
						$commentregist_day  = $row["regist_day"];
						
					?>
									
									<li style="width:600px;border-top:solid 1px; border-bottom:solid 1px;margin-top:5px;" class="oneBoard">
										<ul style="padding:3px;">
											<b><li class="col2"><?=$comment?></li></b>
											<li class="col3">작성자 : <?=$commentname?></li>
											<li class="col5">작성일시 : <?=$commentregist_day?></li>
										</ul>
									</li>	
									
					<?php
						$number--;
					}
					mysqli_close($con);

					?>
			</li>
		</ul>
		<hr>
	    <ul class="buttons">
				<li><button onclick="location.href='deal_board_list.php?page=<?=$page?>'">목록</button></li>

				<?php
					if($userid == $id){
				?>
				<li><button onclick="location.href='deal_board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<li><button onclick="location.href='deal_board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
				<?php
					}
				?>
				<li><button onclick="location.href='deal_board_form.php'">글쓰기</button></li>
		</ul>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
