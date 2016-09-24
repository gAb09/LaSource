                        <!-- id -->
                                <input type="hidden" name="id" value="{{ $model->id or old('id') }}">

                        <!-- nom -->
                        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom complet&nbsp*</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nom" value="{!! $model->nom or old('nom') !!}">

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
                                <textarea class="form-control remarques" name="remarques">{!! $model->remarques or old('remarques') !!}</textarea>

                                @if ($errors->has('remarques'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('remarques') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- is_actived -->
                        <div id="" class="form-group toggle_actived {{$model->class_actif}}">
                            <label class="col-md-4 control-label">Activé</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-control" style="width:16px" name="is_actived" onChange="javascript:handleIsActivedClass();" 
                                @if($model->is_actived or old('is_actived'))
                                checked="checked" 
                                @endif
                                value="{{ $model->is_actived or old('is_actived') }}">
                            </div>
                        </div>