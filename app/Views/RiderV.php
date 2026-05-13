<?= $this->extend('Layout/template'); ?>
<?= $this->section("content");?>
 
<h1 class="text-center p-2">Závodníci z Francie</h1>
<div class="container mt-3">
  <div class="row">
<?php
/** @var array $riderV */
foreach($riderV as $row)
{
?>
<div class="col-md-4 mb-4">
  <div class="card" style="width:400px">
    <img class="card-img-top" src="<?= base_url("img/riders/".$row->photo)?>" alt="Card image" style="width:100%">
    <div class="card-body">
      <h4 class="card-title"><?= $row->first_name." ".$row->last_name  ?></h4>
      <a href="#" class="btn btn-primary">Informace</a>
    </div>
  </div>
</div>
  <br>

<?php
}
?>
  </div>
</div>

base_url("img/riders/".$row->photo)?>
 
 
<?= $this->endSection();?>