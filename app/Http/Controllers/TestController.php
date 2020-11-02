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

use Mail;

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


    public function testmail()
    {
      $datas = ['nom' => env('APP_ENV')];
      $param['to'] = 'paniers@viandes-bio-ariege.fr';
      $param['subject'] = 'Confirmation d’inscription : '.$datas['nom'];

      $vue = 'layouts.testmail';
      $vue =  'auth.transfert.emails.Ouaibmaistre';

      // try{
      $result = Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
      	$m->to($param['to']);
        $m->cc('brunogabiot@club-internet.fr');
      	$m->subject($param['subject']);
      });
      // }catch (Exception $e){
      // 	dd($e);
      // }

        return view($vue)->with(compact('datas', 'result', 'param'));
    }

    public function main()
    {
        $datas = 'TEST';

        return view('layouts.test')->with(compact('datas'));
    }

}
