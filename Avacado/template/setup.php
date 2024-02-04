<?php

/* 
 * Copyright (C) 2020 Gregor
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

?>

<?php

$filename = 'template/config.php';
$backupFile = 'template/config' . Date('dmYHis') . '.php';

if (file_exists($filename)) {
    echo "You have already configured, you can not do this again.";
} else {


if (isset($_POST['DatabaseType'])){

    $Salt = generateRandomString(20);
    $DataKey = generateRandomString(55);
    $PostKey = generateRandomString(33);
    $sqltypes = ['MySQLi', 'MySQL'];
        
    if (in_array($_POST['DatabaseType'], $sqltypes, true)){
        require 'template/SQL_'.$_POST['DatabaseType'].'.php';
    }else{
        // no Database type specified, assume MySQLi
        require 'template/SQL_MySQLi.php';
    }
    
    require_once 'template/vars.php';
    $config = "
        <?php
    $" . "DatabaseType = \"" . validate($_POST['DatabaseType'],'hd') . "\";
    $" . "DatabaseName = \"" . validate($_POST['DatabaseName'],'hd') . "\";
    $" . "DatabaseServerName = \"" . validate($_POST['DatabaseServerName'],'hd') . "\";";
            if (isset($_POST['DatabaseServerPort']) & strlen($_POST['DatabaseServerPort']) !=0){
    $config .= "$" . "DatabaseServerPort = \"" . validate($_POST['DatabaseServerPort'],'hd') . "\";";
        }
    $config .= "$" . "DatabaseUserName = \"" . validate($_POST['DatabaseUserName'],'hd') . "\";
    $" . "DatabasePassword = \"" . validate($_POST['DatabasePassword'],'hd') . "\";
    $" . "DataKey = \"" . $DataKey . "\";
    $" . "PostKey = \"" . $PostKey . "\";
    $" . "Salt = \"" . $Salt . "\";
?>    
";
    file_put_contents($filename, $config);
    file_put_contents($backupFile, $config);

$DataBaseName = validate($_POST['DatabaseName'],'hd');
$DatabaseAdminName = validate($_POST['DatabaseAdminUserName'],'hd');
$DatabaseAdminPassword = validate($_POST['DatabaseAdminPassword'],'hd');

require 'template/config.php';
require 'template/CreateDB.php';

require_once 'template/hotsprings_'.$DatabaseType.'.php';
require_once 'template/SQL_'.$DatabaseType.'.php';
require_once 'template/errorlog.php';
require_once 'template/asc_shift.php';



$RName = "Administrator";
    
echo $_POST['Email'];
echo strtolower($_POST['Email']);
echo encrypt(validate(strtolower($_POST['Email']), 'enc')) . '<br />';

$credentials = getUNPW(validate($_POST['NUsername'],'h'), validate($_POST['Npassword'],'h'),1000512);

/*$UNn = hash('sha256',strtolower($_POST['NUsername']));
	$password = str_split($_POST['Npassword'],(strlen($_POST['Npassword'])/2)+1);
	$SEASALT = strtolower($_POST['NUsername']);
        $PWn = hash('whirlpool',$SEASALT.$password[0].$Salt.$password[1]);*/

    $UNn = $credentials[0];
    $PWn = $credentials[1];

	$RNn = encrypt($RName);
	$EMn = encrypt(validate(strtolower($_POST['Email']), 'enc'));
	$Date = date("Y-m-d");
        
/*     for ($I =  0; $I < 1000; $I++){
	$UNn = hash('sha256',$UNn);
        $PWn = hash('whirlpool',$PWn);
    }*/

        echo $UNn . ': UN<br />';
        //echo $SEASALT . ': S<br />';
        echo $PWn . ': PW<br />';
        echo $EMn . ': EMN<br />';
        
	$db = 'tblpdu';
        $cols = 'PUME, PRD, PRNME, PEL, PRDate, PSY, PLLDate, PLCDate, PVD, whoupdate';
        $vals = "'$UNn','$PWn','$RNn','$EMn','$Date','Admin Editor View','$Date','$Date','1','Install'";
        $die = 'sorry it went wrong';
        $result = SQLI($db, $cols, $vals, $die, null, null, null);
    ?>

<div id="editbox">
<form name="NextForm" method="post" />
    <input type=submit name="save" value=" Next " />
</form>
    <?php
}else{
 
?>

<html>
    <centre><h3>Setup Avacado CMS</h3></centre>
    <p>
        Thank you for choosing Avacado CMS, there are a few things we need to configure before we begin.
    </p>
    <p>
<form name="SetupForm" method="post" />

<table width="90%" border="1">
    <thead>

</thead>
<tbody>
    <tr>
    <th>Database Type </th>
    <td>
        <select name="DatabaseType">
            <option value="MySQL" >MySQL</option>
            <option value="MySQLi" selected>MySQLi</option>
        </select>
    <td>Please select the Database type being used. Note. Use MySQL only for Old versions &lt; 5.2 of PHP </td>
    </tr>
        <tr>
    <th>Database Server Name </th>
    <td>
             <input type="text" name="DatabaseServerName" size="50" value="localhost"/>
        </select>
    </td>
    <td>Please Enter the Database Server Name being used</td>
    </tr>
        <tr>
    <th>Database Server Port </th>
    <td>
             <input type="text" name="DatabaseServerPort" size="50" value="3306"/>
        </select>
    </td>
    <td>Please Enter the Database Name being used</td>
    </tr>
    <tr>
    <th>Database Name </th>
    <td>
             <input type="text" name="DatabaseName" size="50" requred />
        </select>
    </td>
    <td>Please Enter the Database Name being used</td>
    </tr>
        <tr>
    <th>Database Admin Username </th>
    <td>
             <input type="text" name="DatabaseAdminUserName" size="50" requred />
        </select>
    </td>
    <td>Please Enter the SQL Administrator Username being used, this is only used during the setup and is not stored</td>
    </tr>
        <tr>
    <th>Database Admin Password </th>
    <td>
             <input type="password" name="DatabaseAdminPassword" size="50" requred />
        </select>
    </td> 
    <td>Please Enter the SQL Administrator Password being used, This is only used to create the Database, it is not stored</td>
        </tr>
        
            <tr>
    <th>Database Username </th>
    <td>
             <input type="text" name="DatabaseUserName" size="50" requred />
        </select>
    </td>
    <td>Please Enter the Database Username being created to use</td>
    </tr>
        <tr>
    <th>Database Password </th>
    <td>
             <input type="text" name="DatabasePassword" size="50"  requred />
        </select>
    </td> 
    <td>Please Enter the Database Password being created to use</td>
        </tr>
        
        <tr>
    <th colspan='3'> Create system Admin account.</th>
    </tr>
         <tr>
    <th>Admin Username </th>
    <td>
             <input type="text" name="NUsername" size="50" required />
        </select>
    </td> 
    <td>Please Enter the system's Administrator name</td>
    </tr>    <tr>
    <th>Admin Password </th>
    <td>
             <input type="text" name="Npassword" size="50" requred />
        </select>
    </td> 
    <td>Please Enter the System's Administrator password</td>
    </tr>
        <tr>
    <th>Admin email address </th>
    <td>
             <input type="text" name="Email" size="50" requred />
        </select>
    </td> 
    <td>Please Enter the Admin email address</td>
    </tr>
    <th></th>
    <td>
    </td>
    <td><input type=submit name="save" value=" Save " /> </td>
    </tr>
    </form>
</div>
    </p>

</html>

 <?php
  }
  }
