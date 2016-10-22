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
    * @param string $indisponible_type
    * @param integer $indisponible_id
    * 
    * @return View
    **/
    public function addIndisponibilite($indisponible_type, $indisponible_id)
    {     
        $this->keepUrlInitiale();

        $model = $this->domaine->addIndisponibilite($indisponible_type, $indisponible_id);

        $titre_page = $this->domaine->getTitrePage();

        return view('indisponibilite.create')->with(compact('model', 'titre_page'));
    }



    public function store(IndisponibiliteRequest $request)
    {
        /* store failed */
        if (!$this->domaine->store($request)) {
            return redirect()->back()->with( 'status', $this->domaine->getMessage() );

            /* des livraisons sont restreintes */
        }elseif ( 
         $this->domaine->hasLivraisonsRestricted($request->get('date_debut'), $request->get('date_fin')) 
         ) {

            try{
                $datas = $this->domaine->handleLivraisonAffected();
            } catch (IndispoControleLivraisonException $e){
                return redirect()->back()->with('status', $e->getMessage());
            }

            \Session::flash('success', $this->domaine->getMessage());
            return view('livraison.handleIndisponibilitiesChanges')
            ->with(compact('datas'))
            ->with( 'titre_page', $this->domaine->getTitrePage() )
            ;

            /* Aucune livraison concernée */
        }else{
            $url_depart = $this->getUrlInitiale();
            return redirect($url_depart)->with( 'success', $this->domaine->getMessage() );
        }
    }



    public function edit($id)
    {
        $model = $this->domaine->edit($id);
        $this->keepUrlInitiale();
        $titre_page = trans('titrepage.indisponibilite.edit', ['nom' => $model->indisponible_nom]);

        return view('indisponibilite.edit')->with(compact('model', 'titre_page'));
    }



    public function update($id, IndisponibiliteRequest $request)
    {
        if($this->domaine->update($id, $request)){
            $url_depart = $this->getUrlInitiale();
            return redirect($url_depart)->with( 'success', trans('message.indisponibilite.updateOk') );
        }
        return redirect()->back()->with( 'status', trans('message.indisponibilite.updatefailed').trans('message.bug.transmis') );
    }



    /**
    * Avant de supprimer une indisponibilité, il faudra s'enquérir des conséquences possibles sur les livraisons.
    * C'est le domaine qui va gérer cela
    *
    * @param integer $indisponibilite_id
    * @return Redirection
    **/
    public function destroy($id)
    {
        if ($this->domaine->hasLivraisonsConcerned('destroy', $id)) {
            /* Conservation de la page initiale */
            $this->keepUrlInitiale();

            return  view('livraison.handleIndisponibilitiesChanges')
            ->with([
                'titre_page' => $this->domaine->getTitrePage(), 
                'restricted_livraisons' => $this->domaine->getRestrictedLivraisons(), 
                'extended_livraisons' => $this->domaine->getExtendedLivraisons(), 
                'action_for_view' => $this->domaine->getActionNameForView(),
                'relais' => $this->domaine->getIndisponibleLied(),
                ]);
        }

        if($this->domaine->destroy($id)){
            return redirect()->back()->with( 'success', $this->domaine->getMessage() );
        }else{
            return redirect()->back()->with('status', $this->domaine->getMessage() );
        }
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