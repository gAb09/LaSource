                        <!-- nom -->
                        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nom *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nom" value="{{ $model->nom or old('nom') }}">

                                @if ($errors->has('nom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- retrait -->
                        <div class="form-group{{ $errors->has('retrait') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Retrait des colis *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="retrait" value="{{ $model->retrait or old('retrait') }}">

                                @if ($errors->has('retrait'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('retrait') }}</strong>
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
                            <label class="col-md-4 control-label">Téléphone *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="tel" value="{{ $tel or $old_tel }}">

                                @if ($errors->has('tel'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tel') }}</strong>
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


                        <!-- ouvertures -->
                        <div class="form-group{{ $errors->has('ouvertures') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Ouvertures</label>

                            <div class="col-md-6">
                                <input type="textarea" class="form-control" name="ouvertures" value="{{ $model->ouvertures or old('ouvertures') }}">

                                @if ($errors->has('ouvertures'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ouvertures') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <!-- is_actived -->
                        @include('shared.actived')

                        <!-- remarques -->
                        <div class="form-group{{ $errors->has('remarques') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Remarques</label>

                            <div class="col-md-6">
                                <input type="textarea" class="form-control remarques" name="remarques" value="{{ $model->remarques or old('remarques') }}">

                                @if ($errors->has('remarques'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('remarques') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

