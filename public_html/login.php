<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
	$username = "";
	if (isset($_POST["submit"])) {
		//validations
		$required_fields = array("username", "password");
		validate_presences($required_fields);
		
		if(empty($errors)) {
			// Attempt login
			
			$username = $_POST["username"];
			$password = $_POST["password"];
			$found_admin = attempt_login($username, $password);
			
			// Test if there was a query error 
			if ($found_admin) {
			  // Success
			  // Mark user as logged in. 
			  $_SESSION["admin_id"] = $found_admin["id"];
			  $_SESSION["username"] = $found_admin["username"];
			  redirect_to("admin.php");
			} else {
			  // Failure
			  $_SESSION["message"] = "Username/password not found.";
			}
		}
	}else {
		// this is probably a get request 
		
	}
?>
<?php $layout_context = "admin" ?>
<?php include("../includes/layouts/cms_header.php"); ?>
<div id="main">
  <div id="navigation">
  </div>
  <div id="page">
    <?php echo message(); ?>
	<?php echo form_errors($errors); ?>
	
	<h2>Login </h2>

	<?php 
		echo "<form action=\"login.php\"";
		echo "method=\"post\">";
	?>	
	 <p>Username:
	    <input	type="text" name="username" value="<?php 
			echo htmlentities($username);
		?>" />
	 </p>
	 <p>Password:
	    <input	type="password" name="password" value=""/>
	 </p>

      <input type="submit" name="submit" value="Submit" />
    </form>
    <br />
	&nbsp;
	&nbsp;

  </div>
</div>

<?php include("../includes/layouts/cms_footer.php"); ?>
