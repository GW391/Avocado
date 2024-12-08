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

require 'template/class/settingBox.php';

$system = true;



//if(preg_match("/".'editor'."/i", $_SESSION['security'])){

$security = new securityCheck('editor');
if ($security->output)
{

//  echo new securityCheck('Rota');

echo "<div class='Settings'><h2>About </h2>";
echo "Version: " . parameters('version') . "<br>";
echo "Build: " . parameters('build') . "<br></div>";

$Group = null;
$Limit = null;
$sort = null;

$Select = "Target";
$From = "tblcontent";
$die = "Sorry something went wrong, please try again later";
$where = "active = 1";
$activeArticles = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "active != 1";
$inactiveArticles = SQL($Select, $From, $die, $where, $Limit, null, $sort);


echo "<div class='Settings'><h2>Articles </h2>";
//$activeArticles = new settingBox("Target", "tblcontent", "active = 1");
//echo "Active Articles: " . $activeArticles = new settingBox("Target", "tblcontent", "active = 1") . "<br>";
//echo "Inactive Articles: " . $inactiveArticles = new settingBox("Target", "tblcontent", "active != 1") . "<br></div>";
echo "Active Articles: " . num_rows($activeArticles) . "<br>";
echo "Inactive Articles: " . num_rows($inactiveArticles) . "<br></div>";


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
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'news' && deleted != 1";
$NewsletterActiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "type = 'news' && deleted = 1";
$NewsletterInactiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

echo "<div class='Settings'><h2>Newsletters </h2>";
echo "Active Newsletters: " . num_rows($NewsletterActiveResult) . "<br>";
echo "Inactive Newsletteds: " . num_rows($NewsletterInactiveResult) . "<br></div>";

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

$Select = "idtblnewsletter";
$From = "tblnewsletter";
$die = "Sorry something went wrong, please try again later";
$where = "Deleted != 1 && PVD = 1";
$SubscribersActiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "Deleted = 1";
$SubscribersDeletedResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "Deleted != 1 && PVD != 1";
$SubscribersUnvarifiedResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

echo "<div class='Settings'><h2>News Subscribers </h2>";
echo "Active Subscribers: " . num_rows($SubscribersActiveResult) . "<br>";
echo "Deleted Subscribers: " . num_rows($SubscribersDeletedResult) . "<br>";
echo "Unvarified Subscribers: " . num_rows($SubscribersUnvarifiedResult) . "<br></div>";

?>
<?php
}else
echo parameters('PermissionsMessage');
?>
