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
echo "Build: " . parameters('build') . "<br>";
echo '<a href="?target=System&amp;section=ForceUpgrade"> Upgrade Settings </a>';
echo "</div>";


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


$Select = "TIME_FORMAT(SEC_TO_TIME(avg(substr(duration,1,LOCATE(':',duration)-1)*60+right(duration,2))), \"%H:%i:%s\") as AverageDuration";
$from =  'tblattachment';
$where = "type = 'podcast' && deleted != 1 && duration is not NULL && duration != 0";
$PodcastAverageDuration = SQL($Select, $From, $die, $where, $Limit, null, $sort);

echo "<div class='Settings'><h2>Podcasts </h2>";

// if user is podcast editior add upload file link
$EditPodcastSecurity = new securityCheck(parameters('EditPodcastSecurity'));
  // check if current user can edit parameters
$Settingssecurity = new securityCheck(parameters('SettingsSecurity'));

if ($EditPodcastSecurity->output || $Settingssecurity->output){

if ($EditPodcastSecurity->output){
  // if current user can add podcast, display upload link.
  echo '<a href="?target=System&amp;section=Settings&amp;subsection=podcastuploads">'; new Icon("upload"); echo '</a>';
}

if ($security->output)
{
    // if current user can edit parameters, display parameters link.
  echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?target=Settings&amp;limit=podcast">'; new Icon("settings"); echo '</a>';
  }
echo '<br>';
}

echo "Active Podcast: " . num_rows($PodcastActiveResult) . "<br>";
echo "Inactive Podcast: " . num_rows($PodcastInactiveResult) . "<br>";
while ($AverageDuration = fetch_array($PodcastAverageDuration)){
echo "Average Duration: " . $AverageDuration['AverageDuration'] . "<br>";
}
echo "</div>";

$Select = "UUID";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'news' && deleted != 1";
$NewsletterActiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
$where = "type = 'news' && deleted = 1";
$NewsletterInactiveResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

echo "<div class='Settings'><h2>Newsletters </h2>";
// if user is News Sender add Send News link
$SendNewsSecurity = new securityCheck(parameters('SendNewsSecurity'));
  // check if current user can edit parameters
$Settingssecurity = new securityCheck(parameters('SettingsSecurity'));
if ($SendNewsSecurity->output || $Settingssecurity->output){

if ($SendNewsSecurity->output){
  // if current user can add podcast, display upload link.
  echo '<a href="?target=news&amp;section=Mail">'; new Icon("upload"); echo '</a>';
}

if ($security->output)
{
    // if current user can edit parameters, display parameters link.
  echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?target=Settings&amp;limit=News">'; new Icon("settings"); echo '</a>';
  }
echo '<br>';
}


echo "Active Newsletters: " . num_rows($NewsletterActiveResult) . "<br>";
echo "Inactive Newsletters: " . num_rows($NewsletterInactiveResult) . "<br></div>";



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
