<div class="modal fade" id="modal-show-user" tabindex="-1" role="dialog" aria-labelledby="modal-show-user-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-show-user-title">Detail Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal-show-nama_user">Nama User</label>
                    <input type="text" class="form-control" id="modal-show-nama_user" readonly>
                </div>
                <div class="form-group">
                    <label for="modal-show-email">Email</label>
                    <input type="email" class="form-control" id="modal-show-email" readonly>
                </div>
                <div class="form-group">
                    <label for="modal-show-jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="modal-show-jabatan" readonly>
                </div>
                @if(Auth::check() && Auth::user()->jabatan == 'admin')
                    <a href="{{ route('users.index') }}" class="btn btn-danger">Kembali</a>
                @endif
            </div>
        </div>
    </div>
</div>

