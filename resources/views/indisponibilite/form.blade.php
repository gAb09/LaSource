@php use Gab\Helpers\DateFr @endphp<!-- indisponisable_type -->
        <input type="hidden" name="indisponisable_type" value="{{ $model->indisponisable_type or old('indisponisable_type') }}">

<!-- indisponisable_id -->
        <input type="hidden" name="indisponisable_id" value="{{ $model->indisponisable_id or old('indisponisable_id') }}">

<!-- indisponisable_nom -->
        <input type="hidden" name="indisponisable_nom" value="{{ $model->indisponisable_nom or old('indisponisable_nom') }}">


<!-- date_debut -->
    @if ($errors->has('date_debut'))
        <div id="div_date_debut" class="datecontainer error_txt">
            <p>
                <b>{{ $errors->first('date_debut') }}</b>
    @else
        <div id="div_date_debut" class="datecontainer">
            <p style=""><b>Date de début&nbsp*</b>
    @endif
                <br /><span id="date_debut_enclair" >@date_complete($model->date_debut)</span><br />
        </p>
            <input type="hidden" id="date_debut" name="date_debut" value="{{ old('date_debut', $model->date_debut) }}">
            <input type="hidden" id="datepicker_debut" name="datepicker_debut" value="{!! old('datepicker_debut', $datedebut = DateFr::complete($model->date_debut)) !!}">
        </div>




<!-- date_fin -->
    @if ($errors->has('date_fin'))
        <div id="div_date_fin" class="datecontainer error_txt">
            <p>
                <b>{{ $errors->first('date_fin') }}</b>
    @else
        <div id="div_date_fin" class="datecontainer">
            <p style=""><b>Date de fin&nbsp*</b>
    @endif
                <br /><span id="date_fin_enclair" >@date_complete($model->date_fin)</span>
        </p>
            <input type="hidden" id="date_fin" name="date_fin" value="{{ old('date_fin', $model->date_fin) }}">
            <input type="hidden" id="datepicker_fin" name="datepicker_fin" value="{{ old('datepicker_fin', $datedebut = DateFr::complete($model->date_fin)) }}">
        </div>


<!-- Cause -->
<div class="form-group{{ $errors->has('cause') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Cause&nbsp*</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="cause" value="{{ $model->cause or old('cause') }}">

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
        <textarea class="form-control remarques" name="remarques">{!! $model->remarques or old('remarques') !!}</textarea>

        @if ($errors->has('remarques'))
        <span class="help-block">
            <strong>{{ $errors->first('remarques') }}</strong>
        </span>
        @endif
    </div>
</div>

@section('script')
@parent
<script src="/js/indisponibilite.js"></script>

<script type="text/javascript">
$('#date_debut_enclair').empty().append($('#datepicker_debut').val());
$('#date_fin_enclair').empty().append($('#datepicker_fin').val());

</script>

@endsection