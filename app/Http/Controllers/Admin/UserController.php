<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $data = User::with('roles')->get();
        return view('admin.user.index', compact('data'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles'    => 'required|numeric',
        ]);
        
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $rolesWithStatus = collect($request->roles)->mapWithKeys(function ($roleId) {
                return [$roleId => ['status' => 1]];
            })->toArray();

            $user->roles()->attach($rolesWithStatus);
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data user: ' . $e->getMessage()));
        }
        
        return redirect()->route('admin.user')
                        ->with('success', 'user berhasil ditambahkan.');
    }

    protected function edit($id)
    {
        $old = User::where('id', $id)->get();
        return view('admin.user.edit', compact('id', 'old'));
    }

    protected function update(Request $request)
    {
        $validated = Validator::make($request->all(), $this->rules($request->id));
        if($validated->fails()) {
            return redirect()->back()
                            ->withErrors($validated)
                            ->withInput();
        }
        try {
            User::where('id', $request->id)->update($validated->validated());
        } catch (\Exception $e) {
              throw new \Exception(('Gagal menyimpan data user: ' . $e->getMessage()));
        }
        return redirect()->route('admin.user')
                        ->with('success', 'user berhasil ubah.');
    }

    protected function rules($id = null)
    {
        $uniqueRule = $id ?
            'unique:user,name,' . $id . ',id' :
            'unique:user,name';

        if($id != null) {
            return [
            'name' => [
                'required',
                'string',
                'max:50',
                'min:3',
                $uniqueRule
            ],
            'email' => [
                'required',
                'string',
                'max:200'
            ],
            'id' => [
                'required',
                'string',
                'max:8'
            ],
        ];
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
            'email' => [
                'required',
                'string',
                'max:3',
            ],
        ];
    }

    protected function destroy($id)
    {
        if (!User::where('id', $id)->exists()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        try {
            User::where('id', $id)->delete();
            return redirect()->back()->with('deleteSuccess', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            throw new \Exception(('Gagal menghapus data user: ' . $e->getMessage()));
        }
    }
}
