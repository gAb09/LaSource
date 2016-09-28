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
        $this->domaine->keepUrlDepart();

        $model = $this->domaine->addIndisponibilite($indisponible_type, $indisponible_id);

        $titre_page = $this->domaine->getTitrePage();

        return view('indisponibilite.create')->with(compact('model', 'titre_page'));
    }



    public function store(IndisponibiliteRequest $request)
    {
        $this->domaine->keepIndispo();

        /* store failed */
        if (!$this->domaine->store($request)) {
            return redirect()->back()->with( 'status', $this->domaine->getMessage() );

            /* des livraisons sont restreintes */
        }elseif ( 
           $this->domaine->checkIfLivraisonsRestricted($request->get('date_debut'), $request->get('date_fin')) 
           ) {

            try{
                $datas = $this->domaine->handleLivraisonAffected();
            } catch (IndispoControleLivraisonException $e){
                return redirect()->back()->with('status', $e->getMessage());
            }

            \Session::flash('success', $this->domaine->getMessage());
            return view('livraison.handleIndisponibilityChange')
            ->with(compact('datas'))
            ->with( 'titre_page', $this->domaine->getTitrePage() )
            ;

            /* Aucune livraison concernée */
        }else{
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', $this->domaine->getMessage() );
        }
    }



    public function edit($id)
    {
        $model = $this->domaine->edit($id);
        $this->domaine->keepUrlDepart();
        $titre_page = trans('titrepage.indisponibilite.edit', ['nom' => $model->indisponible_nom]);

        return view('indisponibilite.edit')->with(compact('model', 'titre_page'));
    }



    public function update($id, IndisponibiliteRequest $request)
    {
        if($this->domaine->update($id, $request)){
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', trans('message.indisponibilite.updateOk') );
        }
        return redirect()->back()->with( 'status', trans('message.indisponibilite.updatefailed').trans('message.bug.transmis') );
    }



    /**
    * Avant de supprimer une indisponibilité, il faut s'enquérir des conséquences possibles sur les livraisons.
    *
    * @param integer $indispo_id
    * @return Redirection
    **/
    public function destroy($indispo_id)
    {     
        $indisponibilite = $this->domaine->findFirstWithoutTrashed($indispo_id);

        $this->domaine->keepUrlDepart();
        $this->domaine->keepIndispo();

        /* destroy failed */
        if(!$this->domaine->destroy($indispo_id)){
            return redirect()->back()->with('status', trans('message.indisponibilite.deletefailed'));

            /* des livraisons sont étendues */
        }elseif ( 
           $this->domaine->checkIfLivraisonsExtended($indisponibilite->date_debut, $indisponibilite->date_fin) 
           ) {

            try{
                $datas = $this->domaine->handleLivraisonAffected();
            } catch (IndispoControleLivraisonException $e){
                return redirect()->back()->with('status', $e->getMessage());
            }

            \Session::flash('success', $this->domaine->getMessage());
            return view('livraison.handleIndisponibilityChange')
            ->with(compact('datas'))
            ->with( 'titre_page', $this->domaine->getTitrePage() )
            ;

            /* Aucune livraison concernée, destroy simple */
        }else{
            $url_depart = $this->getUrlDepart();
            return redirect($url_depart)->with( 'success', $this->domaine->getMessage() );
        }
    }



    public function handleLivraisonChanges(Request $request)
    {
        $livraisons = array();
        foreach ($request->get('livraison_id') as $key => $value) {
            if ($value == 'attach') {
                $livraisons['toattach'][] = $key;
            }
            if ($value == 'detach') {
                $livraisons['todetach'][] = $key;
            }
            if ($value == 'reported') {
                $livraisons['toreport'][] = $key;
            }
        }
        return dd($livraisons);
    }
}