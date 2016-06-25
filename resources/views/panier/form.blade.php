                        <!-- nom -->
                        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nom" value="{{ $item->nom or old('nom') }}">

                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- nom_court -->
                        <div class="form-group{{ $errors->has('nom_court') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom court&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nom_court" value="{{ $item->nom_court or old('nom_court') }}">

                                @if ($errors->has('nom_court'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom_court') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- famille -->
                        <div class="form-group{{ $errors->has('famille') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Famille</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="famille" value="{{ $item->famille or old('famille') }}">

                                @if ($errors->has('famille'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('famille') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- type -->
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Type</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="type" value="{{ $item->type or old('type') }}">

                                @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <!-- prix_commun -->
                        <div class="form-group{{ $errors->has('prix_commun') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Prix (commun)&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="prix_commun" value="{{ $item->prix_commun or old('prix_commun') }}">

                                @if ($errors->has('prix_commun'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prix_commun') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- idee -->
                        <div class="form-group{{ $errors->has('idee') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Idée</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="idee" value="{{ $item->idee or old('idee') }}">

                                @if ($errors->has('idee'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('idee') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- remarques -->
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

