<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public function index(): View
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_user' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'jabatan' => 'required',
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
{
    $request->validate([
        'nama_user' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:5',
        'jabatan' => 'required',
    ]);

    $data = $request->only('nama_user', 'email', 'jabatan');
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
}


    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
        }

        return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
    }
    public function approve($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->approved = true;
            $user->save();
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil disetujui.']);
        }

        return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
    }
        public function reject(User $user)
    {
        $user->update(['rejected' => true]); // Assuming you have a 'rejected' column in your users table

        return response()->json([
            'success' => true,
            'message' => 'User rejected successfully.'
        ]);
    }

}
