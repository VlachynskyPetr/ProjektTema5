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
        
        // Stránkování bráno z konfigurace (např. v Config/Pager.php nebo vlastního configu), případně default 24
        $perPage = config('Pager')->perPage ?? 24; 

        // Zobrazujeme pouze nesmazané (soft delete filtruje automaticky)
        $rider2 = $rider->where('country', "fr")->orderBy('first_name', 'asc')->paginate($perPage);
        $pager = $rider->pager;

        $data = [
            "riderV" => $rider2,
            "pager" => $pager
        ];
        echo view("RiderV", $data);
    }

    public function index2(int $id)
    {
        $rider = new ModelRider;
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
        $rider2 = $rider->select('rider.*')->join('location', 'rider.place_of_birth=location.id', 'left')->where('place_of_birth', $id)->findAll();
     
        $data = [
            "riderBorn" => $rider3,
            "riderInfoV" => $rider2,
            'id' => $id,
        ];
        echo view("RiderBorn", $data);
    }

    // Zobrazení formuláře pro přidání
    public function add() {
        // Dropdown pro země - simulace, ideálně vytáhnout z DB nebo statické pole
        $data['countries'] = ['fr' => 'Francie', 'cz' => 'Česko', 'sk' => 'Slovensko'];
        echo view('RiderFormV', $data);
    }

    // Uložení nového jezdce
    public function store() {
        $rider = new ModelRider();

        $file = $this->request->getFile('photo');
        $photoName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $photoName = $file->getRandomName();
            $file->move('img/riders/', $photoName);
        }

        $rider->save([
            'first_name'    => $this->request->getPost('first_name'),
            'last_name'     => $this->request->getPost('last_name'),
            'country'       => $this->request->getPost('country'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'height'        => $this->request->getPost('height'),
            'weight'        => $this->request->getPost('weight'),
            'description'   => $this->request->getPost('description'), // Z WYSIWYG
            'photo'         => $photoName
        ]);

        return redirect()->to('/');
    }

    // Zobrazení formuláře pro editaci
    public function edit(int $id) {
        $rider = new ModelRider();
        $data['rider'] = $rider->find($id);
        $data['countries'] = ['fr' => 'Francie', 'cz' => 'Česko', 'sk' => 'Slovensko'];

        if (!$data['rider']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        echo view('RiderFormV', $data);
    }

    // Aktualizace dat v DB
    public function update(int $id) {
        $rider = new ModelRider();
        $existingRider = $rider->find($id);

        $file = $this->request->getFile('photo');
        $photoName = $existingRider->photo;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $photoName = $file->getRandomName();
            $file->move('img/riders/', $photoName);
        }

        $rider->update($id, [
            'first_name'    => $this->request->getPost('first_name'),
            'last_name'     => $this->request->getPost('last_name'),
            'country'       => $this->request->getPost('country'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'height'        => $this->request->getPost('height'),
            'weight'        => $this->request->getPost('weight'),
            'description'   => $this->request->getPost('description'),
            'photo'         => $photoName
        ]);

        return redirect()->to('/');
    }

    // Soft Delete akce
    public function delete(int $id) {
        $rider = new ModelRider();
        // Spustí soft delete (zapíše timestamp do deleted_at)
        $rider->delete($id); 
        return redirect()->to('/');
    }
}