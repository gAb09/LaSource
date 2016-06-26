    <div class="container-fluid col-md-12 footercontainer">
        <div class="col-md-4 footer1">
            @section('footer1')
            Association La Source<br />
            {{$lasource->tel}}<br />
            {{Html::linkAction('ContactController@ContactLS', 'Contacter La Source par courriel')}}
            @show
        </div>
        <div class="col-md-4 footer2">
            @section('footer2')
            {{ trans('divers.version') }}
            @show
        </div>
        <div class="col-md-4 footer3">
            @section('footer3')
            Pour tout problème relatif <br />
            à l'inscription, la connexion ou un message d’erreur :<br />
            {{Html::linkAction('ContactController@ContactOM', 'Contacter le Ouaibmaistre par courriel')}}
            @show
        </div>
    </div> 
