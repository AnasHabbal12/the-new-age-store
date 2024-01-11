<div class="form-group">
    <x-form.input name="name" value="{{ $user->name }}" type="text" lable="User Name"/>
</div>

<fieldset>
    <legend>{{__('Users')}}</legend>
        <div class="mb-2">

            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="{{$user->name}}"/>
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="text" name="{{$user->email}}" />
            </div>

            <div class="mb-4">
                <label>User</label>
                <input type="check" name="{{$user->email}}" />
            </div>
        </div>

</fieldset>

<div class="form-group">
    <Button type="submit" class="btn btn-primary">{{ $btn_lbl }}</Button>
</div>
