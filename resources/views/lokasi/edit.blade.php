<div class="modal fade" id="modalEdit{{$location->id}}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{$location->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel{{$location->id}}">Edit Lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEdit{{$location->id}}" action="{{ route('lokasi.update', $location->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name{{$location->id}}">Nama Lokasi</label>
                        <input type="text" class="form-control" name="name" id="name{{$location->id}}" value="{{ $location->name }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
