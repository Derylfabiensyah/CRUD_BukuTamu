<?php
require_once('function.php');
include_once('tamplates/header.php');

if($_SESSION['role'] != 'admin'){
  echo "<script>
          alert('Anda tidak memiliki akses ke halaman ini!');
          window.location.href = 'index.php';
        </script>";
  exit;
}
?>

<?php
if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'):
?>
<ul>
  <li>
    <a href="users.php" class="nav-link">
      <i class="fas fa-fw fa-users"></i>
      <span>User</span>
    </a>
  </li>
</ul>
<?php
  endif;
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Data User</h1>
  <?php
    if(isset($_POST['simpan'])){
      if(tambah_user($_POST) > 0){
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
    } else if (isset($_POST['ganti_password'])){
        if(ganti_password($_POST) > 0){
  ?>
  <div class="alert alert-success" role="alert">
    Password berhasil diubah!
  </div>
  <?php
      } else {
  ?>
  <div class="alert alert-danger" role="alert">
    Password gagal diubah!
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
      <span class="text">Data User</span>
    </button>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Username</th>
            <th class="text-center">User Role</th>
            <th colspan="3" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Username</th>
            <th class="text-center">User Role</th>
            <th colspan="3" class="text-center">Aksi</th>
          </tr>
        </tfoot>
        <tbody>
          <?php
            $no = 1;
            $users = query("SELECT * FROM users");
            foreach($users as $user) : 
          ?>
          <tr>
            <td class="text-center"><?= $no++?></td>
            <td class="text-center"><?= $user['username']?></td>
            <td class="text-center"><?= $user['user_role']?></td>
            <td class="text-center">
              <button type="button" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#gantiPassword" data-id="<?= $user['id_user']?>">
                <span class="text">Ganti Password</span>
              </button>
            </td>
            <td class="text-center">
              <a class="btn btn-success" href="edit-user.php?id=<?= $user['id_user']?>">Ubah</a>
            </td>
            <td class="text-center">
              <a href="hapus-user.php?id=<?= $user['id_user']?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
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
$query = mysqli_query($koneksi, "SELECT max(id_user) as kodeTerbesar FROM users");
$data = mysqli_fetch_array($query);
$kodeuser = $data['kodeTerbesar'];
$urutan = (int) substr($kodeuser, 3, 2);

$urutan++;

$huruf = "USR";
$kodeuser = $huruf . sprintf("%02s", $urutan);
?>

<!-- Modal Ganti Password -->
<div class="modal fade" id="gantiPassword" tabindex="-1" aria-labelledby="gantiPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gantiPasswordLabel">Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="id_user" id="id_user">
          <div class="form-group row">
            <label for="password" class="col-sm-4 col-torn-label">Password Baru</label>
            <div class="col-sm-7">
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        <button type="submit" name="ganti_password" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

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
          <input type="hidden" name="id_user" id="id_user" value="<?= $kodeuser?>">
          <div class="form-group row">
            <label for="nama_user" class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="username" name="username">
            </div>
          </div>
          <div class="form-group row">
            <label for="nama_user" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>
          <div class="form-group row">
            <label for="nama_user" class="col-sm-3 col-form-label">User Role</label>
            <div class="col-sm-8">
              <select name="user_role" id="user_role" class="form-control">
                <option value="admin">Administrator</option>
                <option value="operator">Operator</option>
              </select>
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