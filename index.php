<?php 
	//koneksi database
	$server = "localhost";
	$user = "id15433732_abidfadillah";
	$pass = "DjO)CCkZ-qyFm\L8";
	$database = "id15433732_dblatihan";

	global $koneksi;
	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));


	//jika tombol save di klik
	if (isset($_POST['bsave'])) 
	{
		//pengujian data akan diedit atau disimpan
		if($_GET['hal'] == "edit")
		{
			//data akan diedit
			$edit = mysqli_query($koneksi, "UPDATE tmhs set
												nim = '$_POST[tnim]',
												nama = '$_POST[tnama]',
												alamat = '$_POST[talamat]',
												prodi = '$_POST[tprodi]'
											WHERE id_mhs = '$_GET[id]'
											 ");
			if($edit)
			{
				echo "<script>
						alert('Edit Data Success');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Edit Data Failed');
						document.location='index.php'
					 </script>";
			}
		}
		else
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
											  VALUES ('$_POST[tnim]', 
											  		 '$_POST[tnama]', 
											  		 '$_POST[talamat]', 
											  		 '$_POST[tprodi]')
											 ");
			if($simpan)
			{
				echo "<script>
						alert('Save Data Success');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Save Data Failed');
						document.location='index.php'
					 </script>";
			}
		}
		
	}

	//pengujian jika tombol edit atau delete di klik
	if(isset($_GET['hal']))
	{
		//pengujian jika edit data
		if($_GET['hal'] == "edit")
		{
			//tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ditemukan ditampung ke variable
				$vnim = $data['nim'];
				$vnama = $data['nama'];
				$valamat = $data['alamat'];				
				$vprodi = $data['prodi'];
			}
		}
		else if($_GET['hal'] == "hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Delete Data Success');
						document.location='index.php'
					 </script>";
			}
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD Table Input</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="styleindex.css">
</head>
<body>
<div class="container mt-4">

	<font color="black" style="font-family: Monserrat">
		<h1 class="text-center">Website Murid SMK Telkom Purwokerto Tahun 2020/2021</h1>
		<h2 class="text-center">Abid Ganteng Banget (XI RPL 3)</h2>
	</font>

	<!-- AWAL CARD FORM -->
	<div class="card mt-5">
	  <div class="card-header bg-success text-white">
	    SMK Telkom Purwokerto Input Murid
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<lable>ID Murid</lable>
	    		<input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Tekan ID Number Disini...!!!" required="">
	    	</div>
	    	<div class="form-group">
	    		<lable>Nama Murid</lable>
	    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Tekan Nama mu Disini!!" required="">
	    	</div>
	    	<div class="form-group">
	    		<lable>Alamat Murid</lable>
	    		<textarea class="form-control" name="talamat"  placeholder="Tekan Alamat Anda"><?=@$valamat?></textarea>
	    	</div>
	    	<div class="form-group">
	    		<lable>Jurusan Murid</lable>
	    		<select class="form-control" name="tprodi">
	    			<option value="<?=@$vprodi?>"><?=@$vprodi?></option>
	    			<option value="TKJ">TKJ (TEKNIK KOMPUTER JARINGAN)</option>
	    			<option value="TJA">TJA (TEKNIK JARINGAN AKSES)</option>
	    			<option value="MULTIMEDIA">MULTIMEDIA</option>
	    			<option value="RPL">RPL (REKAYASA PERANGKAT LUNAK)</option>
	    			<option value="TEKNIK MESIN">TEKNIK MESIN</option>
	    			<option value="ELETRO">ELETRO</option>
	    			<option value="GAMING">GAMING</option>
	    			<option value="KEDOKTERAN">KEDOKTERAN</option>
	    			<option value=">TKJ">TKJ (TEKNIK KOMPUTER JARINGAN)</option>
	    			<option value="TKRO (TEKNIK KENDARAAN RINGAN OTOMOTIF)">TKRO (TEKNIK KENDARAAN RINGAN OTOMOTIF)</option>
	    		</select>
	    	</div>

			<button type="submit" class="btn btn-warning text-white" name="bsave">Kirim</button>
			<button type="reset" class="btn btn-success" name="breset">Set Ulang Form</button>

	    </form>
	  </div>
	</div>
	<!-- AKHIR CARD FORM -->

		<!-- AWAL CARD TABEL -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white font-18pt">
	    List Nama Murid
	  </div>
	  <div class="card-body">
	   
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>No</th>
	  			<th>ID MURID</th>
	  			<th>Nama Murid</th>
	  			<th>Alamat Murid</th>
	  			<th>Jurusan Murid</th>
	  			<th>Perintah</th>
	  		</tr>
	  		<?php
	  			$no = 1; 
	  			$tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
	  			while ($data = mysqli_fetch_array($tampil)) :
	  		 ?>
	  		<tr>
	  			<td><?=$no++;?></td>
	  			<td><?=$data['nim'];?></td>
	  			<td><?=$data['nama'];?></td>
	  			<td><?=$data['alamat'];?></td>
	  			<td><?=$data['prodi'];?></td>
	  			<td>
	  				<a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-success">Edit Dong</a>
	  				<a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?') " class="btn btn-warning">Hapus Dong</a>
	  			</td>

	  		</tr>
	  	<?php endwhile; //penutup perulangan while?>
	  	</table>

	  </div>
	</div>
	<!-- AKHIR CARD TABEL -->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<footer class="mt-4">
		<div class="container">
			<small>
				Copyright &copy; 1980- Abid Ganteng Sekali.All Right Reserved
			</small>
		</div>
	</footer>


	<script type="text/javascript">
		$(document).ready(function(){
			$(".bg-loader").hide();
		})
	</script>

</body>
</html>