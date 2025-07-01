@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 fw-bold">Menu Restoran NAB</h3>
    <button class="btn btn-success btn-sm mb-3" id="btn-tambah">+ Tambah Menu Baru</button>

    <div class="card shadow-sm rounded">
        <div class="card-body">
            <table class="table table-striped table-hover table-bordered" id="table-mahasiswa">
                <thead class="table-success text-center">
                    <tr>
                        <th>ID Menu</th>
                        <th>Nama Menu</th>      
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="ModalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="formMahasiswa" class="modal-content rounded-3 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="ModalAddLabel">Tambah Menu Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="edit-id_menu">
        <div class="mb-3">
          <label for="id_menu" class="form-label">ID MENU</label>
          <input type="text" class="form-control" id="id_menu" name="id_menu" placeholder="Masukkan ID_Menu">
        </div>
        <div class="mb-2">
          <label for="nama_menu" class="form-label">Nama Menu</label>
          <input type="text" class="form-control" id="nama_menu" name="nama_menu" placeholder="Masukkan Nama Menu">
        </div>
        <div class="mb-2">
          <label for="kategori" class="form-label">Kategori</label>
          <select name="kategori" id="kategori" class="form-select">
              <option value="MD">Main Dish</option>
              <option value="DD">Dessert</option>
              <option value="D">Drink</option>
          </select>
        </div>
        <div class="mb-2">
          <label for="harga" class="form-label">Harga</label>
          <input type="text" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga">
        </div>
        <div class="mb-2">
          <label for="deskripsi" class="form-label">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2" placeholder="Tulis deskripsi menu..."></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn-sm" id="btn-simpan">Simpan</button>
        <button type="button" class="btn btn-warning btn-sm" id="btn-update">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS & CSS -->
<link href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const table = $('#table-mahasiswa').DataTable({
        ajax: "/api/mahasiswa",
        columns: [
            { data: 'id_menu' },
            { data: 'nama_menu' },
            {
                data: 'kategori',
                render: function(kategori) {
                    switch (kategori) {
                        case 'MD': return 'Main Dish';
                        case 'DD': return 'Dessert';
                        case 'D': return 'Drink';
                        default: return kategori;
                    }
                }
            },
            { data: 'harga' },
            { data: 'deskripsi' },
            {
                data: 'id_menu',
                render: function(id) {
                    return `
                        <button class="btn btn-success btn-sm btn-edit" data-id="${id}">Edit</button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${id}">Hapus</button>
                    `;
                }
            }
        ]
    });

    function ambildataForm() {
        return {
            id_menu: $('#id_menu').val(),
            nama_menu: $('#nama_menu').val(),
            kategori: $('#kategori').val(),
            harga: $('#harga').val(),
            deskripsi: $('#deskripsi').val()
        };
    }

    $('#btn-tambah').click(function() {
        $('#ModalAddLabel').text('Tambah Menu Baru');
        $('#ModalAdd').modal('show');
        $('#formMahasiswa')[0].reset();
        $('#btn-simpan').show();
        $('#btn-update').hide();
        $('#edit-id_menu').val('');
        $('#id_menu').prop('readonly', false);
    });

    $('#btn-simpan').click(function() {
        var data = ambildataForm();

        $.ajax({
            url: '/api/mahasiswa',
            type: 'POST',
            data: data,
            success: function(response) {
                table.ajax.reload();
                $('#ModalAdd').modal('hide');
                alert('Data berhasil disimpan');
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    $('#table-mahasiswa').on('click', '.btn-edit', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/api/mahasiswa/' + id,
            type: 'GET',
            success: function(data) {
                $('#ModalAddLabel').text('Edit Menu');
                $('#ModalAdd').modal('show');
                $('#id_menu').val(data.id_menu).prop('readonly', true);
                $('#nama_menu').val(data.nama_menu);
                $('#kategori').val(data.kategori);
                $('#harga').val(data.harga);
                $('#deskripsi').val(data.deskripsi);
                $('#btn-simpan').hide();
                $('#btn-update').show();
                $('#edit-id_menu').val(id);
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    $('#btn-update').click(function() {
        var id = $('#edit-id_menu').val();
        var data = ambildataForm();

        $.ajax({
            url: '/api/mahasiswa/' + id,
            type: 'PUT',
            data: data,
            success: function(response) {
                table.ajax.reload();
                $('#ModalAdd').modal('hide');
                alert('Data berhasil diupdate');
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    $('#table-mahasiswa').on('click', '.btn-delete', function() {
        var id = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '/api/mahasiswa/' + id,
                type: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    alert('Data berhasil dihapus');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        }
    });
});
</script>
@endsection
