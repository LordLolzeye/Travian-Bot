<?php
function fail($mess)
{
  echo '<div class="alert alert-danger alert-white rounded">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<div class="icon"><i class="fa fa-times-circle"></i></div>
		<strong>Error!</strong> ' . $mess . '
  </div>';
}
function success($mess)
{
  echo '<div class="alert alert-success alert-white-alt rounded">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<div class="icon"><i class="fa fa-check"></i></div>
		<strong>Success!</strong> ' . $mess . '
  </div>';
}
function info($mess)
{
  echo '<div class="alert alert-info alert-white-alt rounded">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<div class="icon"><i class="fa fa-info-circle"></i></div>
		<strong>Info!</strong> You have 3 new messages in your inbox.
  </div>';
}
function getVillageType($arr)
{
  
}
?>