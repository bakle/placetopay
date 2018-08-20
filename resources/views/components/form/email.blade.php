<div class="form-group {{ $col_size }}">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    {{ Form::email($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
    @if($errors->has($name))
        <span class="text-danger">{{ $errors->first($name) }}</span>
    @endif
</div>