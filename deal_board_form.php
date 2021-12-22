<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>중고거래 플랫폼</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<script>
  function check_input() {
      if (!document.board_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.board_form.subject.focus();
          return;
      }
	  if (!document.board_form.productname.value)
      {
          alert("상품명을 입력하세요!");
          document.board_form.productname.focus();
          return;
      }
	  if (!document.board_form.sellprice.value)
      {
          alert("판매가를 입력하세요!");
          document.board_form.sellprice.focus();
          return;
      }
	  if (!document.board_form.sellprice.value)
      {
          
          document.board_form.sellprice.value = 0;
          
      }
      if (!document.board_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.board_form.content.focus();
          return;
      }
      document.board_form.submit();
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
	    <h3 id="board_title">
	    		거래게시판 > 글 쓰기
		</h3>
	    <form  name="board_form" method="post" action="deal_board_insert.php" enctype="multipart/form-data">
	    	 <ul id="board_form">
				<li>
					<span class="col1">이름 : </span>
					<span class="col2"><?=$username?></span>
				</li>		
	    		<li>
	    			<span class="col1">제목 : </span>
	    			<span class="col2"><input name="subject" type="text"></span>
	    		</li>
				<li>
	    			<span class="col1">상품명 : </span>
	    			<span class="col2"><input name="productname" type="text"></span>
	    		</li>	    	
				<li>
	    			<span class="col1">정가 : </span>
	    			<span class="col2"><input name="realprice" type="number"></span>
	    		</li>	    	
				<li>
	    			<span class="col1">판매가 : </span>
	    			<span class="col2"><input name="sellprice" type="number"></span>
	    		</li>	    		    	
	    		<li id="text_area">	
	    			<span class="col1">내용 : </span>
	    			<span class="col2">
	    				<textarea name="content"></textarea>
	    			</span>
	    		</li>
	    		<li>
			        <span class="col1"> 상품 이미지 첨부</span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">완료</button></li>
				<li><button type="button" onclick="location.href='deal_board_list.php'">목록</button></li>
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
