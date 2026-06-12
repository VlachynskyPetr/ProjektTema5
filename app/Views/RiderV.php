<?= $this->extend('Layout/template'); ?>
<?= $this->section("content");?>
 
<h1 class="text-center p-4" style="color: white;">ZÁVODNÍCÍ Z FRANCIE</h1>
<div class="container mt-3 pb-5 text-center">

  <div class="row mb-3">
    <div class="col-md-2 text-start">
      <?= anchor('polozka/pridat','Pridat jezdce', ['class' => 'btn btn-success w-100']) ?>
    </div>
  </div>

  <div class="row">
    <?php foreach($riderV as $row1): ?>
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
        <div class="card w-100">
          <?php if ($row1->photo == null): ?> 
            <img class="card-img-top img-fluid" src="<?= base_url("img/neznamej.png")?>" alt="Card image" style="object-fit: cover; height: 400px;"> 
          <?php else: ?> 
            <img class="card-img-top img-fluid" src="<?= base_url("img/riders/".$row1->photo)?>" alt="Card image" style="object-fit: cover; height: 400px;"> 
          <?php endif; ?>
          
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title" style="font-size:16px"><?= esc($row1->first_name)." ".esc($row1->last_name) ?></h5>
            
            <div class="d-grid gap-2 mt-3">
              <?= anchor('rider/info/'.$row1->id ,'Informace', ['class' => 'btn btn-primary btn-sm']) ?>
              <?= anchor('polozka/upravit/'.$row1->id ,'Upravit', ['class' => 'btn btn-warning btn-sm']) ?>
              <?= anchor('polozka/smazat/'.$row1->id ,'Smazat', ['class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Opravdu chcete jezdce smazat?');"]) ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="d-flex justify-content-center pt-4">
    <?= $pager->links(); ?>
  </div>
</div>
<?= $this->endSection();?>