<?php
session_start();
include_once "engine/verify.php";
$path_parts = pathinfo(__FILE__);
$filename = $path_parts['basename'];
include_once "engine/tapi.php";
include_once "engine/config.php";
include_once "engine/dom.php";
include_once "engine/functions.php";
include_once "Templates/head.php";
?>
<div id="cl-wrapper">
  <div class="cl-sidebar">
    <div class="cl-toggle"><i class="fa fa-bars"></i></div>
    <div class="cl-navblock">
      <div class="menu-space">
        <div class="content">
          <?php
          include_once "Templates/user.php";
          include_once "Templates/links.php";
          ?>
        </div>
      </div>
    </div>
  </div>
<?php
include_once "Templates/navtop.php";
?>

<div class="cl-mcont">
   <div class="page-head">
      <ol class="breadcrumb">
         <li><a href="#">Acasa</a></li>
      </ol>
   </div>


</div>
</div> 
</div>
<?php
include_once "Templates/footer.php";
?>
