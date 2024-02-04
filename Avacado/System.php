<center><h2>System</h2></center>
<style>
div.Settings {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 200px;
  border-radius: 25px;
  text-align: center;
}
</style>

<?php
$system = true;



if(preg_match("/".'editor'."/i", $_SESSION['security'])){

  echo "<div class='Settings'><h2>About </h2>";
echo "Version: " . parameters('version') . "<br>";
echo "Build: " . parameters('build') . "<br></div>";

$Select = "Target";
$From = "tblcontent";
$die = "Sorry there is a problem on this page please, try again later";
$where = "active = 1";
$GROUP = null;
$Limit = null;
$sort = null;
$ActiveResult = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);
$where = "active != 1";
$InactiveResult = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

echo "<div class='Settings'><h2>Articles </h2>";
echo "Active Articles: " . num_rows($ActiveResult) . "<br>";
echo "Inactive Articles: " . num_rows($InactiveResult) . "<br></div>";


$Select = "UUID";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'podcast' && deleted != 1";
$PodcastActiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "type = 'podcast' && deleted = 1";
$PodcastInactiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

echo "<div class='Settings'><h2>Podcasts </h2>";
echo "Active Podcast: " . num_rows($PodcastActiveResult) . "<br>";
echo "Inactive Podcast: " . num_rows($PodcastInactiveResult) . "<br></div>";

$Select = "UUID";
$From = "tblpdu";
$die = "Sorry something went wrong, please try again later";
$where = "Deleted != 1 && PVD = 1";
$UsersActiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "Deleted = 1";
$UsersDeletedResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "Deleted != 1 && PVD != 1";
$UsersUnvarifiedResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

echo "<div class='Settings'><h2>Users </h2>";
echo "Active Users: " . num_rows($UsersActiveResult) . "<br>";
echo "Deleted Users: " . num_rows($UsersDeletedResult) . "<br>";
echo "Unvarified Users: " . num_rows($UsersUnvarifiedResult) . "<br></div>";



?>
<?php
}else
echo parameters('PermissionsMessage');
?>
