<?= $this->extend('Layout/template'); ?>
<?= $this->section("content");?>

<h1 class="text-center p-2"> Info o Závodníkovi z Francie</h1>


<?php





$table = new \CodeIgniter\View\Table();
$table->setHeading( 'Místo narození','Datum narození', 'Výška', 'Váha');
foreach($riderInfoV as $row)
{
    $table->addRow($row->place_of_birth, $row->date_of_birth, $row->height, $row->weight);
}
$template = array(
    'table_open'=> '<table class="table table-bordered">',
    'thead_open'=> '<thead>',
    'thead_close'=> '</thead>',
    'heading_row_start'=> '<tr>',
    'heading_row_end'=>' </tr>',
    'heading_cell_start'=> '<th>',
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
<?= $this->endSection();?>

