<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\User;

class DragonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('acquire');
    }

    /*
    function show(Int $id)
    {
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }
    */

    // Pobierz informację z bazy danych o tym ile użytkownik posiada już smoków
    function nest() {
        $dragons = DB::table('dragons')
        ->where('idOwner', '=', Auth::id())
        ->get();
        return view('nest', ['dragonsOwned' => $dragons]);
    }

    // Pobierz szczegółowe informacje o smoku z konkretnym ID
    static function getDragonInfoDB(Int $idDragon) {
        return DB::select("select * from dragons where id = $idDragon");
    }

    // Pobierz informacje o wszystkich rasach z pliku konfiguracyjnego
    static function getSpeciesConf() {
        return Config::get('species');
    }

    // Pobierz informacje o wszystkich elementach dostępnym dla konkretnej rasy z pliku konfiguracyjnego
    static public function getConfDragonSpecies(String $spec) {
        $conf = Config::get('species');
        return $conf[$spec]['elements'];
    }

    // Wylosuj element bazując na podanej rasie
    static function randomElement(String $spec)
    {
        $array = DragonsController::getConfDragonSpecies($spec);
        $element = explode( ",", $array );
        $number = array_rand($element,1);
        return $element[$number];
    }

    // Wyświetl stronę z wybranym nowym smokiem
    function makeAChoice() {
        return view('choose');
    }

    // Dodaj smoka do bazy danych dla konkretnego użytkownika z dokładnymi informacjami
    static function addDragonToDatabase(Int $idOwn, String $name, String $spec, String $element, Int $gender) {
        DB::table('dragons')->insert([
            'idOwner' => $idOwn,
            'name' => $name,
            'gender' => $gender,
            'level' => 1,
            'species' => $spec,
            'element' => $element
        ]);

    }
}
