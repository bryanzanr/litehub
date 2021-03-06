<?php
	session_start();
	function connectDB() {
		$servername = "sql12.freesqldatabase.com";
		$username = "sql12313869";
		$password = "qy1jlUjdiy";
		$dbname = "sql12313869";
		
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " + mysqli_connect_error());
		}
		return $conn;
	}

  function getStatus($bulan, $status){
      $conn = connectDB();

      $sql = "SELECT count(*) as jumlah from unggah where MONTH(upload_date)='$bulan' AND status = '".$status."'";

      if(!$result = mysqli_query($conn, $sql)) {
        die("Error: $sql");
      }
      mysqli_close($conn);
      
      $query = $result;
      $row = $query->fetch_array();
      $jumlah[] = $row['jumlah'];
      return $jumlah;
  }
  
  function getSoldFiksi($bulan){
    $conn = connectDB();

    $sql = "SELECT sum(quantity) as terjual from book where MONTH(publish_date)='$bulan' AND (category = 'Fiksi' OR category = 'Novel' OR category = 'Cerpen' OR category = 'Puisi' OR category = 'Drama' OR category = 'Komik' OR category = 'Dongeng' OR category = 'Fabel' OR category = 'Mitos')";

    if(!$result = mysqli_query($conn, $sql)) {
      die("Error: $sql");
    }
    mysqli_close($conn);
    
    $query = $result;
    $row = $query->fetch_array();
    $jumlah[] = $row['terjual'];
    return $jumlah;
}

function getSoldNonFiksi($bulan){
  $conn = connectDB();

  $sql = "SELECT sum(quantity) as terjual from book where MONTH(publish_date)='$bulan' AND (category != 'Fiksi' AND category != 'Novel' AND category != 'Cerpen' AND category != 'Puisi' AND category != 'Drama' AND category != 'Komik' AND category != 'Dongeng' AND category != 'Fabel' AND category != 'Mitos')";

  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_close($conn);
  
  $query = $result;
  $row = $query->fetch_array();
  $jumlah[] = $row['terjual'];
  return $jumlah;
}

  function getpenulis() {
		$conn = connectDB();
		
		$sql = "SELECT count(*) FROM user WHERE role = 'penulis'";
		
		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}

		mysqli_close($conn);
		return $result;
	}

	function getpembaca() {
		$conn = connectDB();
		
		$sql = "SELECT count(*) FROM user WHERE role = 'user'";
		
		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}

		mysqli_close($conn);
		return $result;
  }
  
  function statusPenjualan() {
		$conn = connectDB();
		
		$sql = "SELECT count(quantity) FROM book";
		
		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}

		mysqli_close($conn);
		return $result;
  }

  function getKategori() {
		$conn = connectDB();
		
		$sql = "SELECT count(*) FROM category";
		
		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}

		mysqli_close($conn);
		return $result;
  }
  
	function getbook() {
		$conn = connectDB();
		
		$sql = "SELECT count(*) FROM book";
		
		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}

		mysqli_close($conn);
		return $result;
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>EBOOKHUB.ID</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/home.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	</head>
	<body>
		<div class="jumbotron">
			<h1 style="font-size: 6em;">EBOOKHUB.ID</h1>
			<div class="welcome-text">
			<h2>Selamat Datang <b>
				<?php
				if (isset($_SESSION["namauser"])){
					echo $_SESSION["namauser"];
				}
				?></b>
			</h2>
			</div>
		</div>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Ebookhub.ID</a>
				</div>
				<ul class="nav navbar-nav">
					<?php
					if(isset($_SESSION['namauser']) && $_SESSION['role'] === 'user') {
						echo '
						<li><a href="home.php">Home</a></li>
						';
					}
					?>
					<li><a href="daftar.php">Daftar Buku</a></li>
					
					<?php
					if(isset($_SESSION['namauser']) && $_SESSION['role'] === 'penulis') {
						echo '
						<li><a href="unggah.php">Unggah Buku</a></li>
						';
					}
					
					?>
					<?php
					if(isset($_SESSION['namauser']) && $_SESSION['role'] === 'editor') {
						echo '
						<li><a href="unduh.php">Unduh Buku</a></li>
						';
					}
					?>
					<li class="active"><a href="statistik.php">Statistik</a></li>

				
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
						if (isset($_SESSION["namauser"])){
							echo "<li><a href='services/logout.php'><span class='glyphicon glyphicon-log-out'></span>Logout</a></li>";
						}else if(!isset($_SESSION['namauser'])) {
							echo '
								<form class="form-inline navbar-form navbar-left" action="index.php" method="post">
									<div class="form-group">
										<label style="color:white;" for="username">Username</label>
										<input type="text" class="form-control" id="insert-username" name="username" placeholder="Username" required>
									</div>
									<div class="form-group">
										<label style="color:white;" for="password">Password</label>
										<input type="password" class="form-control" id="insert-password" name="password" placeholder="Password" required>
									</div>
									<input type="hidden" id="insert-command" name="command" value="insert">
									<button type="submit" class="btn btn-default">Login</button>
								</form>
							';
						}
					?>
				</ul>
			</div>
		</nav>
		<div class="content-wrapper">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Statistik</h1>
          </div>
        </div>
      </div>
    </div>
    
    <div class='col-lg-3 col-md-6'>
      <div class='panel panel-primary panel-ebookhub-red'>
        <div class='panel-heading'>
          <div class='row'>
            <div class='col-xs-3'>
              <i class='fa fa-pencil fa-5x'></i>
            </div>
            <div class='col-xs-9 text-right'>
              <div id="leadmonth"></div>
              <div>Total Penulis</div>
              <?php 
                $countuser = getpenulis();
                while ($row = mysqli_fetch_row($countuser)) {
                  echo '<h1>'.$row[0].'</h1>';
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class='col-lg-3 col-md-6'>
      <div class='panel panel-primary'>
        <div class='panel-heading'>
          <div class='row'>
            <div class='col-xs-3'>
              <i class='fa fa-user fa-5x'></i>
            </div>
            <div class='col-xs-9 text-right'>
              <div id="leadmonth"></div>
              <div>Total Pembaca</div>
							<?php 
								$countuser = getpembaca();
								while ($row = mysqli_fetch_row($countuser)) {
									echo '<h1>'.$row[0].'</h1>';
								}
							?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class='col-lg-3 col-md-6'>
      <div class='panel panel-primary'>
        <div class='panel-heading'>
          <div class='row'>
            <div class='col-xs-3'>
              <i class='fa fa-book fa-5x'></i>
            </div>
            <div class='col-xs-9 text-right'>
            <div id="leadmonth"></div>
            <div>Total Buku Terbit</div>
							<?php 
								$countuser = getbook();
								while ($row = mysqli_fetch_row($countuser)) {
									echo '<h1>'.$row[0].'</h1>';
								}
							?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class='col-lg-3 col-md-6'>
      <div class='panel panel-primary'>
        <div class='panel-heading'>
          <div class='row'>
            <div class='col-xs-3'>
              <i class='fa fa-tasks fa-5x'></i>
            </div>
            <div class='col-xs-9 text-right'>
              <div id="leadmonth"></div>
              <div>Total Kategori Buku</div>
              <?php 
								$countuser = getKategori();
								while ($row = mysqli_fetch_row($countuser)) {
									echo '<h1>'.$row[0].'</h1>';
								}
							?>
            </div>
          </div>
        </div>
      </div>
    </div>        

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Penjualan</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fa fa-square text-primary" style="color:#007bff"></i> Non Fiksi
                  </span>

                  <span>
                    <i class="fa fa-square text-gray" style="color:#ced4da"></i> Fiksi
                  </span>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Pengajuan</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fa fa-square text-primary" style="color:#007bff"></i> Dalam proses pengajuan
                  </span>

                  <span>
                    <i class="fa fa-square text-gray" style="color:#ced4da"></i> Sudah diterima
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="js/jquery-3.1.0.min.js"> </script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>	

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="js/Chart.min.js"></script>
<?php
   $label = ['JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER'];
?>
<script>
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : <?php echo json_encode($label); ?>,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor    : '#007bff',
      data           : <?php 
                        for($bulan=7;$bulan<12;$bulan++){
                          $jumlah_proses[] = getStatus($bulan, "Dalam Proses Penyuntingan");
                        }
                       echo json_encode($jumlah_proses); ?>
        },
        {
          backgroundColor: '#ced4da',
          borderColor    : '#ced4da',
		  data           : <?php 
                        for($bulan=7;$bulan<12;$bulan++){
                          $jumlah_diterima[] = getStatus($bulan, "Sudah Diterima");
                        }
                       echo json_encode($jumlah_diterima); ?>
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })

  var $visitorsChart = $('#visitors-chart')
  var visitorsChart  = new Chart($visitorsChart, {
    data   : {
      // labels  : ['September', 'Oktober', 'November'],
      labels  : <?php echo json_encode($label); ?>,
      datasets: [{
        type                : 'line',
        // data                : [12, 10, 12, 17,10],
                               
                            
        data                : <?php
                                for($bulan=7;$bulan<12;$bulan++){
                                  $jumlah_nf[] = getSoldNonFiksi($bulan);
                                }
                              echo json_encode($jumlah_nf); 
                             ?>,                       
        backgroundColor     : 'transparent',
        borderColor         : '#007bff',
        pointBorderColor    : '#007bff',
        pointBackgroundColor: '#007bff',
        fill                : false
      },
        {
          type                : 'line',
          data                : <?php 
                                  for($bulan=7;$bulan<12;$bulan++){
                                    $jumlah_f[] = getSoldFiksi($bulan);
                                  }
                                  echo json_encode($jumlah_f); 
                                ?>,
          backgroundColor     : 'tansparent',
          borderColor         : '#ced4da',
          pointBorderColor    : '#ced4da',
          pointBackgroundColor: '#ced4da',
          fill                : false
        }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero : true,
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
})
</script>
	</body>
	<footer>
		<hr>
		<h4>&copy; 2019 Litehub Inc. All rights reserved</h4>
	</footer>
</html>							