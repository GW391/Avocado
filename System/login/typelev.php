<?php

// process to check and add security groups to new users.
//TODO: ## 01 Does this even work?? // might be best just deleting.
if (isset($_SESSION['security'])){
            if(stripos($_SESSION['security'], 'SetTypes') !== false){

		require_once 'template/library/HTMLPurifier.auto.php';
                require_once 'template/functions.php';

                require_once 'template/config.php';
                require_once 'template/hotsprings_'.$DatabaseType.'.php';
                require_once 'template/SQL_'.$DatabaseType.'.php';

		$confirm = $_GET['confirm'];
                  
                // TODO: ## Security Array should come from parameters
		$Types = array("Editor","Member","Attendee","View");

		if (empty($_GET['Type']) || !in_array($_GET['Type'], $Types)) {
			exit("Sorry there has been an error in this page");
		}else{
                        // Get security level from link
			$key = array_search($_GET['Type'], $Types);
			$count = count($Types);
			$lvl = "";

                        // assign user with correct permissions, currently all permssions below the chosen are selected.                        
			while ($key <= $count){
				$lvl = $lvl . $Types[$key] . " ";
				$key++;
			}

                        $update = "tblpdu";
                        $set = "PSY  = '$lvl'";
                        $where = "UUID = '$confirm'";
                        $limit = null;
                        $die = 'Sorry there has been a problem please try again ';

                        $update_result = SQLU($update, $set, $where, $limit, $die);
                        
			echo "Membership level set";

                        $Select = "UUID, PEL";
                        $From = "tblpdu";
                        $Limit = 1;
                        $die = null;
                        $sort = "Date, Time";
                        $Where = "UUID = '$confirm'";
                        $GROUP = null;
        
                        $result = SQL($Select, $From, $die, $Where, $Limit, $GROUP, $sort);

		if ($shiftloaded){
		}else{
			require ("template/asc_shift.php");
		}


                // parameterise account approval email
		$row = fetch_array($result);
		$email = decrypt($row['PEL']);

		$subject = "Account Permissions Set";
    		$message = "Thank you for registering with the Woodstock Baptist church website, the site administrator has now set your permissions. \n\r";
    		mail($email, "$subject",
    		$message, "From: no_reply@woodstockbaptistchurch.org.uk " );

			sqlclose($con);

		}
	}else{
		echo "  Sorry you don't have the permission to set membership levels ";
	}
}else{
	echo "Please log before starting this page.<br />\n\r
Use the link <a href=\"?target=login\" target=\"_Child\">Login </a> <br />\n\r
this will open a new window, once logging in refresh this window before closing the new one. <br />\n\r
";
}

?>
