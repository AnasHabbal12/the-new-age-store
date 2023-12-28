@props([
    'name' => '' , 'checked' => false , 'options' => ''
])

@foreach ($options as $value => $text )
    
<div class="custom-control custom-radio">
<input type="radio" name="{{$name}}" value="{{ $value }}" class="form-check-input" 
@checked(old($name, $checked) == $value )/>
<label class="custom-control-label" >{{ $text }}</label>
</div>
@endforeach