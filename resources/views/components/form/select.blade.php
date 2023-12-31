@props([
    'name' => '', 'options' => $options , 'selected' => $selected , 'lable' => $lable
])
<label>{{ $lable}} </label>

<select name="{{ $name }}"
{{ $attributes->class
([
    'form-control', 
    'form-select', 
    'is-invalid' => $errors->has($name)
])}}

>
@foreach ($options as $value => $text )
    <option value="{{$value}}" @selected($value == $selected) >{{$text}}</option>
@endforeach
</select>
<x.form.validation-fedback :name="$name"/>