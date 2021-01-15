<?php
    include 'connection.php';

    $getFile = "SELECT * FROM uploaded_image";

    $rows = mysqli_query($kon, $getFile);
    $i = 0;
    mysqli_close($kon);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>List File | Tugas KAP File Upload</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="tema/images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="tema/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="tema/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="tema/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="tema/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="tema/vendor/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" type="text/css" href="tema/css/util.css">
	<link rel="stylesheet" type="text/css" href="tema/css/main.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
					<table>
						<thead>
							<tr class="table100-head">
								<th class="column1">No</th>
								<th class="column2">Kelompok</th>
								<th class="column3">Nama File</th>
								<th class="column4">Tanggal Upload</th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach($rows as $row) : ?>
                                <tr>
                                    <td><?= ++$i ?></td>
                                    <td><?= $row['kelompok'] ?></td>
                                    <td><?= $row['nama_file'] ?></td>
                                    <td><?= $row['waktu'] ?></td>
                                </tr>
                            <?php endforeach; ?>
						</tbody>
					</table>
                    <a href="index.php">
                        <span class="label-input100 text-file putih">Back
                            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                        </span>
                    </a>
				</div>
			</div>
		</div>
	</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="js/main.js"></script>

</body>
</html>