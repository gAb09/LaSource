<?php

namespace App\Domaines;


trait ActivableDomaineTrait
{
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function active($id)
    {
        try{
          $this->model = $this->model->withTrashed()->findOrFail($id);

          $this->model->is_actived = 1;

          $this->model->save();

        }catch(\Exception $e){ // ToDo revoir si gestion erreur ok
            $message = trans('message.activation.activeFailed', ['model' => $this->getDomaineName()] ).trans('message.bug.transmis');
            // $this->alertOuaibMaistre($e);
            $reponse = ['statut' => false, 'txt' => '<div class="alert alert-danger">'.$message.'</div>'];
            return $reponse;
        }

        $message = trans('message.activation.activeOk', ['model' => $this->getDomaineName()] );
        $reponse = ['statut' => true, 'txt' => '<div class="alert alert-success">'.$message.'</div>'];
        return $reponse;
    }




    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function desactive($id)
    {
        try{
            $this->model = $this->model->withTrashed()->findOrFail($id);

            $this->model->is_actived = 0;

            /* Vérification si liaison directe ou indirecte ? */
            $relation_type = $this->getVerificationType();

            /* Désactivation possible ? */
            if ($this->{$relation_type}('Désactivation')) {
                $reponse = ['statut' => false, 'txt' => '<div class="alert alert-danger">'.$this->message.'</div>'];
                return $reponse;
            }


            $this->model->save();

		} catch(\Exception $e){ // ToDo revoir si gestion erreur ok
			$message = trans('message.activation.desactiveFailed', ['model' => $this->getDomaineName()] ).trans('message.bug.transmis');
			// $this->alertOuaibMaistre($e);
			$reponse = ['statut' => false, 'txt' => '<div class="alert alert-danger">'.$message.'</div>'];
			return $reponse;
		}

		$message = trans('message.activation.desactiveOk', ['model' => $this->getDomaineName()] );
		$reponse = ['statut' => true, 'txt' => '<div class="alert alert-success">'.$message.'</div>'];
		return $reponse;
	}
}