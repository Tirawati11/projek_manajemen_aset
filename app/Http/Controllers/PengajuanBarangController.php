<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\PengajuanBarang;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;


class PengajuanBarangController extends Controller
{
//     public function index(Request $request)
// {
//     $search = $request->input('search');
//     $user = Auth::user();

//     // Query untuk mendapatkan data PengajuanBarang dengan relasi User
//     $query = PengajuanBarang::query();

//     // Jika user adalah admin, tampilkan semua data
//     if ($user->jabatan == 'admin') {
//         $query->when($search, function ($query, $search) {
//             return $query->where(function ($query) use ($search) {
//                 $query->where('nama_barang', 'LIKE', "%{$search}%")
//                       ->orWhereHas('user', function ($query) use ($search) {
//                           $query->where('nama_user', 'LIKE', "%{$search}%");
//                       });
//             });
//         });
//     } else {
//         // Jika user bukan admin, filter hanya untuk data mereka sendiri
//         $query->where('nama_pemohon', $user->nama_user)
//               ->when($search, function ($query, $search) {
//                   return $query->where(function ($query) use ($search) {
//                       $query->where('nama_barang', 'LIKE', "%{$search}%");
//                   });
//               });
//     }

//     // Dapatkan hasil paginasi dengan menyertakan query pencarian
//     $pengajuan = $query->latest()->paginate(10);

//     $pengajuan->appends(['search' => $search]);

//     return view('pengajuan.index', compact('pengajuan', 'search'));
//     }

public function index(Request $request)
{
    if ($request->ajax()) {
        $user = Auth::user();
        $query = PengajuanBarang::query();

        // Filter berdasarkan peran pengguna
        if ($user->jabatan != 'admin') {
            $query->where('nama_pemohon', $user->nama_user);
        }

        // Urutankan data untuk memunculkan yang belum di-approve di atas
        $query->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END, created_at DESC");

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function($item) {
                if (Auth::user()->jabatan == 'admin') {
                    return '<input type="checkbox" class="checkbox-input" value="'.$item->id.'">';
                }
                return '';
            })
            ->addColumn('action', function($item) {
                $approveButton = '';
                if (Auth::user()->jabatan == 'admin' && $item->status === 'pending') {
                    $approveButton = '
                    <div class="dropdown d-inline">
                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton'.$item->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-thumbs-up"></i> Approve
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton'.$item->id.'">
                            <form id="approvalForm'.$item->id.'" action="'.route('pengajuan.approve', $item->id).'" method="POST" class="dropdown-item">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-link text-primary approvalButton" data-pengajuanid="'.$item->id.'" title="Approve">
                                    <i class="far fa-thumbs-up"></i> Approve
                                </button>
                            </form>
                            <form id="rejectForm'.$item->id.'" action="'.route('pengajuan.reject', $item->id).'" method="POST" class="dropdown-item">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-link text-danger rejectButton" data-pengajuanid="'.$item->id.'" title="Reject">
                                    <i class="far fa-thumbs-down"></i> Reject
                                </button>
                            </form>
                        </div>
                    </div>';
                }

                return $approveButton.'
                <div class="dropdown d-inline">
                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton3'.$item->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cogs"></i> Aksi
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3'.$item->id.'">
                        <a href="'.route('pengajuan.show', $item->id).'" class="dropdown-item">
                            <i class="far fa-eye"></i> Lihat
                        </a>
                        <a href="'.route('pengajuan.edit', $item->id).'" class="dropdown-item">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form id="delete-form-'.$item->id.'" action="'.route('pengajuan.destroy', $item->id).'" method="POST" class="dropdown-item">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <a href="" class="delete-confirm" style="color:black;">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </form>
                    </div>
                </div>';
            })
            ->editColumn('status', function($item) {
                return '<span class="'.($item->status === 'pending' ? 'badge badge-warning' : ($item->status === 'approved' ? 'badge badge-success' : 'badge badge-danger')).'">'.$item->status.'</span>';
            })
            ->rawColumns(['checkbox', 'action', 'status'])
            ->make(true);
    }

    return view('pengajuan.index');
}

    // Create Pengajuan
    public function create()
    {
        return view('pengajuan.create');
    }

    // Fungsi untuk menyimpan hasil input
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        PengajuanBarang::create([
            'nama_pemohon' => $user->nama_user,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'status' => 'pending',
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dibuat.');
    }

    // Fungsi Untuk Menampilkan Detail Data
    public function show($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        return view('pengajuan.show', compact('pengajuan'));
    }

    // form edit
    public function edit($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();
        // $category= Categories::all();
        return view('pengajuan.edit', compact('pengajuan', 'user'));
    }

     // Update pengajuan
     public function update(Request $request, $id)
     {
         // Temukan item pengajuan berdasarkan ID atau gagal
         $pengajuan = PengajuanBarang::findOrFail($id);

         // Validasi input
         $request->validate([
             'nama_barang' => 'required|string',
             'jumlah' => 'required|integer|min:1',
             'deskripsi' => 'required|string',
             'stok' => 'required|integer|min:0',
            ]);

         try {
            // Mendapatkan pengguna yang sedang login
            $user = Auth::user();
             // Update item pengajuan
             $pengajuan->update([
                 'nama_barang' => $request->nama_barang,
                 'nama_pemohon' => $user->nama_user,
                 'jumlah' => $request->jumlah,
                 'deskripsi' => $request->deskripsi,
                 'stok' => $request->stok,
                ]);

             // Redirect ke halaman index dengan pesan sukses
             return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
         } catch (\Exception $e) {
             // Tangani kesalahan dan tampilkan pesan kesalahan
             return redirect()->back()->withErrors(['error' => $e->getMessage()]);
         }
     }

    //  Menghapus pengajuan
    public function destroy($id)
    {
        $pengajuan= PengajuanBarang::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
//   Aprove pengajuan
    public function approve($id)
    {
    $pengajuan = PengajuanBarang::findOrFail($id);

    if ($pengajuan->status === 'pending') {
        $pengajuan->status = 'approved';
        $pengajuan->save();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil disetujui.');
    }

    return redirect()->route('pengajuan.index')->with('error', 'Pengajuan tidak dapat disetujui.');
    }

    // Reject pengajuan barang
    public function reject($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);

        if ($pengajuan->status === 'pending') {
            $pengajuan->status = 'rejected';
            $pengajuan->save();

            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditolak.');
        }

        return redirect()->route('pengajuan.index')->with('error', 'Pengajuan tidak dapat ditolak.');
    }
    // Penghapusan dengan checxkbox
    public function bulkDelete(Request $request)
    {
    $ids = $request->ids; // Ambil id-item yang akan dihapus dari request

    foreach ($ids as $id) {
        // Lakukan penghapusan satu per satu, sesuai kebutuhan aplikasi Anda
        $item = PengajuanBarang::find($id);
        if ($item) {
            $item->delete();
        }
    }

    return response()->json(['success' => true]);
    }
 // Method for bulk approve
    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids');
        PengajuanBarang::whereIn('id', $ids)->update(['status' => 'approved']);

        return response()->json(['success' => true, 'message' => 'Item terpilih berhasil disetujui.']);
    }

 // Method for bulk reject
    public function bulkReject(Request $request)
    {
        $ids = $request->input('ids');
        PengajuanBarang::whereIn('id', $ids)->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Item terpilih berhasil ditolak.']);
    }
}

