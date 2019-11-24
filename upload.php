<?php
  session_start();
  if(!isset($_SESSION['namauser'])) {
    echo  "<script type='text/javascript'>alert('Silahkan Login/Register terlebih dahulu');window.location = './landing.php';</script>";
  }
  if(isset($_SESSION['namauser']) && $_SESSION['role'] != 'penulis') {
    echo  "<script type='text/javascript'>alert('Silahkan Masuk kembali sebagai penulis');window.location = './landing.php';</script>";
  }
  require_once("templates/header.php");
?>

<div class="register">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="register-title">Unggah Buku</h1>
      </div>

      <div class="col-md-9 form-register-group">
        <form action="services/upload.php" method="post" enctype="multipart/form-data">
          <input type="text" class="form-control form-register" id="insert-judulBuku" name="judulBuku" placeholder="Judul buku...">
          <input type="text" class="form-control form-register" id="insert-namaPenulis" name="namaPenulis" placeholder="Nama penulis...">
          <div class="form-group">
            <label for="kategori"></label>
            <select class="form-control form-register form-group-kategori" name="kategori" id="kategori">
            <option>Umum</option>
										<option>Filsafat</option>
										<option>Psikologi</option>
										<option>Agama</option>
										<option>Sejarah</option>
										<option>Sosial</option>
										<option>Bahasa</option>
										<option>Sains</option>
										<option>Geografi</option>
										<option>Teknologi</option>
										<option>Seni</option>
										<option>Literatur</option>
										<option>Sastra</option>
										<option>Biografi</option>
										<option>Matematika</option>
										<option>Novel</option>
										<option>Cerpen</option>
										<option>Puisi</option>
										<option>Drama</option>
										<option>Komik</option>
										<option>Dongeng</option>
										<option>Fabel</option>
										<option>Mitos</option>
            </select>
          </div>

          <div class="form-group">
            <label for="subkategori"></label>
            <select class="form-control form-register form-group-kategori" id="subkategori">
              <!-- <option>-Pilih kategori-</option> -->
              <option>SubKategori 1</option>
              <option>SubKategori 2</option>
              <option>SubKategori 3</option>
              <option>SubKategori 4</option>
              <option>SubKategori 5</option>
            </select>
          </div>
          <div class="form-group">
           <textarea class="form-control" rows="5" id="comment" name="deskripsiBuku" placeholder="Deskripsi/Sinopsis buku..."></textarea>
          </div>

          <div class="form-group">
            <label for="exampleFormControlFile1">
              Format buku dalam bentuk .doc atau .docx. Format penulisan dan layout dapat melihat pada halaman <a href="#">ini.</a> Ukuran file maksimal 50 MB.
            </label>
            <input type="file" class="form-control-file" name="fileToUpload" id="exampleFormControlFile1">
          </div>

          <input type="hidden" id="insert-command" name="command" value="insert">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-ebookhub btn-register">Unggah</button>
        </form>
      </div>


    </div>


  </div>
</div>

<?php
  require_once("templates/footer.php");
?>