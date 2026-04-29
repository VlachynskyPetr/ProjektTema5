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
        $rider2 = $rider->find();
        $data = [
            "riderV" => $rider2
        ];
        echo view("RiderV",$data);
    }
}
