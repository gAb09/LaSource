                        <!-- id -->
                                <input type="hidden" name="id" value="{{ $item->id or old('id') }}">

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


                        <!-- nom -->
                        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom complet&nbsp*</label>

                            <div class="col-md-6">
                                <textarea rows="3" cols="50" class="" name="nom">{!! $item->nom or old('nom') !!}</textarea>

                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
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
                                <textarea rows="5" cols="50" class="" name="idee">{!! $item->idee or old('idee') !!}</textarea>

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
                        <div id="is_actif" class="form-group {{$item->class_actif}}">
                            <label class="col-md-4 control-label">Actif</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-control" name="is_actif" onChange="javascript:handleIsActifClass();" 
                                @if($item->is_actif or old('is_actif'))
                                checked="checked" 
                                @endif
                                value="{{ $item->is_actif or old('is_actif') }}">
                            </div>
                        </div>

                        <!-- rang -->
                        <div class="form-group{{ $errors->has('rang') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Rang</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="rang" value="{{ $item->rang or old('rang') }}">

                                @if ($errors->has('rang'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rang') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

