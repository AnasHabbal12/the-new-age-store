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
    <x-form.input name="name" :value="$product->name" type="text" lable="Product Name"/>
</div>
<div class="form-group">
    <x-form.input name="price" :value="$product->price" type="text" lable="Product Price"/>
</div>
<div class="form-group">
    <x-form.input name="compare_price" :value="$product->compare_price" type="text" lable="Compare Price"/>
</div>
<div class="form-group">
    <x-form.input name="tag" :value="$tags" type="text" lable="Tags"/>
</div>

<div class="form-group">
    <label>Product Category</label>
    <select type="text" name="category_id" class="form-control form-select">
        <option value="">Primary Product</option>
        @foreach ( App\Models\Category::all() as $parent )
        <option value="{{ $parent->id }}" >{{ $parent->name }} @selected(old('category_id',$parent->category_id))</option> 
        @endforeach
    </select>
    @if($errors->has('category_id'))
    <div class="text-danger">
       {{ $errors->first('category_id') }}
    </div>
    @endif
</div>
<div class="form-group">
    <x-form.textarea name="description" lable="Category Description" value=""/>
</div>
<div class="form-group">
    <label>Category Status</label>
   
        <x-form.radio name="status" checked="" :options="['active'=>'Active', 'archived' => 'Archived']"/> 
    
    
      @if($errors->has('status'))
      <div class="text-danger">
         {{ $errors->first('status') }}
      </div>
      @endif
</div>
<div class="form-group">
    @if($product->img)
    <img src="{{ asset('storage/'.$product->img ) }}" alt="there is no image" width="100%"/>
    @endif
    <label>Category Image</label>
    <input type="file" name="img" class="form-control" accept="image/*"/>
    @if($errors->has('img'))
      <div class="text-danger">
         {{ $errors->first('img') }}
      </div>
      @endif
</div>
<div class="form-group">
    <Button type="submit" class="btn btn-primary">{{ $btn_lbl }}</Button>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
    var inputElm = document.querySelector('[name=tag]'),
    tagify = new Tagify(inputElm);
</script>
@endpush