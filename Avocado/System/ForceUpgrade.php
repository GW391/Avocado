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
$security = new securityCheck('editor');
if ($security->output)
{

echo "<div class='Settings'><h2>About </h2>";
echo "Version: " . parameters('version') . "<br>";
echo "Build: " . parameters('build') . "<br></div>";

echo "<div class='Settings'><h2>Initiating Forced Upgrade </h2>";
include 'template/UpdateDB.php';
echo "<h2> Forced Upgrade Complete </h2>";
echo "</div>";

echo "<div class='Settings'><h2>About </h2>";
echo "Version: " . parameters('version') . "<br>";
echo "Build: " . parameters('build') . "<br></div>";
}
?>
