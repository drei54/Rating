<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rating Average</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<?php
include 'lib/Rating-Avg.php';

$fullpath = dirname(__FILE__);
$fullpath = str_replace('\\',"/",$fullpath);

?>
    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Home</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
            </ul>
          </div>
        </div>
      </div>
    </div>

  <div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">

</br></br></br>

<form  method="GET" action="<?=$_SERVER['PHP_SELF']?>">
  <div class="form-group">
    <label for="file1">Item List File</label>
    <input name="location_item_list" type="text" id="location_item_list" placeholder="Item List File" class="span6" value="<?=$fullpath."/item_list.xlsx"?>">
  </div>
  <div class="form-group">
    <label for="file2">Rating List File</label>
    <input name="location_item_rating" type="text" id="location_item_rating" placeholder="Rating List File"  class="span6" value="<?=$fullpath."/item_rating.xlsx"?>">
  </div>
  <div class="form-group">
    <label for="Date">Date Average</label>
    <input name="ed" type="text" id="ed" placeholder="yyyy-mm-dd" value="<?=Date('Y-m-d')?>" class="span2">
  </div>
  <button type="submit" class="btn btn-default" name="submit">Submit</button>
</form>
<hr>

<?php

if(isset($_GET['submit']) == 1){
	if($_GET['location_item_list'] != "" AND $_GET['location_item_rating'] != "" AND $_GET['ed'] != ""){
		$_GET['sd'] 	= date('Y-m-d', strtotime($_GET['ed'] . ' -3 month'));
		$class 			= new rating_average();
		$data 			= $class->main($_GET);
		#print_r($data);
?>
<h4>List Item</h4>
<table class="table table-striped table-bordered">
<tr><th>ID</th><th>Name</th><th>Date</th></tr>
<?php foreach($data['item_list'] as $il => $vil){ ?>
	<tr><td><?=$il?></td><td><?=$vil[0]['b']?></td><td><?=$vil[0]['c']?></td></tr>
<?php } ?>
</table>
<table class="table table-striped table-bordered">
<hr>

<h4>Rating Average Items 3 month</h4> (<?=$_GET['sd']?> s/d <?=$_GET['ed']?>)
<table class="table table-striped table-bordered">
<tr><th>ID</th><th>Name</th><th>Count (Rating)</th><th>Total (Rating)</th><th>Average (Rating)</th></tr>
<?php foreach($data['cnt'] as $cn => $vcn){ ?>
	<tr><td><?=$cn?></td><td><?=$data['item_list'][$cn][0]['b']?></td><td><?=$vcn['cnt']?></td><td><?=$vcn['sum']?></td><td><?=$vcn['avg']?></td></tr>
<?php } ?>
</table>
<hr>

<h4>List Item Rating</h4> all data
<table class="table table-striped table-bordered">
<tr><th>ID</th><th>Rating</th><th>Date</th></tr>
<?php foreach($data['item_rating'] as $il => $vil){ 
	foreach($vil as $v){
?>
	<tr><td><?=$il?></td><td><?=$v['b']?></td><td><?=$v['c']?></td></tr>
<?php } }?>
</table>
<table class="table table-striped table-bordered">
<hr>
<?php
	}
}
?>
</div></div>
</body>
