@if($errors->any())
    <div class="alert alert-danger">
        <h4>Errors</h4>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div>
@endif

<div class="form-group">
    <x-form.input name="name" value="{{ $category->name }}" type="text" lable="Category Name"/>
</div>
<div class="form-group">
    <label>Category Parent</label>
    <select type="text" name="parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach ( $parents as $parent )
        <option value="{{ $parent->id }}" @selected((old('parent_id') ?? $category->parent_id) == $parent->id)>{{ $parent->name }}</option> 
        @endforeach
    </select>
    @if($errors->has('parent_id'))
    <div class="text-danger">
       {{ $errors->first('parent_id') }}
    </div>
    @endif
</div>
<div class="form-group">
    <x-form.textarea name="description" lable="Category Description" value="{{ $category->description }}"/>
</div>
<div class="form-group">
    <label>Category Status</label>
   
        <x-form.radio name="status" :checked="$category->status" :options="['active'=>'Active', 'archived' => 'Archived']"/> 
    
    
      @if($errors->has('status'))
      <div class="text-danger">
         {{ $errors->first('status') }}
      </div>
      @endif
</div>
<div class="form-group">
    @if($category->img)
    <img src="{{ asset('storage/'.$category->img ) }}" alt="there is no image" width="100%">
    @endif
    <label>Category Image</label>
    <input type="file" name="img" class="form-control" accept="image/*">
    @if($errors->has('img'))
      <div class="text-danger">
         {{ $errors->first('img') }}
      </div>
      @endif
</div>
<div class="form-group">
    <Button type="submit" class="btn btn-primary">{{ $btn_lbl }}</Button>
</div>