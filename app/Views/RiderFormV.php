<!-- Definuje základní layout šablony, do které se vloží tento obsah -->
<?= $this->extend('Layout/template'); ?>

<!-- Spouští sekci s názvem "content" pro hlavní šablonu -->
<?= $this->section("content");?>

<!-- Načtení externí JavaScriptové knihovny textového editoru TinyMCE verze 6 -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  <!-- Inicializace textového editoru TinyMCE pro element s ID #wysiwyg_description -->
  tinymce.init({
    selector: '#wysiwyg_description', // Cílový prvek
    menubar: false,                    // Skrytí hlavního menu editoru
    plugins: 'lists link image test',  // Aktivní doplňky editoru
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist' // Prvky na liště nástrojů
  });
</script>

<!-- Hlavní obalový kontejner formuláře s Bootstrap třídami pro okraje a bílý text -->
<div class="container mt-5 mb-5 text-white" style="max-width: 700px;">
    <!-- Dynamický nadpis: Pokud existuje proměnná $rider, zobrazí se 'Úprava', jinak 'Nový' -->
    <h2 class="mb-4 text-center"><?= isset($rider) ? 'Úprava závodníka' : 'Nový závodník' ?></h2>

    <!-- Formulář odesílá data metodou POST. Atribut enctype umožňuje nahrávání souborů/fotek. -->
    <!-- Cesta se generuje dynamicky pomocí site_url(): pro existujícího jezdce na aktualizaci, jinak pro uložení. -->
    <form action="<?= isset($rider) ? site_url('polozka/aktualizovat/'.$rider->id) : site_url('polozka/ulozit') ?>" method="post" enctype="multipart/form-data">
        
        <!-- Generuje skrytý input s tokenem pro ochranu před CSRF útoky -->
        <?= csrf_field() ?>

        <input type="hidden" name="country" value="fr">

        <!-- Vstupní pole pro Křestní jméno s automatickým předvyplněním a ochranou esc() proti XSS -->
        <div class="form-floating mb-3 text-dark">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Jméno" value="<?= isset($rider) ? esc($rider->first_name) : '' ?>" required>
            <label for="first_name">Jméno</label>
        </div>

        <!-- Vstupní pole pro Příjmení s předvyplněním stávajících dat jezdce a ochranou esc() -->
        <div class="form-floating mb-3 text-dark">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Příjmení" value="<?= isset($rider) ? esc($rider->last_name) : '' ?>" required>
            <label for="last_name">Příjmení</label>
        </div>

         <!-- Výběrové pole (Select) pro Místo narození / ID města -->
         <div class="form-floating mb-3 text-dark">
            <select class="form-select" id="place_of_birth" name="place_of_birth" required>
                <!-- Výchozí prázdná možnost, která je vybraná pouze pokud zakládáme nového jezdce -->
                <option value="" disabled <?= !isset($rider) ? 'selected' : '' ?>>-- Vyberte město --</option>
                
                <!-- Procházení seznamu všech dostupných lokalit/měst z databáze -->
                <?php foreach($locations as $loc): ?>
                    <!-- Každá možnost posílá ID číslem. Atribut selected se přidá, pokud se ID shoduje s jezdcem -->
                    <option value="<?= $loc->id ?>" <?= (isset($rider) && $rider->place_of_birth == $loc->id) ? 'selected' : '' ?>>
                        <?= esc($loc->name) ?> <!-- Bezpečný výpis názvu města -->
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="place_of_birth">Místo narození (Francie)</label>
        </div>

        <!-- Kalendářové vstupní pole pro Datum narození -->
        <div class="form-floating mb-3 text-dark">
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Datum narození" value="<?= isset($rider) ? esc($rider->date_of_birth) : '' ?>">
            <label for="date_of_birth">Datum narození</label>
        </div>

        <!-- Číselné vstupní pole pro Výšku s povoleným krokem na dvě desetinná místa -->
        <div class="form-floating mb-3 text-dark">
            <input type="number" step="0.01" class="form-control" id="height" name="height" placeholder="Výška (m)" value="<?= isset($rider) ? esc($rider->height) : '' ?>">
            <label for="height">Výška (v cm/m)</label>
        </div>

        <!-- Číselné vstupní pole pro Váhu s povoleným krokem na jedno desetinné místo -->
        <div class="form-floating mb-3 text-dark">
            <input type="number" step="0.1" class="form-control" id="weight" name="weight" placeholder="Váha (kg)" value="<?= isset($rider) ? esc($rider->weight) : '' ?>">
            <label for="weight">Váha (v kg)</label>
        </div>

        <!-- Vstupní komponenta pro nahrání grafického souboru (fotografie) -->
        <div class="mb-3 text-start">
            <label for="photo" class="form-label text-white">Fotografie jezdce</label>
            <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
            
            <!-- Pokud jezdce editujeme a už má v databázi uloženou fotku, vypíše se její název -->
            <?php if(isset($rider) && $rider->photo): ?>
                <small class="text-info">Aktuální foto: <?= $rider->photo ?></small>
            <?php endif; ?>
        </div>

        <!-- Spodní lišta s akčními tlačítky formuláře -->
        <div class="d-flex justify-content-between">
            <!-- Návratové tlačítko zpět na hlavní přehled vygenerované pomocí site_url -->
            <a href="<?= site_url('/') ?>" class="btn btn-secondary">Zpět na výpis</a>
            
            <!-- Odesílací tlačítko s dynamickým textem podle toho, zda data měníme, nebo tvoříme nová -->
            <button type="submit" class="btn btn-primary px-5"><?= isset($rider) ? 'Uložit změny' : 'Vytvořit jezdce' ?></button>
        </div>
    </form>
</div>

<!-- Ukončení bloku obsahu sekce "content" -->
<?= $this->endSection();?>
