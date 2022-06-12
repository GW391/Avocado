<?php


//echo "//setup imports";

require_once 'template/library/HTMLPurifier.auto.php';
require_once 'template/functions.php';

//echo "functions loaded";

//Check Configuration is set-up
$filename = 'template/config.php';

if (file_exists($filename)) {
//  echo "The file $filename exists";
    require_once 'template/config.php';
} else {
 // echo "The file $filename does not exist";
    require_once 'template/setup.php';
    die();
}

//echo "config loaded";

require_once 'template/hotsprings_'.$DatabaseType.'.php';
//echo "databse loaded";
require_once 'template/SQL_'.$DatabaseType.'.php';
require_once 'template/vars.php';
require_once 'template/errorlog.php';
require_once 'template/asc_shift.php';

//echo "templates loaded";


   // Retrieve data from Query String
//   $age = $_GET['age'];

$target = $_GET['target'];

//   $wpm = $_GET['wpm'];
   
   // Escape User Input to help prevent SQL Injection
//   $age = mysql_real_escape_string($age);
//   $sex = mysql_real_escape_string($sex);
//   $wpm = mysql_real_escape_string($wpm);


//echo $target;

$Select = "section,
        CASE WHEN DispName IS NOT NULL THEN DispName
	 WHEN subsection IS NOT NULL THEN subsection
         WHEN section IS NOT NULL THEN section 
	 ELSE target
	 end AS DispName";
$From = "tblmenu";
$GROUP = "section";
$die = "Sorry there is a problem on this page please, try again later";
$where = "deleted != 1 && target = '$target' && tld != 1 && section != ''";
$Limit = null;
$sort = "section, sortorder";
$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);
?>

<!--Section:-->
<select id = 'esection' name="esection" onchange = 'SectionFunction()' onload = 'SectionFunction()'>
<option value = ""></option>
<?php while ($secrow = fetch_array($result)){?>
            <option value = "<?php echo validate($secrow['section'],'hd') ?>"><?php echo validate($secrow['section'],'hd') ?></option>
<?php } ?>
</select>
<script>
window.onload = function() {
    SectionFunction()
};
</script>
