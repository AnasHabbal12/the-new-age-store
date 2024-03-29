<div class="form-group">
    <x-form.input name="name" value="{{ $admin->name }}" type="text" lable="Role Name"/>
</div>

<fieldset>
    <legend>{{__('Admins')}}</legend>
        <div class="mb-2">

            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="{{$admin->name}}"/>
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="text" name="{{$admin->email}}" />
            </div>

            <div class="mb-4">
                <label>Role</label>
                <input type="check" name="{{$admin->email}}" />
            </div>
        </div>

</fieldset>

<div class="form-group">
    <Button type="submit" class="btn btn-primary">{{ $btn_lbl }}</Button>
</div>
