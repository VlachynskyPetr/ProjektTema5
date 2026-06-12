<?= $this->extend('Layout/template'); ?>
<?= $this->section("content");?>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#wysiwyg_description',
    menubar: false,
    plugins: 'lists link image test',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist'
  });
</script>

<div class="container mt-5 mb-5 text-white" style="max-width: 700px;">
    <h2 class="mb-4 text-center"><?= isset($rider) ? 'Úprava závodníka' : 'Nový závodník' ?></h2>

    <form action="<?= isset($rider) ? site_url('polozka/aktualizovat/'.$rider->id) : site_url('polozka/ulozit') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-floating mb-3 text-dark">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Jméno" value="<?= isset($rider) ? esc($rider->first_name) : '' ?>" required>
            <label for="first_name">Jméno</label>
        </div>

        <div class="form-floating mb-3 text-dark">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Příjmení" value="<?= isset($rider) ? esc($rider->last_name) : '' ?>" required>
            <label for="last_name">Příjmení</label>
        </div>

        <div class="form-floating mb-3 text-dark">
            <select class="form-select" id="country" name="country" required>
                <option value="" disabled <?= !isset($rider) ? 'selected' : '' ?>>-- Vyberte položku --</option>
                <?php foreach($countries as $code => $name): ?>
                    <option value="<?= $code ?>" <?= (isset($rider) && $rider->country == $code) ? 'selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
            <label for="country">Země</label>
        </div>

        <div class="form-floating mb-3 text-dark">
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Datum narození" value="<?= isset($rider) ? esc($rider->date_of_birth) : '' ?>">
            <label for="date_of_birth">Datum narození</label>
        </div>

        <div class="form-floating mb-3 text-dark">
            <input type="number" step="0.01" class="form-control" id="height" name="height" placeholder="Výška (m)" value="<?= isset($rider) ? esc($rider->height) : '' ?>">
            <label for="height">Výška (v cm/m)</label>
        </div>

        <div class="form-floating mb-3 text-dark">
            <input type="number" step="0.1" class="form-control" id="weight" name="weight" placeholder="Váha (kg)" value="<?= isset($rider) ? esc($rider->weight) : '' ?>">
            <label for="weight">Váha (v kg)</label>
        </div>

        <div class="mb-3 text-start">
            <label for="photo" class="form-label text-white">Fotografie jezdce</label>
            <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
            <?php if(isset($rider) && $rider->photo): ?>
                <small class="text-info">Aktuální foto: <?= $rider->photo ?></small>
            <?php endif; ?>
        </div>

        <div class="mb-4 text-start">
            <label for="wysiwyg_description" class="form-label text-white">Biografie / Popis jezdce</label>
            <textarea id="wysiwyg_description" name="description"><?= isset($rider) ? esc($rider->description) : '' ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= site_url('/') ?>" class="btn btn-secondary">Zpět na výpis</a>
            <button type="submit" class="btn btn-primary px-5"><?= isset($rider) ? 'Uložit změny' : 'Vytvořit jezdce' ?></button>
        </div>
    </form>
</div>

<?= $this->endSection();?>