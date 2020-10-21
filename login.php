<?php
include ('inc/header.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
      $userLogin = $cmr->userLogin($_POST);
		}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
      $customreRegi = $cmr->customerRegistration($_POST);
		}

	$login = Session::get('userLogin');
	if ($login == true) {
		header("Location:order.php");
		}
?>

 <div class="main">
    <div class="content">
    	 <div class="login_panel">
    	 	<?php
	    		if (isset($userLogin)) {
	    			echo "$userLogin";
	    		}
    		?>
        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        	<form action="" method="post">
            	<input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <div class="buttons"><div><button class="grey" name="login">Sign In</button></div></div>
             </form>
             <p class="note">If you forgot your passoword just enter your email and click <a href="#">here</a></p>
         </div>

    	<div class="register_account">
    		<?php
	    		if (isset($customreRegi)) {
	    			echo "$customreRegi";
	    		}
    		?>
    		<h3>Register New Account</h3>
			<form action="" method="post">
					<table>
							<tbody>
						<tr>
						<td>
							<div>
								<input type="text" name="name" placeholder="Name">
							</div>
							
							<div>
							   <input type="text" name="city" placeholder="City">
							</div>
							
							<div>
								<input type="text" name="zipcode" placeholder="Zip-Code">
							</div>
							<div>
								<input type="text" name="email" placeholder="Email">
							</div>
						 </td>
						<td>
						<div>
							<input type="text" name="address" placeholder="Address">
						</div>

			    		<div>
							<input type="text" name="country" placeholder="Country">
					 	</div>		        

			           <div>
			          		<input type="text" name="phone" placeholder="Phone">
			          </div>
				  
					  <div>
						<input type="text" name="password" placeholder="Password">
					</div>
				</td>
			</tr> 
			</tbody></table> 
			<div class="search"><div><button class="grey" name="register">Create Account</button></div></div>
			<p class="terms">By clicking 'Create Account' you agree to the <a href="#">Terms &amp; Conditions</a>.</p>
			<div class="clear"></div>
			</form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

<?php
include ('inc/footer.php');
?>

