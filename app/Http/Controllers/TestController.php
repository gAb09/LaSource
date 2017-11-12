<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\Commande as Commande;
use App\Domaines\CommandeDomaine as CommandeD;
use App\Models\Ligne as Ligne;
use App\Models\User;
use App\Domaines\LigneDomaine as LigneD;
use App\Domaines\RelaisDomaine as RelaisD;
use App\Domaines\ModepaiementDomaine as ModepaiementD;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommandeD $commandeD, LigneD $ligneD, RelaisD $relaissD, ModepaiementD $modepaiementD)
    {
        $this->commandeD = $commandeD;
        $this->ligneD = $ligneD;
        $this->ligneD = $ligneD;
        $this->relaissD = $relaissD;
        $this->modepaiementD = $modepaiementD;
    }


    public function main()
    {
        $datas = 'TEST';

        return view('layouts.test')->with(compact('datas'));
    }

}