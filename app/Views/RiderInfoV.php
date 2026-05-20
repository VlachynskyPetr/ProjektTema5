<?php

/**
 * @var Object $rider3
 *  @var object $riderInfoV 
 *  @var object $misto
 * 
 */
?>
<?= $this->extend('Layout/template'); ?>
<?= $this->section("content"); ?>

<h1 class="text-center p-2"> Info o Závodníkovi <?= $rider3->first_name ?> <?= $rider3->last_name ?> </h1>


<?php





$table = new \CodeIgniter\View\Table();
$table->setHeading('Místo narození', 'Datum narození', 'Výška', 'Váha');
//misto 1
if ($riderInfoV->place_of_birth == null) {
    $misto = "???";
} else {
    $misto = $riderInfoV->name;
}

// datum narozeni 2
if ($riderInfoV->date_of_birth == null) {
    $narozeni = "???";
} else {
    $narozeni = $riderInfoV->date_of_birth;
}

//vyska 3
if ($riderInfoV->height == 0) {
    $vyska = "???";
} else {
    $vyska = $riderInfoV->height;
}

//vaha 4
if ($riderInfoV->weight == 0) {
    $vaha = "???";
} else {
    $vaha = $riderInfoV->weight;
}

$table->addRow($misto, $narozeni, $vyska . "cm", $vaha . "kg");

$template = array(
    'table_open' => '<table class="table table-bordered">',
    'thead_open' => '<thead>',
    'thead_close' => '</thead>',
    'heading_row_start' => '<tr>',
    'heading_row_end' => ' </tr>',
    'heading_cell_start' => '<th>',
    'heading_cell_end' => '</th>',
    'tbody_open' => '<tbody>',
    'tbody_close' => '</tbody>',
    'row_start' => '<tr>',
    'row_end'  => '</tr>',
    'cell_start' => '<td>',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td>',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>'
);

$table->setTemplate($template);

echo $table->generate();
?>
<?= $this->endSection(); ?>