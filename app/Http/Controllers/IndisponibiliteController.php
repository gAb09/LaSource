<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndisponibiliteRequest;
use App\Domaines\IndisponibiliteDomaine as Indisponibilite;
use App\Exceptions\IndispoControleLivraisonException;

use Illuminate\Http\Request;

class IndisponibiliteController extends Controller
{

    protected $domaine;
    private $entity;
    private $domainesPath = 'App\\Domaines\\';


    public function __construct(Indisponibilite $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $models = $this->domaine->all('date_debut');
        return dd($models->all());
        return view('indisponibilite.index')->with(compact('models'));
    }


    /**
    * Supplante la fonction create.
    * 
    * @param string $indisponisable_type
    * @param integer $indisponisable_id
    * 
    * @return View
    **/
    public function addIndisponibilite($indisponisable_type, $indisponisable_id)
    {     
        $this->keepUrlInitiale();

        $model = $this->domaine->addIndisponibilite($indisponisable_type, $indisponisable_id);

        $titre_page = $this->domaine->getTitrePage();

        return view('indisponibilite.create')->with(compact('model', 'titre_page'));
    }



    public function store(IndisponibiliteRequest $request)
    {
        if ($this->domaine->hasConcernedLivraisons($request)) {
            return $this->callFormLivraisonsConcernedHandling($request);
        }


        if ($this->domaine->store($request)) {
            return redirect($this->getUrlInitiale())->with( 'success', $this->domaine->getMessage() );
        }else{
            return redirect($this->getUrlInitiale())->with( 'success', $this->domaine->getMessage() );
        }
    }



    public function edit($id)
    {
        $model = $this->domaine->edit($id);
        $this->keepUrlInitiale();
        $titre_page = trans('titrepage.indisponibilite.edit', ['nom' => $model->indisponisable_nom]);

        return view('indisponibilite.edit')->with(compact('model', 'titre_page'));
    }



    public function update($id, IndisponibiliteRequest $request)
    {
        if ($this->domaine->hasConcernedLivraisons($request, $id)) {
            return $this->callFormLivraisonsConcernedHandling($request);
        }


        if($this->domaine->update($id, $request)){
            return redirect($this->getUrlInitiale())->with( 'success', $this->domaine->getMessage() );
        }else{
            return redirect($this->getUrlInitiale())->with( 'success', $this->domaine->getMessage() );
        }
    }



    /**
    * Avant de supprimer une indisponibilité, il faudra s'enquérir des conséquences possibles sur les livraisons.
    * C'est le domaine qui va gérer cela
    *
    * @param integer $indisponibilite_id
    * @return Redirection
    **/
    public function destroy($id, Request $request)
    {
        if ($this->domaine->hasConcernedLivraisons($request, $id)) {
            return $this->callFormLivraisonsConcernedHandling($request);
        }

        if($this->domaine->destroy($id)){
            return redirect()->back()->with( 'success', $this->domaine->getMessage() );
        }else{
            return redirect()->back()->with('status', $this->domaine->getMessage() );
        }
    }


    /**
    * Appel du formulaire de traitement des livraisons concernées.
    *
    * @return Redirection
    **/
    public function callFormLivraisonsConcernedHandling($request)
    {
        /* Conservation de la page initiale */
        $this->keepUrlInitiale();

        return  view('livraison.handleIndisponibilitiesChanges')
        ->with([
            'titre_page' => $this->domaine->getTitrePage(), 
            'restricted_livraisons' => $this->domaine->getRestrictedLivraisons(), 
            'extended_livraisons' => $this->domaine->getExtendedLivraisons(), 
            'action_for_view' => $this->domaine->action_name_for_view,
            'indisponisable' => $this->domaine->indisponisable_lied,
            ]);
    }


    /**
    * Annulation de l'action sur une indisponibilité.
    *
    * @return Redirection
    **/
    public function annulationIndisponibilityChanges()
    {
        return redirect($this->getUrlInitiale())->with( 'success', trans('message.indisponibilite.actionCancelled') );
    }



}