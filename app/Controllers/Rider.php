<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Rider as ModelRider;

class Rider extends BaseController
{
    public function index()
    {
        $rider = new ModelRider();
        $rider2 = $rider->where('country', "fr")->orderBy('first_name', 'asc')->paginate(21);
        $data = [
            "riderV" => $rider2,
        ];
        echo view("RiderV",$data);
    }

public function index2($id)
{
$rider = new ModelRider;
$rider2 = $rider->where('id', $id)->findAll();
$data = [
    "riderInfoV" => $rider2,
    'id' => $id

];
echo view("RiderInfoV",$data);
}
}