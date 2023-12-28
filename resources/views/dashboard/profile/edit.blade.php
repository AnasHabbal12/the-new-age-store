@extends('layout.dashboard')
@section('title','Edit Profile')

@section('breadcrumb')
<li class="breadcrumb-item active">profile</li>
<li class="breadcrumb-item active">Edit Profile</li>
@parent
@endsection

@section('content')
    

    <x-alert type="success"/>
    <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="first_name" lable="First Name" :value="$user->profile->first_name"/>
            </div>
            <div class="col-md-6">
                <x-form.input name="last_name" lable="Last Name" :value="$user->profile->last_name"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="birthday" lable="Birth Day" type="date" 
                :value="$user->profile->birthday"/>
            </div>
            <div class="col-md-6">
                <x-form.radio name="gender" lable="Last Name" :options="['male'=> 'Male',
                 'female' => 'Female']" :checked="$user->profile->gender"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <x-form.input name="street_address" lable="Street Address" 
                :value="$user->profile->street_address"/>
            </div>
            <div class="col-md-4">
                <x-form.input name="city" lable="City" :value="$user->profile->city"/>
            </div>
            <div class="col-md-4">
                <x-form.input name="state" lable="State" :value="$user->profile->state"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <x-form.input name="postal_code" lable="Postal Code"
                 :value="$user->profile->postal_code"/>
            </div>
            <div class="col-md-4">
                
                <x-form.select name="country" lable="Country" :options="$countries" 
                :selected="$user->profile->country"/>
            </div>
            <div class="col-md-4">
                <x-form.select name="local" lable="Local" :options="$locales" :selected="$user->profile->local"/>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
