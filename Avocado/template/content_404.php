<?php
header_remove();
http_response_code(404);
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
?>


<h2>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</h2>
<hr />
<img src="images/icons/404.png" alt="404">
<p>Please try the following:</p>
<ul>

<li>Make sure that the Web site address displayed in the address bar of your browser is spelled and formatted correctly.</li>
<li>Use the menu on the left to navigate to the page</li>
<li>If you reached this page by clicking a link, contact the Web site administrator to alert them that the link is incorrectly formatted.</li>
<li>Click the <a href="javascript:history.back(1)">Back</a> button to try another link.</li>
</ul>
<h4>HTTP Error 404 - File or directory not found.</h4>

        </div>
 <!--   <center> -->

<div class='lockheader'>
    <div class="header">


        <?php include("template/header.php"); ?>

        <!-- menu -->
        <?php include("template/menu.php"); ?>

       <?php if (parameters('Breadcrumbs')){ ?>
           <?php // if breadcrumbs has been requested put it in ?>
           <div id="breadcrumbs">
               <?php require("template/breadcrumbs.php"); ?>
           </div>
      <?php } ?>
        </div>
    </div>





    <div id="footer">
    <?php // insert page footer
    include ("template/footer.php");
?>
</div>
<!--</center>-->
</body>
</html>
<?php die();?>
