<?php
// set as system page
$system = true;

// set up error chacking data
$edate = new DateTime(date('Y-m-d H:i:s'));
$edate->modify("-1 hour");
$edate = $edate->format("Y-m-d H:i:s");
$eip = $_SERVER['REMOTE_ADDR'];

$select = "IPAdd";
$From = "tblelg";
$where = "(IPAdd = '$eip' AND date >= '$edate')";
$die = null;
$limit = null;

// search error database for count
$setting = SQL($select, $From, $die, $where, $limit, null, null);

// get count of records in error DB used for lockout
$errors = num_rows($setting);

// setup login failure pause
$FailedLoginDelay = (int)parameters('FailedLoginDelay');
// echo $FailedLoginDelay;
$wheresleep = "(date >= '$edate')";
$pause = SQL($select, $From, $die, $wheresleep, $limit, null, null);
$sleep = (int)num_rows($pause) * $FailedLoginDelay;
//echo $sleep;
flush();
sleep($sleep);

$LoginFails = (int)parameters('LoginFails');
$GlobalLoginFails = (int)parameters('GlobalLoginFails');

// check for login fails, and if there have been too many.
if (isset($_SESSION['fails'])){
	if ($_SESSION['fails'] >= $LoginFails || $errors >= $LoginFails || $sleep >= $GlobalLoginFails){
		echo 'Sorry too many failed log in attempts, please try again later';
		include("template/footer.php");
		die();
	}
}

// deal with errors.
function error($error){

	if (isset($_SESSION['fails'])){
		$_SESSION['fails'] = $_SESSION['fails'] + 1;
	}else{
		$_SESSION['fails'] = 1;
	}
	echo $error;

	$UNn = validate($_POST['Username'],'h');
	$password = encrypt(validate($_POST['password'],'h'));
	$err = $error;
	$Date = date("Y-m-d H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];
        
        // Add failured logins to error log database.
        $db = 'tblelg';
        $cols = 'uname, pword, err, Date, IPAdd';
        $values = "'$UNn','$password','$err','$Date','$ip'";
        $die = null;
        SQLI($db, $cols, $values, $die);

}

if (isset($_POST['Username'])) {

        if(!isset($llfail) && $referrer){
            global $namea;
            		$message = "Welcome <strong>" . $namea[0] . "</strong> ";
			$message .= "login Successful <br />";

                        //try to display the page user was on before loging in
                        
                        $query = $_POST['ref'];
                        
                        $div = explode("&",$query);
                        foreach($div as $var){
                        if(preg_match("/target=/",$var)){
$var = str_replace("target=","",$var);
$target = $var;
}
                        if(preg_match("/subsection=/",$var)){
$var = str_replace("subsection=","",$var);
$subsection = $var;
}
                        if(preg_match("/section=/",$var)){
$var = str_replace("section=","",$var);
$section = $var;
}
                        if(preg_match("/article=/",$var)){
$var = str_replace("article=","",$var);
$article = $var;
}
}
echo "</div>";
include("./template/content.php");

	} else {
            if (!$referrer){
                error('<font color=\"FF0000\">Login Failure: </font>');
            }else{
		error('<font color=\"FF0000\">Login Failure: incorrect username or password</font>');
            }
            $HTTP_REFERER =validate($_SERVER['HTTP_REFERER'],'hd');
$ref= explode("?",$HTTP_REFERER);
		?>
		<form method="post" action="?target=login">
                    <div id="loginbox">
        <input type="hidden" name="ref" value="<?php echo $ref[1]; ?>">
		<table class="loginbox">
		<tr>
                    <td>Username:</td><td> <input type="text" name="Username" /></td>
		</tr>
		<tr>
		<td>Password:</td><td> <input type="password" name="password" /></td>
		</tr>
		<tr>
		<td></td><td><input type="submit" name="Login" value="login" /></td>
		</tr>
		</table>
		</form>
		<p>
		Note:  Password is case sensitive
		</p>
                
<?php

// check if user is using SSL before login, should not be needed anymore, but left it.
if($_SERVER['HTTPS']!="on"){
if(parameters('SSL')){
    // instead of forcing SSL question the user. 
    echo '<p class="small">Concerened about security?  <a href="';
    
    // Old host did not allow ssl on main URL, they used a global certificate.  I suspect this is no longer a problem
    // but left parameter and if statment. 
    if (parameters('SSLURL')){
        echo parameters('SSLURL');
    }else{
        //echo 'https://';
        echo curPageURL(parameters('SSL'), 1);
    }

    echo '/?target=login">Switch to our secure site</a></p>';
}
}
?>
                <?php
                // Allow user Registration ??
                if(parameters('UserReg')){
                ?>
                <p class="small">Don't have a login <a href="?target=login&amp;section=register">register </a> now.</p>
<?php
                }
?>
                <p class="small"><a href="?target=login&amp;section=retrieve">Forgotten Username or Password</a></p>
</div>
 		<?php
 
	}
} else {
?>
<center>
<h2>Login</h2>
</center>

<?php

if (isset($_SESSION['user'])){
echo ' You are currently logged in and do not need to again ';
}else{
    if (isset($_SERVER['HTTP_REFERER'])){
                $HTTP_REFERER =validate($_SERVER['HTTP_REFERER'],'hd');
$ref= explode("?",$HTTP_REFERER);
    }else{
    $ref=null;
}
?>
                <div id="loginbox">
<form method="post" action="?target=login">

<input type="hidden" name="ref" value="<?php if (isset($ref[1])){ echo $ref[1];} ?>">
<table class="loginbox">
<tr>
<td>Username:</td><td><input type="text" name="Username" size="25" /></td>
</tr>
<tr>
<td>Password:</td><td><input type="password" name="password" size="25" /></td>
</tr>
<tr>
<td></td><td align="right"><input type="submit" name="Login" value="login" /></td>
</tr>
</table>
</form>
                <?php

if($_SERVER['HTTPS']!="on"){
if(parameters('SSL')){
    echo '<p class="small">Concerened about security?  <a href="';

    if (parameters('SSLURL')){
        echo parameters('SSLURL');
        echo $_SERVER["REQUEST_URI"];
    }else{
        echo curPageURL(parameters('SSL'), 1);
    }

    echo '">Switch to our secure site</a></p>';
}
}
?>

                <?php
                // Allow user Registration ??
                if(parameters('UserReg')){
                ?>
                <p class="small">Don't have a login <a href="?target=login&amp;section=register">register </a> now.</p>
<?php
                }
?>


<p class="small"><a href="?target=login&amp;section=retrieve">Forgotten Username or Password</a></p>

                </div>
<?php
}
}
?>
