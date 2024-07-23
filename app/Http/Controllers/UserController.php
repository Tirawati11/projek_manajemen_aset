<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\Log;





class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';

                    // Tombol Approve jika pengguna belum disetujui atau ditolak
                    if (!$row->approved && !$row->rejected) {
                        $btn .= '<form action="' . route('users.approve', $row->id) . '" method="POST" class="d-inline form-approve" data-id="' . $row->id . '">
                            ' . csrf_field() . method_field('PUT') . '
                            <button type="button" class="btn btn-sm btn-success btn-approve" title="Approve">
                                <i class="far fa-thumbs-up"></i>
                            </button>
                        </form>';
                    }

                    // Tombol Edit
                    $btn .= '<a href="#" class="btn btn-sm btn-primary btn-edit" data-id="' . $row->id . '" data-name="' . $row->nama_user . '" data-email="' . $row->email . '" data-jabatan="' . $row->jabatan . '" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>';

                    // Tombol Hapus
                    $btn .= '<form action="' . route('users.destroy', $row->id) . '" method="POST" class="d-inline form-delete" data-id="' . $row->id . '">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users.index');
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
        return view('users.index', compact('user'));
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
        User::destroy($id);

        return redirect()->route('users.index')->with('success', 'User berhasil Dihapus.');
    }

    public function approve($id) {
        $user = User::findOrFail($id);
        $user->approved = true;
        // $user->rejected = false; // Reset rejected status
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil disetujui.');
    }

    // public function reject($id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->approved = false;
    //     $user->save();

    //     return redirect()->route('users.index')->with('success', 'User rejected successfully.');
    // }

    public function import(Request $request)
    {
        // Tambahkan log untuk memastikan file diterima
        Log::info('File yang diunggah:', [$request->file('file')]);

        // Lakukan import dan tambahkan log untuk melihat prosesnya
        Excel::import(new UsersImport, $request->file('file'));

        Log::info('Import selesai.');

        return redirect()->back()->with('success', 'File berhasil diimport.');
    }
}