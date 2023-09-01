<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Async Await Crud </title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/index.css">
	<script src="js/index.js" defer></script>

<body>
	<div class="container">
		<div class="name">
			<p class="white"> Created By &#10084; Abdul Rehman Laravel </p>
		</div>
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6 flexboxStart">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
								class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>

					</div>
					<div class="col-sm-6 flexboxEnd">
						<form class="flex" role="search">
							<input class="form-control me-2 inputSearch" type="search" placeholder="Search"
								aria-label="Search">
							<button class="btn searchBtn" type="submit">Search</button>
						</form>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>

						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Age</th>
						<th>City</th>
						<th>Image</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class="tabelBody">


					{{-- <tr>
						<td>name</td>
						<td>name</td>
						<td>name</td>
						<td>name</td>
						<td>name</td>
						<td>name</td>
						<td>
							<img src="https://avatars.githubusercontent.com/u/99328965?v=4" class="student_img" alt="">
						</td>
						<td>
							<a href="#editEmployeeModal" class="edit" data-toggle="modal" data-id="name"><i
									class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="name"><i
									class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr> --}}

				</tbody>


			</table>
			<h1 class="no-record mt-5">
				No Record Found
		</div>
		<div class="pagination">
			<div id="loadingMessage" style="display: none;" class="my-2 text-center">Loading...</div>

			<button id="showMoreButton" class="btn btn-success mt-5">Show More</button>
		</div>

	</div>


	</div>
	<!-- Edit Modal HTML -->
	<div id="addEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					@csrf
					<div class="modal-header">
						<h4 class="modal-title">Add Employee</h4>
						<button type="button" class="close   " data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control addName  @error('addName') is-invalid @enderror"
								required>
							@error('name')
							{{$message}}
							@enderror
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control addEmail  @error('addEmail') is-invalid @enderror"
								required>
							@error('addEmail')
							{{$message}}
							@enderror
						</div>
						<div class="form-group">
							<label>Role</label>
							<input type="text" class="form-control addRole  @error('addRole') is-invalid @enderror"
								required>
							@error('addRole')
							{{$message}}
							@enderror
						</div>
						<div class="form-group">
							<label>Age</label>
							<input type="number" class="form-control addAge  @error('addAge') is-invalid @enderror "
								required>
							@error('addAge')
							{{$message}}
							@enderror
						</div>
						<div class="form-group">
							<label>city</label>
							<input type="text" class="form-control addCity  @error('addCity') is-invalid @enderror"
								required>
							@error('addCity')
							{{$message}}
							@enderror
						</div>
						<div class="form-group">
							<label>Image</label>
							<input type="file" name="addImage" class="addImage  @error('addImage') is-invalid @enderror">
							@error('addImage')
							{{$message}}
							@enderror

						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success addEmploye" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					@csrf
					<div class="modal-header">
						<h4 class="modal-title">Update Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control updateName" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control updateEmail" required>
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control updateDes" required></textarea>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control updatePhone" required>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info updateEmp" value="Update">
						<input type="hidden" name="" id="updateUnique">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					@csrf
					<div class="modal-body">
						<p>Are you sure you want to delete this record?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="hidden" id="uniqueId">
						<button type="button" class="btn btn-danger  unique" data-dismiss="modal">Delete</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- for background  -->
	<div class="background">
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
		<span></span>
	</div>






	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.js"
		integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
	<script>
		window.routes = @json([
        'fetchData' => route('fetchData'),
        'insertData' => route('insertData')
            
	    ]);

	</script>
</body>

</html>