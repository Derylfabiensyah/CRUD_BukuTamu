
<?php
require_once('function.php');
include_once('tamplates/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>
  <?php
    if(isset($_POST['simpan'])){
      if(tambah_tamu($_POST) > 0){
  ?>
  <div class="alert alert-success" role="alert">
    Data berhasil disimpan!
  </div>
  <?php
      } else {
  ?>
  <div class="alert alert-danger" role="alert">
    Data gagal disimpan!
  </div>
  <?php
      }
    }
  ?>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#tambahModal">
      <span class="icon text-while-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">Data Tamu</span>
    </button>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Nama Tamu</th>
            <th class="text-center">Alamat</th>
            <th class="text-center">No HP</th>
            <th class="text-center">Bertemu</th>
            <th class="text-center">Kepentingan</th>
            <th colspan="2" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Nama Tamu</th>
            <th class="text-center">Alamat</th>
            <th class="text-center">No HP</th>
            <th class="text-center">Bertemu</th>
            <th class="text-center">Kepentingan</th>
            <th colspan="2" class="text-center">Aksi</th>
          </tr>
        </tfoot>
        <tbody>
          <?php
            $no = 1;
            $buku_tamu = query("SELECT * FROM tabel_bukutamu");
            foreach($buku_tamu as $tamu) : 
          ?>
          <tr>
            <td class="text-center"><?= $no++?></td>
            <td><?= $tamu['tanggal']?></td>
            <td><?= $tamu['nama_tamu']?></td>
            <td><?= $tamu['alamat']?></td>
            <td><?= $tamu['no_hp']?></td>
            <td><?= $tamu['bertemu']?></td>
            <td><?= $tamu['kepentingan']?></td>
            <td class="text-center">
              <a class="btn btn-success" href="edit-tamu.php?id=<?= $tamu['id_tamu']?>">Ubah</a>
            </td>
            <td class="text-center">
              <a href="hapus-tamu.php?id=<?= $tamu['id_tamu']?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
            </td>
          </tr>
          <?php endforeach?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Membuat id otomatis -->
<?php
$query = mysqli_query($koneksi, "SELECT max(id_tamu) as kodeTerbesar FROM tabel_bukutamu");
$data = mysqli_fetch_array($query);
$kodeTamu = $data['kodeTerbesar'];
$urutan = (int) substr($kodeTamu, 2, 3);

$urutan++;

$huruf = "TM";
$kodeTamu = $huruf . sprintf("%03s", $urutan);
?>

<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="tambahModalLabel">Tambah Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <input type="hidden" name="id_tamu" id="id_tamu" value="<?= $kodeTamu?>">
          <div class="form-group row">
            <label for="nama_tamu" class="col-sm-3 col-form-label">Nama Tamu</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nama_tamu" name="nama_tamu">
            </div>
          </div>
          <div class="form-group row">
            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-8">
              <textarea class="form-control" id="alamat" name="alamat"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="no_hp" class="col-sm-3 col-form-label">No. Telepon</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="no_hp" name="no_hp">
            </div>
          </div>
          <div class="form-group row">
            <label for="bertemu" class="col-sm-3 col-form-label">Bertemu dg.</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="bertemu" name="bertemu">
            </div>
          </div>
          <div class="form-group row">
            <label for="kepentingan" class="col-sm-3 col-form-label">Kepentingan</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="kepentingan" name="kepentingan">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
<?php include('tamplates/footer.php')?>
