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
