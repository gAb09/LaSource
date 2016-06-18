                        <!-- PRENOM -->
                        <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Prenom&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="prenom" value="{{ $item->client->prenom or old('prenom') }}">

                                @if ($errors->has('prenom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prenom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- NOM -->
                        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nom" value="{{ $item->client->nom or old('nom') }}">

                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- ADRESSE 1 -->
                        <div class="form-group{{ $errors->has('ad1') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Adresse</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ad1" value="{{ $item->client->ad1 or old('ad1') }}">

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
                                <input type="text" class="form-control" name="ad2" value="{{ $item->client->ad2 or old('ad2') }}">

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
                                <input type="text" class="form-control" name="cp" value="{{ $item->client->cp or old('cp') }}">

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
                                <input type="text" class="form-control" name="ville" value="{{ $item->client->ville or old('ville') }}">

                                @if ($errors->has('ville'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ville') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- TELEPHONE -->
                        <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Téléphone&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="telephone" value="{{ $item->client->telephone or old('telephone') }}">

                                @if ($errors->has('telephone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telephone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- MOBILE -->
                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Mobile</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="mobile" value="{{ $item->client->mobile or old('mobile') }}">

                                @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- MAIL -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Adresse Mail&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{ $item->email or old('email') }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
