<!-- fermable_type -->
        <input type="hidden" name="fermable_type" value="{{ $fermable_type or old('fermable_type') }}">

<!-- fermable_id -->
        <input type="hidden" name="fermable_id" value="{{ $fermable_id or old('fermable_id') }}">


<!-- date_debut -->
    @if ($errors->has('date_debut'))
        <div id="div_date_debut" class="datecontainer error_txt">
            <p style="text-align:center">
                <b>{{ $errors->first('date_debut') }}</b>
    @else
        <div id="div_date_debut" class="datecontainer">
            <p style="text-align:center"><b>Date de début&nbsp*</b>
    @endif
            <input type="hidden" id="date_debut" name="date_debut" value="{{ old('date_debut', $fermeture->date_debut) }}">
        </p>
            <input type="text" id="datepicker_debut" name="datepicker_debut" value="{{ old('datepicker_debut', '???') }}">
        </div>




<!-- date_fin -->
    @if ($errors->has('date_fin'))
        <div id="div_date_fin" class="datecontainer error_txt">
            <p style="text-align:center">
                <b>{{ $errors->first('date_fin') }}</b>
    @else
        <div id="div_date_fin" class="datecontainer">
            <p style="text-align:center"><b>Date de fin&nbsp*</b>
    @endif
        <br />
            <input type="hidden" id="date_fin" name="date_fin" value="{{ old('date_fin', $fermeture->date_fin) }}">
        </p>
            <input type="text" id="datepicker_fin" name="datepicker_fin" value="">
        </div>


<!-- Cause -->
<div class="form-group{{ $errors->has('cause') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Cause&nbsp*</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="cause" value="{{ $fermeture->pivot->cause or old('cause') }}">

        @if ($errors->has('cause'))
        <span class="help-block">
            <strong>{{ $errors->first('cause') }}</strong>
        </span>
        @endif
    </div>
</div>



<!-- remarques -->
<div class="form-group{{ $errors->has('remarques') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Remarques</label>

    <div class="col-md-6">
        <textarea class="form-control remarques" name="remarques">{!! $fermeture->remarques or old('remarques') !!}</textarea>

        @if ($errors->has('remarques'))
        <span class="help-block">
            <strong>{{ $errors->first('remarques') }}</strong>
        </span>
        @endif
    </div>
</div>

@section('script')
@parent
<script src="/js/fermeture.js"></script>
@stop