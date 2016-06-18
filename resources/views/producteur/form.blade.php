                        <!-- exploitation -->
                        <div class="form-group{{ $errors->has('exploitation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Exploitation *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="exploitation" value="{{ $item->exploitation or old('exploitation') }}">

                                @if ($errors->has('exploitation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('exploitation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- nom -->
                        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nom" value="{{ $item->nom or old('nom') }}">

                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- prenom -->
                        <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Prénom *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="prenom" value="{{ $item->prenom or old('prenom') }}">

                                @if ($errors->has('prenom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prenom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- ADRESSE 1 -->
                        <div class="form-group{{ $errors->has('ad1') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Adresse</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ad1" value="{{ $item->ad1 or old('ad1') }}">

                                @if ($errors->has('ad1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ad1') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- ADRESSE 2 -->
                        <div class="form-group{{ $errors->has('ad2') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Adresse (suite)</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ad2" value="{{ $item->ad2 or old('ad2') }}">

                                @if ($errors->has('ad2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ad2') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- CODE POSTAL -->
                        <div class="form-group{{ $errors->has('cp') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Code postal</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cp" value="{{ $item->cp or old('cp') }}">

                                @if ($errors->has('cp'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cp') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- VILLE -->
                        <div class="form-group{{ $errors->has('ville') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Ville</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ville" value="{{ $item->ville or old('ville') }}">

                                @if ($errors->has('ville'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ville') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <!-- TELEPHONE -->
                        <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Téléphone *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="tel" value="{{ $item->tel or old('tel') }}">

                                @if ($errors->has('tel'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tel') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <!-- Mobile -->
                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Mobile *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="mobile" value="{{ $item->mobile or old('mobile') }}">

                                @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <!-- MAIL -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Courriel</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{ $item->email or old('email') }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <!-- paniers -->
                        <div class="form-group{{ $errors->has('nompourpaniers') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom pour Paniers</label>

                            <div class="col-md-6">
                                <input type="textarea" class="form-control" name="nompourpaniers" value="{{ $item->nompourpaniers or old('nompourpaniers') }}">

                                @if ($errors->has('nompourpaniers'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nompourpaniers') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <!-- REMARQUES -->
                        <div class="form-group{{ $errors->has('remarques') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Remarques</label>

                            <div class="col-md-6">
                                <input type="textarea" class="form-control" name="remarques" value="{{ $item->remarques or old('remarques') }}">

                                @if ($errors->has('remarques'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('remarques') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- is_actif -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Actif</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-control" name="is_actif" 
                                @if($item->is_actif or old('is_actif'))
                                checked="checked" 
                                @endif
                                value="{{ $item->is_actif or old('is_actif') }}">
                            </div>
                        </div>

