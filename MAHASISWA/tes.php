<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Login Mahasiswa</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">


</head>

<style>
    body {
        background: url(image/home.jpg) no-repeat fixed;
        -webkit-background-size: 100% 100%;
        -moz-background-size: 100% 100%;
        -o-background-size: 100% 100%;
        background-size: 100% 100%;
    }
</style>
<html>

<body>
    <div id="login">
        <h3 style="margin-bottom: 30px;" class="text-center text-white pt-5">Login Form</h3>
        <div class="container">
            <div class="card-body card-block">
	<table class="table table-bordered" id="tabelArtikel">
		<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">First</th>
			<th scope="col">Last</th>
			<th scope="col">Handle</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th scope="row">1</th>
			<td>Mark</td>
			<td>Otto</td>
			<td>@mdo</td>
		</tr>
		<tr>
			<th scope="row">2</th>
			<td>Jacob</td>
			<td>Thornton</td>
			<td>@fat</td>
		</tr>
		<tr>
			<th scope="row">3</th>
			<td colspan="2">Larry the Bird</td>
			<td>@twitter</td>
		</tr>
		</tbody>
	</table>
</div>



<div class="col-12 col-md-9"><textarea class="form-control summernote" name="textarea-input" id="textarea-input" rows="9" placeholder="Content..." class="form-control"></textarea></div>
        </div>
    </div>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabelArtikel').DataTable();
    } );
</script>
