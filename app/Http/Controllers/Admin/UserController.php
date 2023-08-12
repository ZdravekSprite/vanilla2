<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $selected = ['id','name', 'email', 'password'];
    $all = User::all()->count();
    $users = User::select($selected)->paginate(15);
    return Inertia::render('Admin/Users', [
      'all' => $all,
      'users' => $users,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    User::factory()->create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => $request->password,
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    $user = User::findOrFail($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = $request->password;
    $user->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    //
  }
}
