<!-- nompourpaniers -->
<div class="form-group{{ $errors->has('nompourpaniers') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Nom pour Paniers&nbsp*</label>

    <div class="col-md-6">
        <input type="textarea" class="form-control" name="nompourpaniers" value="{{ $model->nompourpaniers or old('nompourpaniers') }}">

        @if ($errors->has('nompourpaniers'))
        <span class="help-block">
            <strong>{{ $errors->first('nompourpaniers') }}</strong>
        </span>
        @endif
    </div>
</div>


<!-- exploitation -->
<div class="form-group{{ $errors->has('exploitation') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Exploitation&nbsp*</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="exploitation" value="{{ $model->exploitation or old('exploitation') }}">

        @if ($errors->has('exploitation'))
        <span class="help-block">
            <strong>{{ $errors->first('exploitation') }}</strong>
        </span>
        @endif
    </div>
</div>

<!-- nom -->
<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Nom&nbsp*</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="nom" value="{{ $model->nom or old('nom') }}">

        @if ($errors->has('nom'))
        <span class="help-block">
            <strong>{{ $errors->first('nom') }}</strong>
        </span>
        @endif
    </div>
</div>

<!-- prenom -->
<div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Prénom&nbsp*</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="prenom" value="{{ $model->prenom or old('prenom') }}">

        @if ($errors->has('prenom'))
        <span class="help-block">
            <strong>{{ $errors->first('prenom') }}</strong>
        </span>
        @endif
    </div>
</div>

<!-- ad1 -->
<div class="form-group{{ $errors->has('ad1') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Adresse</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="ad1" value="{{ $model->ad1 or old('ad1') }}">

        @if ($errors->has('ad1'))
        <span class="help-block">
            <strong>{{ $errors->first('ad1') }}</strong>
        </span>
        @endif
    </div>
</div>

<!-- ad2 -->
<div class="form-group{{ $errors->has('ad2') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Adresse (suite)</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="ad2" value="{{ $model->ad2 or old('ad2') }}">

        @if ($errors->has('ad2'))
        <span class="help-block">
            <strong>{{ $errors->first('ad2') }}</strong>
        </span>
        @endif
    </div>
</div>

<!-- cp -->
<div class="form-group{{ $errors->has('cp') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Code postal</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="cp" value="{{ $model->cp or old('cp') }}">

        @if ($errors->has('cp'))
        <span class="help-block">
            <strong>{{ $errors->first('cp') }}</strong>
        </span>
        @endif
    </div>
</div>

<!-- ville -->
<div class="form-group{{ $errors->has('ville') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Ville</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="ville" value="{{ $model->ville or old('ville') }}">

        @if ($errors->has('ville'))
        <span class="help-block">
            <strong>{{ $errors->first('ville') }}</strong>
        </span>
        @endif
    </div>
</div>


<!-- tel -->
<?php $tel = $model->cleanTel($model->tel); $old_tel = $model->cleanTel(old('tel')); ?>
<div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Téléphone&nbsp*</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="tel" value="{{ $tel or $old_tel }}">

        @if ($errors->has('tel'))
        <span class="help-block">
            <strong>{{ $errors->first('tel') }}</strong>
        </span>
        @endif
    </div>
</div>


<!-- Mobile -->
<?php $mobile = $model->cleanTel($model->mobile); $old_mobile = $model->cleanTel(old('mobile')); ?>
<div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Mobile</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="mobile" value="{{ $mobile or $old_mobile }}">

        @if ($errors->has('mobile'))
        <span class="help-block">
            <strong>{{ $errors->first('mobile') }}</strong>
        </span>
        @endif
    </div>
</div>


<!-- email -->
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Courriel&nbsp*</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="email" value="{{ $model->email or old('email') }}">

        @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>
</div>


<!-- remarques -->
<div class="form-group{{ $errors->has('remarques') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Remarques</label>

    <div class="col-md-6">
        <textarea class="form-control remarques" name="remarques">{!! $model->remarques or old('remarques') !!}</textarea>

        @if ($errors->has('remarques'))
        <span class="help-block">
            <strong>{{ $errors->first('remarques') }}</strong>
        </span>
        @endif
    </div>
</div>

<!-- rang (pour conservation de celui-ci lors de  l'update) -->
        <input type="text" class="hidden " name="rang" value="{{ $model->rang or old('rang') }}">
