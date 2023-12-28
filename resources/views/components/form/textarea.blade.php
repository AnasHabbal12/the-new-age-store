@props([
    'name' => '', 'value' => '' , 'lable' => '', 
])

<label>{{ $lable }}</label>
<textarea name="{{ $name }}" class="form-control" value="{{ old($name,$value) }}"></textarea>