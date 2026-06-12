<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Rider as ModelRider;
use App\Models\Location;

class Rider extends BaseController
{
    public function index()
    {
        $rider = new ModelRider();
        $rider2 = $rider->where('country', "fr")->orderBy('first_name', 'asc')->paginate(24);
        $pager = $rider->pager;
        $data = [
            "riderV" => $rider2,
            "pager" => $pager
        ];
        echo view("RiderV", $data);
    }
/**
 * @param $id - id závodníka, který chceme zobrazit 
 */

    public function index2(int $id)
    {
        $rider = new ModelRider;
        $lokace = new Location;
       $rider3 = $rider->where('id', $id)->first();
       
        $rider2 = $rider->join('location', 'rider.place_of_birth=location.id', 'left')->find($id);
   

     
        $data = [
            "riderInfoV" => $rider2,
            'id' => $id,
            "rider3" => $rider3,
           
           

        ];
        echo view("RiderInfoV", $data);
    }
     public function index3(int $id)
     {
        $rider = new ModelRider;
        $lokace = new Location;

        $rider3 = $lokace->where('id', $id)->first();
        $rider2 = $rider->select('rider.*')->join('location', 'rider.place_of_birth=location.id', 'left')->where('place_of_birth', $id)->findAll($id);
     
        $data = [
            "riderBorn" => $rider3,
            "riderInfoV" => $rider2,
            'id' => $id,
        

        ];
        echo view("RiderBorn", $data);
     }
     function add() {
        echo view('add');
    }
    }

