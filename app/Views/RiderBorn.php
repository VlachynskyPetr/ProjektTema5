<?= $this->extend('Layout/template'); ?>
<?= $this->section("content"); ?>
<?php
/**
 * @var array $riderInfoV
 * @var object $riderBorn
 */
?>
<h1 class="text-center p-4" style="color: white;"> Závodníci z  <?=$riderBorn->name ?>  </h1>


<?php





$table = new \CodeIgniter\View\Table();
$table->setHeading('Jméno', 'Příjmení', 'Vlajka');
foreach($riderInfoV as $row)
{
$table->addRow( $row->first_name, $row->last_name, '<img src="'.base_url("img/flags/".$row->country.".jpg").'" alt="vlajka" style="width:30px">');
}
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