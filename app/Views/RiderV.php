<?= $this->extend('Layout/template'); ?>
<?= $this->section("content");?>
 
<h1 class="text-center p-4">Závodníci z Francie</h1>
<div class="container mt-3 pb-5 text-center">
  <div class="row">
<?php
/** @var array $riderV */
/** @var String
 * @var String  $id
 * @var Object $pager
 * @var Object $row 
 * */

 foreach($riderV as $row)
{
?>
<div class="col-md-3 mb-3 ">
  <div class="card" style="width:300px">
    <?php
  if ($row->photo == null) {
  ?> <img class="card-img-top" src="<?= base_url("img/neznamej.png")?>" alt="Card image" style="width:100%"> <?php
} else {
  ?> <img class="card-img-top" src="<?= base_url("img/riders/".$row->photo)?>" alt="Card image" style="width:100%"> <?php
}
?>
    
    <div class="card-body">
      <h4 class="card-title"><?= $row->first_name." ".$row->last_name  ?></h4>
      
    <?=  anchor('rider/info/'.$row->id ,'Informace', ['class' => 'btn btn-primary']) ?>
    
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