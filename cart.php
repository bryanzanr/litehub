<?php
require_once("templates/header.php");
?>

<?php
session_start();
function connectDB() {
  // require 'config/connect.php';
  $servername = "sql12.freesqldatabase.com";
  $username = "sql12310568";
  $password = "wmiLAF7a6g";
  $dbname = "sql12310568";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
    die("Connection failed: " + mysqli_connect_error());
  }
  return $conn;
}

function selectRowsFromSubmission() {
  $conn = connectDB();

  $sql = "SELECT * FROM submission WHERE user_id = ".$_SESSION["user_id"]."";
  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
} 

function selectBooks() {
  $pinjam = selectRowsFromSubmission();
  $arraysubmission = array();
  while ($baris = mysqli_fetch_row($pinjam)) {
    array_push($arraysubmission, $baris[1]);
  }
  return $arraysubmission;
}

function selectAllFromBook($book_id) {
  $conn = connectDB();

  $sql = "SELECT * FROM book WHERE book_id = $book_id";
  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
}

?>

<div class="cart section-mini-margin">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1>Keranjang</h1>
      </div>

      <div class="col-lg-12 col-md-12 col-sm-12 items-cart">
        <div class="row">
          <div class="box">
            <form class="" action="cart.php" method="post" enctype="multipart/form-data">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="2">Produk</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                      <?php
                      $conn = connectDB();
                      if (isset($_GET['id'])) {
                        $no = $_GET['id'];
                        $query = "SELECT * FROM book where book_id = '$no'";
                        $detail_unggah = mysqli_query($conn, $query);

                        if (mysqli_num_rows($detail_unggah) > 0) {
                          $row = mysqli_fetch_assoc($detail_unggah);
                          echo '
                          <tr>
                          <td class="col-md-2"><img class="card-img-top img-responsive img-cart" src="'.$row['img_path'].'" alt="card-img"></td>
                          <td>
                          <h2 id="ebook-title">'.$row['title'].'</h2>
                          <h4 class="ebook-author">'.$row['author'].'</h4>
                          <p>Penerbit : '.$row['publisher'].'</p>
                          <p>SKU : '.$row['book_id'].'</p>
                          </td>

                          <td> <h4> Rp. '.$row['quantity'].'</h4> </td>
                          <td> <a href="details.php?id='.$no.'" class="btn btn-danger btn-hapus text-capitalize"><i class="fa fa-trash"> &nbsp; Hapus</i></a> </td>
                          </tr>
                          ';
                        }
                      }else{
                        $arraybook = selectBooks();
                        for ($i=0; $i < count($arraybook); $i++) { 
                          $buku = selectAllFromBook($arraybook[$i]);
                          while ($row = mysqli_fetch_row($buku)) {
                            echo '
                            <tr>
                            <td class="col-md-2"><img class="card-img-top img-responsive img-cart" src="'.$row[1].'" alt="card-img"></td>
                            <td>
                            <h2 id="ebook-title">'.$row[2].'</h2>
                            <h4 class="ebook-author">'.$row[3].'</h4>
                            <p>Penerbit : '.$row[4].'</p>
                            <p>SKU : '.$row[0].'</p>
                            </td>

                            <td> <h4> Rp. '.$row[6].'</h4> </td>
                            <td> <a href="services/cancel.php?id='.$row[0].'" class="btn btn-danger btn-hapus text-capitalize"><i class="fa fa-trash"> &nbsp; Hapus</i></a> </td>
                            </tr>
                            ';
                          }
                        }
                      }
                      ?>

                    <tr>
                      <th> <a href="shop.php">Lanjutkan belanja</a> </th>
                      <th class="pull-right">Total</th>
                      <?php
                      $conn = connectDB();
                      if (isset($_GET['id'])) {
                        $no = $_GET['id'];
                        $query = "SELECT * FROM book where book_id = '$no'";
                        $detail_unggah = mysqli_query($conn, $query);

                        if (mysqli_num_rows($detail_unggah) > 0) {
                          $row = mysqli_fetch_assoc($detail_unggah);
                          echo '
                          <th>'.$row['quantity'].'</th>
                          ';
                        }
                      }else{
                        $arraybook = selectBooks();
                        $sum = 0;
                        for ($i=0; $i < count($arraybook); $i++) { 
                          $buku = selectAllFromBook($arraybook[$i]);
                          while ($row = mysqli_fetch_row($buku)) {
                            $sum = $sum + $row[6];
                          }
                        }
                        echo '
                          <th>'.$sum.'</th>
                        ';
                      }
                      ?>
                      <th> <a href="metode-pembayaran.php">Lanjut ke pembayaran</a> </th>
                    </tr>
                  </tbody>
                </table>

                <hr>


              </div>
            </form>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

<?php
require_once("templates/footer.php");
?>