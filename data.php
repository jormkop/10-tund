<?php
	require_once("functions.php");
	require_once("InterestsManager.class.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		exit();
	}
	
	if(isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
	}
	
	$add_new_response = $InterestsManager = new InterestsManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(isset($_GET["new_interest"])){
		
		$InterestsManager->addInterest($_GET["new_interest"]);
		
	}
 ?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<h2>lisa huviala</h2>
 
  <?php if(isset($add_new_response->error)): ?>
  
	<p style="color:red;">
		<?=$add_new_response->error->message;?>
	</p>
  
  <?php elseif(isset($add_new_response->success)): ?>
	
	<p style="color:green;" >
		<?=$add_new_response->success->message;?>
	</p>
	
  <?php endif; ?>
  
  <form>
  	<input name="new_interest" type="text" placeholder="Huviala"><br><br>
  	<input type="submit" name="lisa" value="lisa">
  </form>
  
  
  
  
  
  
  
<h2>Minu huvialad</h2> 
<form>
	<!--siia järele tuleb rippmenüü -->
	<?=$InterestsManager->createDropdown();?>
	<input type="submit">
</form>

