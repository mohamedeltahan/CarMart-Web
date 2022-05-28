<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/014e2f671f.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>


<style>
body {
	color: #566787;
	background: #f5f5f5;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
}
.table-responsive {
    margin: 30px 0;
}
.table-wrapper {
	background: #fff;
	padding: 20px 25px;
	border-radius: 3px;
	min-width: 1000px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {        
	padding-bottom: 15px;
	background: #435d7d;
	color: #fff;
	padding: 16px 30px;
	min-width: 100%;
	margin: -20px -25px 10px;
	border-radius: 3px 3px 0 0;
}
.table-title h2 {
	margin: 5px 0 0;
	font-size: 24px;
}
.table-title .btn-group {
	float: right;
}
.table-title .btn {
	color: #fff;
	float: right;
	font-size: 13px;
	border: none;
	min-width: 50px;
	border-radius: 2px;
	border: none;
	outline: none !important;
	margin-left: 10px;
}
.table-title .btn i {
	float: left;
	font-size: 21px;
	margin-right: 5px;
}
.table-title .btn span {
	float: left;
	margin-top: 2px;
}
table.table tr th, table.table tr td {
	border-color: #e9e9e9;
	padding: 12px 15px;
	vertical-align: middle;
}
table.table tr th:first-child {
	width: 60px;
}
table.table tr th:last-child {
	width: 100px;
}
table.table-striped tbody tr:nth-of-type(odd) {
	background-color: #fcfcfc;
}
table.table-striped.table-hover tbody tr:hover {
	background: #f5f5f5;
}
table.table th i {
	font-size: 13px;
	margin: 0 5px;
	cursor: pointer;
}	
table.table td:last-child i {
	opacity: 0.9;
	font-size: 22px;
	margin: 0 5px;
}
table.table td a {
	font-weight: bold;
	color: #566787;
	display: inline-block;
	text-decoration: none;
	outline: none !important;
}
table.table td a:hover {
	color: #2196F3;
}
table.table td a.edit {
	color: #FFC107;
}
table.table td a.delete {
	color: #F44336;
}
table.table td i {
	font-size: 19px;
}
table.table .avatar {
	border-radius: 50%;
	vertical-align: middle;
	margin-right: 10px;
}
.pagination {
	float: right;
	margin: 0 0 5px;
}
.pagination li a {
	border: none;
	font-size: 13px;
	min-width: 30px;
	min-height: 30px;
	color: #999;
	margin: 0 2px;
	line-height: 30px;
	border-radius: 2px !important;
	text-align: center;
	padding: 0 6px;
}
.pagination li a:hover {
	color: #666;
}	
.pagination li.active a, .pagination li.active a.page-link {
	background: #03A9F4;
}
.pagination li.active a:hover {        
	background: #0397d6;
}
.pagination li.disabled i {
	color: #ccc;
}
.pagination li i {
	font-size: 16px;
	padding-top: 6px
}
.hint-text {
	float: left;
	margin-top: 10px;
	font-size: 13px;
}    
/* Custom checkbox */
.custom-checkbox {
	position: relative;
}
.custom-checkbox input[type="checkbox"] {    
	opacity: 0;
	position: absolute;
	margin: 5px 0 0 3px;
	z-index: 9;
}
.custom-checkbox label:before{
	width: 18px;
	height: 18px;
}
.custom-checkbox label:before {
	content: '';
	margin-right: 10px;
	display: inline-block;
	vertical-align: text-top;
	background: white;
	border: 1px solid #bbb;
	border-radius: 2px;
	box-sizing: border-box;
	z-index: 2;
}
.custom-checkbox input[type="checkbox"]:checked + label:after {
	content: '';
	position: absolute;
	left: 6px;
	top: 3px;
	width: 6px;
	height: 11px;
	border: solid #000;
	border-width: 0 3px 3px 0;
	transform: inherit;
	z-index: 3;
	transform: rotateZ(45deg);
}
.custom-checkbox input[type="checkbox"]:checked + label:before {
	border-color: #03A9F4;
	background: #03A9F4;
}
.custom-checkbox input[type="checkbox"]:checked + label:after {
	border-color: #fff;
}
.custom-checkbox input[type="checkbox"]:disabled + label:before {
	color: #b8b8b8;
	cursor: auto;
	box-shadow: none;
	background: #ddd;
}
/* Modal styles */
.modal:not(#DeleteUserModal) .modal-dialog {
	max-width: 71%;
}
.modal .modal-header, .modal .modal-body, .modal .modal-footer {
	padding: 20px 30px;
}
.modal .modal-content {
	border-radius: 3px;
	font-size: 14px;
}
.modal .modal-footer {
	background: #ecf0f1;
	border-radius: 0 0 3px 3px;
}
.modal .modal-title {
	display: inline-block;
}
.modal .form-control {
	border-radius: 2px;
	box-shadow: none;
	border-color: #dddddd;
}
.modal textarea.form-control {
	resize: vertical;
}
.modal .btn {
	border-radius: 2px;
	min-width: 100px;
}	
.modal form label {
	font-weight: 900;
}	

.form-row {
margin-bottom: 10px;

}
</style>
<script>
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
</script>
</head>
<body>

	

	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="{{route("users.destroy","")}}">
			@method("delete")
			@csrf
			<button type="submit" id="SubmitDelete">
		</form>
	</div>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-4">
					<a href="{{route("users.index")}}" style="color: white">	<h2>Manage <b>Users</b></h2> </a>
					</div>
					<div class="col-sm-4">
						<form method="GET" action="{{route("users.search")}}">
						  <div class="input-group mb-3">
							 <input type="text" @if(isset($value)) value="{{$value}}" @endif name="value" class="form-control" placeholder="Enter User Info"  aria-describedby="basic-addon2">
							 <div class="input-group-append">
							   <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i>
							   </button>
							 </div>
						  </div>
						</form>
					</div>
					<div class="col-sm-4">
						<a href="#AddUserModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
					</div>
				</div>
			</div>
		@if($errors->any())
          <input id="error-box" value="{{$errors->first()}}" class="d-none">          </div>
         @endif

			<table class="table table-striped table-hover" style="text-align: center"  id="MainTable"> 
				<thead>
					<tr>
						<th>full name</th>
						<th>account name</th>
						<th>phone</th>
						<th>account type</th>
						<th>category title</th>
                        <th>featured</th>
                        <th>premuim</th>
						<th>promo code</th>
                        <th>email</th>
						<th>photo link</th>
						<th>edit</th>
						<th>delete</th>

					</tr>
				</thead>
				<tbody>
		
			
				</tbody>
			</table>
		
		</div>
	</div>        
</div>
<!-- Add Modal HTML -->
<div id="AddUserModal" class="modal fade">
	<div class="modal-dialog" style="width: 85%">
		<div class="modal-content">
            <form  method="post" action="{{route("users.store")}}">
				@csrf
				<div class="modal-header">						
					<h4 class="modal-title">Add User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
                        <div class="form-row">
                            <div class="col-sm-6 Admin Vendor Normal">
                                <label for="validationDefault01">Account Type</label>
                                <select name="account_type" class="form-control SelectType">
                                    <option value="0">Choose Account Type</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Vendor">Vendor</option>
                                    <option value="Normal">Normal</option>
                                </select>
                             </div>
                            <div class="col-sm-6 Admin Vendor Normal">
                              <label for="validationDefault02">Account Name</label>
                              <input type="text" name="account_name" class="form-control" id="validationDefault01" placeholder=""  >
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-sm-6 Admin Vendor Normal">
                              <label for="validationDefault02">email</label>
                              <input type="text" name="email" class="form-control" id="validationDefault01" placeholder=""  >
                            </div>
                            <div class="col-sm-6 Admin Vendor Normal">
                              <label for="validationDefault02">full name</label>
                              <input type="text" name="full_name" class="form-control" id="validationDefault01" placeholder=""  >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-sm-6  Vendor Normal">
                              <label for="validationDefault01">Phone</label>
                              <input type="text" name="phone" class="form-control" id="validationDefault01" placeholder=""  >
                            </div>
                            <div class="col-sm-6  Vendor Normal">
                              <label for="validationDefault02">Address</label>
                              <input type="text" name="address" class="form-control" id="validationDefault01" placeholder=""  >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-sm-6 Vendor">
                                <label for="validationDefault01">featured</label>
								<select name="featured" class="form-control SelectFeature">
                                    <option value="0">unblock</option>
                                    <option value="1">block</option>
                                </select>                              
                            </div>
                            <div class="col-sm-6  Vendor">
                              <label for="validationDefault02">Category Title</label>
                              <input type="text" name="category_title" class="form-control" id="validationDefault01" placeholder=""  >
                            </div>
                        </div>


            
                        <div class="form-row">
                            <div class="col-sm-6 Admin Vendor Normal ">
                              <label for="validationDefault02">password</label>
                              <input type="text" name="password" class="form-control"placeholder=""  >
                            </div>
                            <div class="col-sm-6 Admin Vendor Normal ">
                                <label for="validationDefault02">confirm password</label>
                                <input type="text" name="password_confirmation" class="form-control" >
                            </div>
                        </div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Edit Modal HTML -->
<div id="EditUserModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="EditForm" method="post" data-link="{{route("users.update","")}}" action="" enctype="multipart/form-data">
				@csrf
				@method("put")
				<div class="modal-header">						
					<h4 class="modal-title">Edit User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-row">
						<div class="col-sm-6 Vendor Admin Normal">
							<label for="validationDefault01">Account Type</label>
							<select name="account_type" class="form-control SelectTypeEditModal" disabled>
								<option value="Admin">Admin</option>
								<option value="Vendor">Vendor</option>
								<option value="Normal">Normal</option>
							</select>
						 </div>
						<div class="col-sm-6 Vendor Admin Normal" >
						  <label for="validationDefault02">Account Name</label>
						  <input type="text" name="account_name" class="form-control" disabled>
						</div>
					</div>
					
					<div class="form-row">
						<div class="col-sm-6 Admin Vendor Normal">
						  <label for="validationDefault02">email</label>
						  <input type="text" name="email" class="form-control">
						</div>
						<div class="col-sm-6 Admin Vendor Normal">
						  <label for="validationDefault02">full name</label>
						  <input type="text" name="full_name" class="form-control">
						</div>
					</div>

					<div class="form-row">
						<div class="col-sm-6  Vendor Normal">
						  <label for="validationDefault01">Phone</label>
						  <input type="text" name="phone" class="form-control">
						</div>
						<div class="col-sm-6  Vendor Normal">
						  <label for="validationDefault02">Address</label>
						  <input type="text" name="address" class="form-control">
						</div>
					</div>

					<div class="form-row">
						<div class="col-sm-6 Vendor">
							<label for="validationDefault01">featured</label>
							<select name="featured" class="form-control SelectFeature">
								<option value="0">feature</option>
								<option value="1">unfeature</option>
							</select> 
						  
						</div>
						<div class="col-sm-6  Vendor">
						  <label for="validationDefault02">Category Title</label>
						  <input type="text" name="category_title" class="form-control">
						</div>

					</div>

					<div class="form-row">
						<div class="col-sm-6 Normal">
							<label>premuim</label>
							<select name="premuim" class="form-control SelectPremuim">
								<option value="0">normal</option>
								<option value="1">premuim</option>
							</select> 
						  
						</div>
						<div class="col-sm-6  Vendor Admin Normal">
							<label>blocked</label>
							<select name="blocked" class="form-control SelectState">
								<option value="0">unblock</option>
								<option value="1">block</option>
							</select> 
						</div>
					</div>


		
					<div class="form-row">
						<div class="col-sm-6 Admin Vendor Normal">
						  <label for="validationDefault02">password</label>
						  <input type="text" name="password" class="form-control">
						</div>
						<div class="col-sm-6 Admin Vendor Normal ">
							<label for="validationDefault02">confirm password</label>
							<input type="text" name="password_confirmation" class="form-control">
						</div>
						<div class="col-sm-6  Vendor">
							<label for="validationDefault02">Category Title</label>
							<input type="text" name="category_title" class="form-control">
						  </div>
					</div>
			
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Delete Modal HTML -->
<div id="DeleteUserModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="button" class="btn btn-danger ConfirmDelete" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function ajaxFunction(object, url, method) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		if($.ajax({
			url: url,
			type: method,
			//request data
			data: object,
			success: function (result) {
				return true;
			},
			error: function (data) {
				alert('Error on updating, please try again later!');
				return false;
			}
		}))
			return true;
		else
			return false;
	};
	


</script>
</body>
</html>