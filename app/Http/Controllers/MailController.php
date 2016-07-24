<?php

namespace App\Http\Controllers;

use App\Domaines\MailDomaine as Domaine;

use Illuminate\Http\Request;
use App\Http\Requests;

class MailController extends Controller
{
    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function Livraisons()
    {
    	return $this->domaine->Livraisons();
    }



}