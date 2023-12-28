<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit() {

        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames('en'),
            'locales' => Languages::getNames('en'),
        ]);

    }

    public function update(Request $request) {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string'],
        ]);
        $user = $request->user();

        //$profile = $user->profile;
        // we used user_id becaut it empty and retun null only when has no relation 
        // if($profile->first_name) {
        //     $profile->update($request->all());
        // } else {
        //     // $request->merge([
        //     //     'user_id' => $user->id,
        //     // ]);
        //     // Profile::create($request->all());
        //     $user->profile->create($request->all());
        // }
        //$user->profile->update($request->all()); // it works but it may causes exeption because in som cases it'll be empty and return null
        $user->profile->fill($request->all())->save();
        return redirect()->route('dashboard.profile.edit')->with('success', 'profile has been updated!');
    }
}
