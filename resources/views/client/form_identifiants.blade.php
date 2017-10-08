                        <!-- PSEUDO -->
                        <div class="form-group{{ $errors->has('pseudo') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Pseudo *</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="pseudo" value="{{ old('pseudo', $model->pseudo) }}">

                                @if ($errors->has('pseudo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pseudo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- OLD PASSWORD -->
                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Ancien mot de passe *</label>

                            <div class="col-md-6">
                                <input type="" class="form-control" name="old_password" value="{{ old('old_password', 'Implémenter contrôle') }}">

                                @if ($errors->has('old_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nouveau mot de passe *</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- PASSWORD CONFIRMATION -->
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirmation du mot de passe *</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

