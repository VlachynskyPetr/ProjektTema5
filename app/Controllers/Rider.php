<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Rider as ModelRider;
use App\Models\Location;

class Rider extends BaseController
{
    /**
     * HLAVNÍ STRÁNKA (VÝPIS)
     * Zobrazuje seznam všech aktivních jezdců z Francie se stránkováním.
     */
    public function index()
    {
        // Vytvoření instance modelu pro přístup k datům v tabulce jezdců
        $rider = new ModelRider();
        
        // Načtení konfigurace stránkování. Pokud v systému neexistuje, nastaví se výchozích 24 záznamů na stránku
        $perPage = config('Pager')->perPage ?? 24; 

        // Dotaz do DB: vyfiltruje pouze jezdce, kteří mají 'country' rovno 'fr',
        // seřadí je abecedně podle křestního jména a rozdělí data pro stránkování (paginate)
        $rider2 = $rider->where('country', "fr")->orderBy('first_name', 'asc')->paginate($perPage);
        
        // Získání objektu stránkování pro vykreslení navigačních odkazů v šabloně
        $pager = $rider->pager;

        // Příprava pole dat, které předáme šabloně
        $data = [
            "riderV" => $rider2,
            "pager" => $pager
        ];
        
        // Vykreslení pohledu (View) s názvem RiderV a předáním dat
        echo view("RiderV", $data);
    }

    /**
     * DETAIL JEZDCE
     * Zobrazuje detailní informace o jednom konkrétním jezdci včetně názvu jeho rodiště.
     */
    public function index2(int $id)
    {
        $rider = new ModelRider;
        
        // Načte surová data jednoho jezdce z DB podle jeho primárního klíče (ID)
        $rider3 = $rider->where('id', $id)->first();
        
        // Propojí tabulku jezdců s tabulkou lokací (LEFT JOIN) na základě ID místa narození,
        // aby bylo možné v detailu zobrazit reálný název města místo pouhého číselného ID
        $rider2 = $rider->join('location', 'rider.place_of_birth=location.id', 'left')->find($id);

        $data = [
            "riderInfoV" => $rider2,
            'id' => $id,
            "rider3" => $rider3,
        ];
        echo view("RiderInfoV", $data);
    }

    /**
     * JEZDCI PODLE MÍSTA NAROZENÍ
     * Vyhledá a zobrazí město a seznam všech jezdců, kteří se v daném městě narodili.
     */
    public function index3(int $id)
    {
        $rider = new ModelRider;
        $lokace = new Location;

        // Načte informace o vybraném městě podle ID z tabulky lokací
        $rider3 = $lokace->where('id', $id)->first();
        
        // Vyhledá všechny jezdce, u kterých se sloupec 'place_of_birth' shoduje s ID tohoto města
        $rider2 = $rider->select('rider.*')->join('location', 'rider.place_of_birth=location.id', 'left')->where('place_of_birth', $id)->findAll();
     
        $data = [
            "riderBorn" => $rider3,
            "riderInfoV" => $rider2,
            'id' => $id,
        ];
        echo view("RiderBorn", $data);
    }

    /**
     * FORMULÁŘ PRO NOVÉHO JEZDCE
     * Načte potřebná data z DB a zobrazí prázdný formulář pro vytvoření nového záznamu.
     */
     public function add() {
        $locationModel = new Location();
        
        // Vytáhne z databáze pouze lokace, které patří do Francie ('fr'), a seřadí je podle názvu
        $data['locations'] = $locationModel->where('country', 'fr')->orderBy('name', 'asc')->findAll();
        
        // Statické pole podporovaných zemí pro případné využití ve formuláři
        $data['countries'] = ['fr' => 'Francie', 'cz' => 'Česko', 'sk' => 'Slovensko'];
        
        // Načte šablonu formuláře (RiderFormV)
        echo view('RiderFormV', $data);
    }

    /**
     * ULOŽENÍ NOVÉHO JEZDCE
     * Zpracuje odeslaná data z formuláře, nahraje fotografii a vytvoří nový řádek v databázi.
     */
    public function store() {
        $rider = new ModelRider();

        // Odchycení nahraného souboru s názvem 'photo' z HTTP požadavku
        $file = $this->request->getFile('photo');
        $photoName = null;
        
        // Kontrola, zda byl soubor úspěšně nahrán a nedošlo k chybě
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Vygenerování náhodného bezpečného názvu souboru (ochrana před přepsáním jiného obrázku)
            $photoName = $file->getRandomName();
            // Přesun souboru ze dočasné složky do cílového adresáře v projektu
            $file->move('img/riders/', $photoName);
        }

        // Metoda save() automaticky provede SQL INSERT a vloží data do příslušných sloupců
        $rider->save([
            'first_name'     => $this->request->getPost('first_name'),
            'last_name'      => $this->request->getPost('last_name'),
            'country'        => $this->request->getPost('country') ?? 'fr', 
            'place_of_birth' => $this->request->getPost('place_of_birth'), 
            'date_of_birth'  => $this->request->getPost('date_of_birth'),
            'height'         => $this->request->getPost('height'),
            'weight'         => $this->request->getPost('weight'),
            'description'    => $this->request->getPost('description'), 
            'photo'          => $photoName // Uloží název obrázku (nebo null, pokud se nenahrál)
        ]);

        // Po úspěšném uložení přesměruje uživatele zpět na hlavní přehled
        return redirect()->to('/');
    }

    /**
     * FORMULÁŘ PRO EDITACI
     * Načte stávající data konkrétního jezdce a předvyplní je do formuláře.
     */
    public function edit(int $id) {
        $rider = new ModelRider();
        $locationModel = new Location();

        // Vyhledá jezdce podle předaného ID v URL adrese
        $data['rider'] = $rider->find($id);
        
        // Opět načte francouzská města pro výběrové pole (select)
        $data['locations'] = $locationModel->where('country', 'fr')->orderBy('name', 'asc')->findAll();
        $data['countries'] = ['fr' => 'Francie', 'cz' => 'Česko', 'sk' => 'Slovensko'];

        // Bezpečnostní pojistka: Pokud jezdec s tímto ID neexistuje (např. někdo přepsal URL), vyhodí chybu 404
        if (!$data['rider']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Otevře stejnou šablonu formuláře, ale tentokrát v ní bude proměnná $rider s daty
        echo view('RiderFormV', $data);
    }

    /**
     * AKTUALIZACE DAT V DATABÁZI
     * Zpracuje upravená data z formuláře a přepíše stávající záznam jezdce.
     */
    public function update(int $id) {
        $rider = new ModelRider();
        // Načtení původního záznamu jezdce před úpravou
        $existingRider = $rider->find($id);

        $file = $this->request->getFile('photo');
        // Jako výchozí název fotky nastavíme ten původní, pro případ, že uživatel novou fotku nenahrává
        $photoName = $existingRider->photo;

        // Pokud uživatel vybral a nahrává nový obrázek
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $photoName = $file->getRandomName();
            $file->move('img/riders/', $photoName);
            // Poznámka: Zde by bylo ideální starý soubor z 'img/riders/' smazat, aby nezabíral místo.
        }

        // Metoda update() provede SQL UPDATE pro dané ID a přepíše pouze změněné hodnoty
        $rider->update($id, [
            'first_name'    => $this->request->getPost('first_name'),
            'last_name'     => $this->request->getPost('last_name'),
            'country'       => $this->request->getPost('country'),
            'place_of_birth'=> $this->request->getPost('place_of_birth'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'height'        => $this->request->getPost('height'),
            'weight'        => $this->request->getPost('weight'),
            'description'   => $this->request->getPost('description'),
            'photo'         => $photoName
        ]);

        // Přesměrování zpět na hlavní přehled
        return redirect()->to('/');
    }

    /**
     * ODSTRANĚNÍ JEZDCE (SOFT DELETE)
     * Neodstraní záznam z tabulky úplně, pouze ho skryje před uživateli.
     */
    public function delete(int $id) {
        $rider = new ModelRider();
        
        // Pokud má model aktivovaný Soft Delete, tato metoda nesmaže řádek z DB fyzicky (příkazem DELETE),
        // ale pouze zapíše aktuální datum a čas do sloupce 'deleted_at'.
        // Metoda index() pak takto označené jezdce automaticky ignoruje.
        $rider->delete($id); 
        
        return redirect()->to('/');
    }
}
