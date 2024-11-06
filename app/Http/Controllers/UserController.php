<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
    $users = User::all(); // Mengambil semua data pengguna dari database
    return $users;
    // return view('dashboard', compact('users')); 
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), 
    ]);

    return redirect()->route('dashboard')->with('success', 'User  created successfully.');
}

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('dashboard')->with('success', 'User  updated successfully.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('dashboard')->with('success', 'User  deleted successfully.');
    }
}
