<?php
include('inc/header.php');

$login = Session::get('userLogin');
	if ($login == false) {
		header("Location:login.php");
		}
?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="section group">
				<div class="notfound">
					<h2><span>Order Page</span></h2>
				</div>
			</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

<?php
    include ('inc/footer.php');
?>