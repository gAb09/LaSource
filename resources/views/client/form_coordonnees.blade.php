                        <!-- PRENOM -->
                        <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Prenom *</label>

                            <div class="col-md-6">
                                <input type="prenom" class="form-control" name="prenom" value="{{ $user->client->prenom or old('prenom') }}">

                                @if ($errors->has('prenom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prenom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- NOM -->
                        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom *</label>

                            <div class="col-md-6">
                                <input type="nom" class="form-control" name="nom" value="{{ $user->client->nom or old('nom') }}">

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
                                <input type="ad1" class="form-control" name="ad1" value="{{ $user->client->ad1 or old('ad1') }}">

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
                                <input type="ad2" class="form-control" name="ad2" value="{{ $user->client->ad2 or old('ad2') }}">

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
                                <input type="cp" class="form-control" name="cp" value="{{ $user->client->cp or old('cp') }}">

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
                                <input type="ville" class="form-control" name="ville" value="{{ $user->client->ville or old('ville') }}">

                                @if ($errors->has('ville'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ville') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- TELEPHONE -->
                        <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Téléphone *</label>

                            <div class="col-md-6">
                                <input type="telephone" class="form-control" name="telephone" value="{{ $user->client->telephone or old('telephone') }}">

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
                                <input type="mobile" class="form-control" name="mobile" value="{{ $user->client->mobile or old('mobile') }}">

                                @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- MAIL -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Adresse Mail *</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $user->email or old('email') }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
