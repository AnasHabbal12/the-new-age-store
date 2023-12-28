@props( [
    'name', 'type'=> 'text', 'value' => '' , 'lable' => false , 'class' => '', 'placeholder' => false
])
@if ($lable)
<label>{{ $lable }}</label>
@endif

<input 
@if($placeholder) placeholder="{{$placeholder}}" @endif
  type="{{ $type }}" name="{{ $name }}" class="form-control {{ $class }} 
  @error($name) is-invalid @enderror" 
  value="{{ old($name,$value) }}">

@if($errors->has($name))
<div class="text-danger">
    {{ $errors->first($name) }}
</div>
@endif