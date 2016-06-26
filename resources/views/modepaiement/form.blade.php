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

