<?php
	function connectDB() {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "test";
		
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " + mysqli_connect_error());
		}
		return $conn;
	}
	
	function insertBuku() {
		$conn = connectDB();
		
		$displayBuku = $_POST['displayBuku'];
		$judulBuku = $_POST['judulBuku'];
		$pengarangBuku = $_POST['pengarangBuku'];
		$penerbitBuku = $_POST['penerbitBuku'];
		$deskripsiBuku = $_POST['deskripsiBuku'];
		$stokBuku = $_POST['stokBuku'];
		$sql = "INSERT into book (img_path, title, author, publisher, description, quantity) values('$displayBuku', '$judulBuku', '$pengarangBuku', '$penerbitBuku', '$deskripsiBuku', $stokBuku)";
		
		if($result = mysqli_query($conn, $sql)) {
			echo "New record created successfully <br/>";
			header("Location: daftar.php");
			} else {
			die("Error: $sql");
		}
		mysqli_close($conn);
	}
	
	function reviewBuku($book_id, $user_id) {
		
		$conn = connectDB();
		
		$reviewBuku = $_POST['reviewBuku'];
		//$sql = "UPDATE review SET content='$reviewBuku' WHERE book_id='$book_id' and user_id='$user_id'";
		$sql = "INSERT into review(book_id, user_id, date, content) values('$book_id', '$user_id' , '$date', '$reviewBuku')";

		if($result = mysqli_query($conn, $sql)) {
			echo "New record created successfully <br/>";
			header("Location: daftar.php");
			} else {
			die("Error: $sql");
		}
		
	}

	function pinjamBuku($user_id, $book_id) {
		$conn = connectDB();

		$sql = "INSERT into review(book_id, user_id) values('$book_id', '$user_id')";
		
		if($result = mysqli_query($conn, $sql)) {
			echo "New record created successfully <br/>";
			header("Location: daftar.php");
			} else {
			die("Error: $sql");
		}
	}

	function selectAllFromTable($table) {
		$conn = connectDB();
		
		$sql = "SELECT img_path, title, author, publisher, quantity FROM $table";
		
		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}
		mysqli_close($conn);
		return $result;
	}

	function deskripsiBuku($table) {
		$conn = connectDB();

		$sql = "SELECT book_id, description FROM $table";

		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}
		mysqli_close($conn);
		return $result;
	}

	function detailBuku($table) {
		$conn = connectDB();

		$sql = "SELECT book_id, user_id, date, content FROM $table";

		if(!$result = mysqli_query($conn, $sql)) {
			die("Error: $sql");
		}
		mysqli_close($conn);
		return $result;
	}	
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if($_POST['command'] === 'insert') {
			insertBuku();
		}else if($_POST['command'] === 'update') {
			reviewBuku($_POST["book_id"],$_SESSION["user_id"]);
		}else if ($_POST['command'] === 'delete'){

		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>My Personal Library</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="container">
			  <div class="jumbotron">
				<h1>My Personal Library</h1>
				<p>My Personal Library is my first online library.</p>
			  </div>
			</div>
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
				<div class="navbar-header">
				  <a class="navbar-brand" href="home.php">My Personal Library</a>
				</div>
				<ul class="nav navbar-nav">
				  <li class="active"><a href="home.php">Home</a></li>
				  <li><a href="daftar.php">Daftar Buku</a></li>
				  <!--<li><a href="#">Page 2</a></li> -->
				</ul>
				<!-- <form class="navbar-form navbar-left">
				  <div class="form-group">
					<input type="text" class="form-control" placeholder="Username">
					<input type="password" class="form-control" placeholder="Password">
				  </div>
				  <button type="submit" class="btn btn-default">Login</button>
				</form> -->
				<ul class="nav navbar-nav navbar-right">
					<!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
					<?php 
						session_start();
						if (!isset($_SESSION["namauser"])){
							echo "<li><a href='index.php'><span class='glyphicon glyphicon-log-in'></span>Login</a></li>";
						}else if (isset($_SESSION["namauser"])){
							echo "<li><a href='services/logout.php'><span class='glyphicon glyphicon-log-out'></span>Logout</a></li>";
						}
					?>
				</ul>
			  </div>
			</nav>
			<h4>
                Selamat Datang
                <?php
                    if (isset($_SESSION["namauser"])){
                        echo $_SESSION["namauser"];
                    }
                ?>
            </h4>
            <?php
                if (isset($_SESSION["namauser"]) && $_SESSION["role"] === "admin"){
                    echo "<br><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#insertModal'>
                        Add Buku
                    </button>";
                }
            ?>
            
            <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title black-modal" id="insertModalLabel">Add Book</h4>
                        </div>
                        <div class="modal-body">
                            <form action="daftar.php" method="post">
                                <div class="form-group">
                                    <label for="displayBuku">Display Buku</label>
                                    <input type="url" class="form-control" id="insert-displayBuku" name="displayBuku" placeholder="Link Buku">
                                </div>
                                <div class="form-group">
                                    <label for="judulBuku">Judul Buku</label>
                                    <input type="text" class="form-control" id="insert-judulBuku" name="judulBuku" placeholder="Judul Buku">
                                </div>
                                <div class="form-group">
                                    <label for="pengarangBuku">Pengarang Buku</label>
                                    <input type="text" class="form-control" id="insert-pengarangBuku" name="pengarangBuku" placeholder="Pengarang Buku">
                                </div>
                                <div class="form-group">
                                    <label for="penerbitBuku">Penerbit Buku</label>
                                    <input type="text" class="form-control" id="insert-penerbitBuku" name="penerbitBuku" placeholder="Penerbit Buku">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsiBuku">Deskripsi Buku</label>
                                    <input type="text" class="form-control" id="insert-deskripsiBuku" name="deskripsiBuku" placeholder="Deskripsi Buku">
                                </div>
                                <div class="form-group">
                                    <label for="stokBuku">Stok Buku</label>
                                    <input type="number" class="form-control" id="insert-stokBuku" name="stokBuku" placeholder="Stok Buku">
                                </div>
                                <input type="hidden" id="insert-command" name="command" value="insert">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class='table'>
                    <thead> <tr> <th>Display</th> <th>Judul Buku</th> <th>Pengarang</th> <th>Penerbit</th> <th>Stock</th> </tr> </thead>
                    <tbody>
                        <?php
                            
                            $buku = selectAllFromTable("book");
                            while ($row = mysqli_fetch_row($buku)) {
                                echo "<tr>";
                                foreach($row as $key => $value) {
                                    if ($key == "img_path"){
                                        echo "<td><img class='img-responsive' src='$value' alt='$value'></td>";
                                    }else {
                                        echo "<td>$value</td>";
                                    }
                                }
                                if (isset($_SESSION["namauser"])){
                                    echo '<td>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#detailModal" 
                                    onclick="setUpdateData(\''.$row[1].'\',\''.$row[2].'\',\''.$row[3].'\',\''.$row[4].'\')">  
                                    Detail
                                    </button>
                                    </td>';
                                }
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title black-modal" id="detailModalLabel">Detail Buku</h4>
                        </div>
                        <div class="modal-body">
                        	<fieldset>
                        		<legend>Deskripsi Buku</legend>
                        		<?php
                        			$deskripsi = deskripsiBuku("book");
                        			while ($row = mysqli_fetch_row($deskripsi)){
                        				foreach($row as $key => $value) {
                        					echo "$value";
                        				}
                        			}

                        		?>
                        	</fieldset>
                        	<fieldset>
                        		<legend>Review Buku</legend>
                        		<?php
                        			$review = detailBuku("review");
                        			while ($row = mysqli_fetch_row($review)){
                        				foreach($row as $key => $value) {
                        					echo "$value";
                        				}
                        			}

                        		?>
                        	</fieldset>
                            <form action="daftar.php" method="post">
                                <div class="form-group">
                                    <label for="reviewBuku">Review Buku</label>
                                    <input type="text" class="form-control" id="update-reviewBuku" name="reviewBuku" placeholder="Review Buku">
                                </div>
                                <input type="hidden" id="update-packageid" name="packageid">
                                <input type="hidden" id="update-command" name="command" value="update">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-default">Pinjam</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<script src="js/jquery-3.1.0.min.js"> </script>
		<script src="bootstrap/dist/js/bootstrap.min.js"></script>		
		<script>
			function setUpdateData(book_id, user_id, date, content) {
				$("#update-book_id").val(book_id);
				$("#update-user_id").val(user_id);
				$("#update-date").val(date);
				$("#update-content").val(content);
			}
		</script>
	</body>
</html>							