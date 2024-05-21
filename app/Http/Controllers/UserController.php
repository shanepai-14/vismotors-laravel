<?php

namespace App\Http\Controllers;

use App\Models\Citizenship;
use App\Models\CivilStatus;
use App\Models\Occupation;
use App\Models\User;
use App\Models\Gender;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('layouts.setup.user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        $gender = Gender::all();
        $civilStatus = CivilStatus::all();
        $citizenship = Citizenship::all();
        $occupation = Occupation::all();
         
        return view('layouts.setup.user.create', [
            'roles' => $roles,
            'gender'=> $gender,
            'civilStatus' => $civilStatus,
            'citizenship' => $citizenship,
            'occupation' => $occupation,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('user.create')->with('error', 'Error on adding new user.');
        } {
            DB::commit();
            $user->syncRoles('member');
            $user_profile = UserProfile::create([
                 'user_id' => $user->id,
                 'gender_id' => $request->gender_id,
                 'civil_status_id' => $request->civil_status_id,
                 'citizenship_id' => $request->citizenship_id,
                 'occupation_id' => $request->occupation_id,
                 'address' => $request->address,
                 'fathers_name' => $request->fathers_name,
                 'mothers_name' => $request->mothers_name,
                 'phone_no' => $request->phone_no, 
                 'longitude' => $request->longitude,
                 'latitude' => $request->latitude,
                 'date_of_birth' => $request->date_of_birth,
                 'valid_one' => $request->valid_one_temp,
                 'valid_two' => $request->valid_two_temp,
                 'profile_picture' => $request->profile_temp,
                'address_landmark' => $request->address_landmark,
                'address_lot' => $request->address_lot,
                'address_brgy' => $request->address_brgy,
                'address_city' => $request->address_city,
                'address_prov' => $request->address_prov
            ]);
            return redirect()->route('user.index')->with('success', 'New user has been added successfully.');
        };
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $arr = array();
        foreach ($user->roles as $role) {
            $arr[] = $role->id;
        }
        $gender = Gender::all();
        $roles = Role::all();
        $civilStatus = CivilStatus::all();
        $citizenship = Citizenship::all();
        $occupation = Occupation::all();
        return view('layouts.setup.user.create', [
            'roles' => $roles,
            'user' => $user,
            'arr' => $arr,
            'gender' => $gender,
            'civilStatus' => $civilStatus,
            'citizenship' => $citizenship,
            'occupation' => $occupation,
        ]);
    }

    // public function update(Request $request, User $user)
    // {
    //     $request->validate([
    //         'first_name' => ['required', 'string', 'max:255'],
    //         'middle_name' => ['nullable', 'string', 'max:255'],
    //         'last_name' => ['required', 'string', 'max:255'],
    //         'username' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255']
    //     ]);

    //     try {
    //         $user->update($request->all());

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('user.edit', ['user' => $user->id])->with('error', $e);
    //     } {
    //         DB::commit();
    //         $user->syncRoles($request->role);
    //         $user_profile = UserProfile::update([
    //             'gender_id' => $request->gender_id,
    //             'civil_status_id' => $request->civil_status_id,
    //             'citizenship_id' => $request->citizenship_id,
    //             'occupation_id' => $request->occupation_id,
    //             'address' => $request->address,
    //             'fathers_name' => $request->fathers_name,
    //             'mothers_name' => $request->mothers_name,
    //             'phone_no' => $request->phone_no, 
    //             'longitude' => $request->longitude,
    //             'latitude' => $request->latitude,
    //             'date_of_birth' => $request->date_of_birth,
    //             'valid_one' => $request->valid_one_temp,
    //             'valid_two' => $request->valid_two_temp,
    //             'profile_picture' => $request->profile_temp,
    //            'address_landmark' => $request->address_landmark,
    //            'address_lot' => $request->address_lot,
    //            'address_brgy' => $request->address_brgy,
    //            'address_city' => $request->address_city,
    //            'address_prov' => $request->address_prov
    //        ]);
    //         return redirect()->route('user.index')->with('edit', 'User updated successfully');
    //     };
    // }
    public function update(Request $request, User $user)
    {
  
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // Add other validations as necessary
        ]);
    
        DB::beginTransaction();
        
        try {
            // Update user data
            $user->update($request->all());
    
            // Assuming User has one UserProfile
            $user_profile = $user->profile; // or $user->userProfile depending on your relationship name
    
            // Update user profile data
            if ($user_profile) {
                $user_profile->update([
                    'gender_id' => $request->gender_id,
                    'civil_status_id' => $request->civil_status_id,
                    'citizenship_id' => $request->citizenship_id,
                    'occupation_id' => $request->occupation_id,
                    'address' => $request->address,
                    'fathers_name' => $request->fathers_name,
                    'mothers_name' => $request->mothers_name,
                    'phone_no' => $request->phone_no, 
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'date_of_birth' => $request->date_of_birth,
                    'valid_one' => $request->valid_one_temp,
                    'valid_two' => $request->valid_two_temp,
                    'profile_picture' => $request->profile_temp,
                    'address_landmark' => $request->address_landmark,
                    'address_lot' => $request->address_lot,
                    'address_brgy' => $request->address_brgy,
                    'address_city' => $request->address_city,
                    'address_prov' => $request->address_prov,
                ]);
            } 
    
            // Commit the transaction
            DB::commit();
    
    
            return redirect()->route('user.index')->with('edit', 'User updated successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if there is an error
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('user.edit', ['user' => $user->id])->with('error', $e->getMessage());
        }
    }
    public function destroy(User $user)
    {
        //
    }
}
