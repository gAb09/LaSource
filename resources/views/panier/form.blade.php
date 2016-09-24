                        <!-- id -->
                                <input type="hidden" name="id" value="{{ $model->id or old('id') }}">

                        <!-- type -->
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Type</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="type" value="{{ $model->type or old('type') }}">

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
                                <input type="text" class="form-control" name="nom_court" value="{{ $model->nom_court or old('nom_court') }}">

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
                                <textarea class="form-control" name="nom">{!! $model->nom or old('nom') !!}</textarea>

                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- prix_base -->
                        <div class="form-group{{ $errors->has('prix_base') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Prix base&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="prix_base" value="{{ $model->prix_base or old('prix_base') }}">

                                @if ($errors->has('prix_base'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('prix_base') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- idee -->
                        <div class="form-group {{ $errors->has('idee') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Idée</label>

                            <div class="col-md-6">
                                <textarea class="form-control idee" name="idee">{!! $model->idee or old('idee') !!}</textarea>

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
                                <textarea class="form-control remarques" name="remarques">{!! $model->remarques or old('remarques') !!}</textarea>

                                @if ($errors->has('remarques'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('remarques') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- is_actived -->
                        <div id="" class="form-group toggle_actived {{$model->class_actived}}">
                            <label class="col-md-4 control-label">Activé</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-control" style="width:16px" name="is_actived" onChange="javascript:handleIsActivedClass();" 
                                @if($model->is_actived or old('is_actived'))
                                checked="checked" 
                                @endif
                                value="{{ $model->is_actived or old('is_actived') }}">
                            </div>
                        </div>