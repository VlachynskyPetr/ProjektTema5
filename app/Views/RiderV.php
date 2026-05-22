<?= $this->extend('Layout/template'); ?>
<?= $this->section("content");?>
 
<h1 class="text-center  p-4" style="color: white;">ZÁVODNÍCÍ Z FRANCIE</h1>
<div class="container mt-3 pb-5 text-center">
  <div class="row">
<?php
/** @var array $riderV 
 * @var Object $pager
 * */

 foreach($riderV as $row1)
{
?>
<div class="col-md-2 mb-2 ">
  <div class="card" style="width:200px">
    <?php
  if ($row1->photo == null) {
  ?> <img class="card-img-top" src="<?= base_url("img/neznamej.png")?>" alt="Card image" style="width:100%"> <?php
} else {
  ?> <img class="card-img-top" src="<?= base_url("img/riders/".$row1->photo)?>" alt="Card image" style="width:100%"> <?php
}
?>
    
    <div class="card-body " >
      <h5 class="card-title" style="font-size:16px"><?= $row1->first_name." ".$row1->last_name  ?></h4>
      
    <?=  anchor('rider/info/'.$row1->id ,'Informace', ['class' => 'btn btn-primary']) ?>
    
    </div>
  </div>
</div>
  <br>

<?php

}
?>

  <div class="d-flex justify-content-center pt-4" >
<?php anchor('rider/info/',  'Infomace');
 echo $pager->links();
 ?>
 </div>
 </div>
  </div>



 
 
<?= $this->endSection();?>