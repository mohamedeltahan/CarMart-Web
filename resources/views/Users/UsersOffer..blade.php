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

<link rel="stylesheet" href="css/CrudStyle.css">


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
		
					@foreach($users as $user)				
					<tr data-id={{$user->id}} data-verified="{{$user->verified}}"  data-blocked="{{$user->blocked}}" data-address="{{$user->address}}" data-longitude="{{$user->longitude}}" data-longitude="{{$user->latitude}}">
                        <td class="full_name">{{$user->full_name}}</td>
                        <td class="account_name">{{$user->account_name}}</td>
						<td class="phone">{{$user->phone}}</td>
                        <td class="account_type">{{$user->account_type}}</td>
						<td class="category_title">{{$user->category_title}}</td>
						<td class="featured">{{$user->featured}}</td>
						<td class="premuim">{{$user->premuim}}</td>
						<td class="promo_code">{{$user->promo_code}}</td>
						<td class="email">{{$user->email}}</td>
						<td class="image"><img src="{{asset("users-photos/".$user->photo_link)}}" style="max-width:70px"></td>
						<td ><i class="fa fa-pencil-square-o edit_row" href="#EditUserModal"  data-toggle="modal" aria-hidden="true"></i></td>
						<td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeleteUserModal" aria-hidden="true"></i></td>
					</tr> 
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="hint-text">Showing <b>{{sizeof($users)}}</b> out of <b>{{$count}}</b> entries</div>
				<ul class="pagination">
					
					@for($i=0;$i<$no_of_pages;$i++)
                        @if($i+1==$index)
                        <li class="page-item active" aria-current="page">
                               <span class="page-link">
                                      {{$index}}
                                   <span class="sr-only">(current)</span>
                               </span>
                        </li>
                        @continue
                        @endif
                       <li class="page-item"><a class="page-link" href="{{route("users.index")}}?index={{$i+1}}">{{$i+1}}</a></li>

                    @endfor
				</ul>
			</div>
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
                            <div class="col-sm-6  Vendor">
                              <label for="validationDefault02">latitude</label>
                              <input type="text" name="latitude" class="form-control" id="validationDefault01" placeholder=""  >
                            </div>
                            <div class="col-sm-6  Vendor">
                              <label for="validationDefault02">longitude</label>
                              <input type="text" name="longitude" class="form-control" id="validationDefault01" placeholder=""  >
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
						<div class="col-sm-6  Vendor">
						  <label for="validationDefault02">latitude</label>
						  <input type="text" name="latitude" class="form-control" id="validationDefault01" placeholder=""  >
						</div>
						<div class="col-sm-6  Vendor">
						  <label for="validationDefault02">longitude</label>
						  <input type="text" name="longitude" class="form-control" id="validationDefault01" placeholder=""  >
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
	
	};
	var obj={};
	obj.grant_type='password';
	obj.client_id=4;
	obj.client_secret='bOyzB3WdqobhyrnBwjHzPrB0eObub8JFB2xWXGzs';
	obj.username='mohamedtahan24@gmail.com';
	obj.password='12345678';


	ajaxFunction(obj,"http://localhost/project/public/oauth/token","post");
	function Fill_NewSubgroup(data,to_insert_before_or_after_class,position){
		var temp=$(".AddNewSubgroup").clone();
		temp.find("input").val(data)
		temp.removeClass("d-none");
		temp.addClass("extra_subcategory");
		temp.removeClass("AddNewSubgroup");
		if(position=="before"){
			temp.insertBefore("."+to_insert_before_or_after_class);
		}
		else if(position=="after"){
			temp.insertAfter("."+to_insert_before_or_after_class);

		}
	}
	

	
	$(document ).ready(function() {
       if($("#error-box").length){
		 alert($("#error-box").val());
	   };

	  $("#MainTable").DataTable({
		"paging":   false,

		aaSorting: [],
		"language": {
			"lengthMenu":  "",
			"zeroRecords": "there is no records matching this word",
			"info":  "",
			"infoEmpty": "",
			"infoFiltered": "",
			 

		}



	});
	
	



  $(".AddNewSubgroupButton").click(function(){
    var targeted_class=$(this).attr("data-class");
	Fill_NewSubgroup(null,targeted_class,"before");
  });

  $(document).on("click",".DeleteSubCategory",function(){
	  alert("sub category deleted");
	  $(this).parent().remove();
  });

  $('.modal').on('hidden.bs.modal', function () {
	$(this).find('form').trigger('reset');
	$(".extra_subcategory").remove();
  })


$(document).on("click",".edit_row",function(){
  var targeted_row=$(this).parent().parent();
  var id=targeted_row.attr("data-id");
  
  var account_name=targeted_row.find(".account_name").text();

  var full_name=targeted_row.find(".full_name").text();
  var account_type=targeted_row.find(".account_type").text();
  ChangeEditModal(account_type);
  var phone=targeted_row.find(".phone").text();
  var category_title=targeted_row.find(".category_title").text();
  var featured=targeted_row.find(".featured").text();
  var premuim=targeted_row.find(".premuim").text();
  var promo_code=targeted_row.find(".promo_code").text();
  var address=targeted_row.attr("data-address");
  var verified=targeted_row.attr("data-verified");
  var blocked=targeted_row.attr("data-blocked");
  var email=targeted_row.find(".email").text();
  var longitude=targeted_row.attr("data-longitude");
  var latitude=targeted_row.attr("data-longitude");

  
 
  $("#EditUserModal").find("input[name=account_name]").val(account_name);
  $("#EditUserModal").find("input[name=longitude]").val(longitude);
  $("#EditUserModal").find("input[name=latitude]").val(latitude);

  $("#EditUserModal").find("input[name=full_name]").val(full_name);
  $("#EditUserModal").find("select[name=account_type]").val(account_type);
  $("#EditUserModal").find("input[name=phone]").val(phone);
  $("#EditUserModal").find("input[name=category_title]").val(category_title);
  $("#EditUserModal").find("input[name=premuim]").val(premuim);
  $("#EditUserModal").find("input[name=promo_code]").val(promo_code);
  $("#EditUserModal").find("input[name=email]").val(email);
  $("#EditUserModal").find("input[name=address]").val(address);
  $("#EditUserModal").find("select[name=blocked]").val(blocked);
  $("#EditUserModal").find("select[name=featured]").val(featured);
  $("#EditUserModal").find("select[name=featured]").val(featured);


  $("#EditForm").attr("action",$("#EditForm").attr("data-link")+"/"+id);

  
});

$(document).on("click",".delete_row",function(){
	var targeted_row=$(this).parent().parent();
	var id=targeted_row.attr("data-id");
	$("#DeleteForm").attr("action",$("#DeleteForm").attr("data-link")+"/"+id);



});

function ChangeEditModal(account_type){

	
		$("#EditUserModal").find(".col-sm-6").addClass("d-none");
		$("#EditUserModal").find(".col-sm-6").find("input").prop("disabled","true");
	
		$("#EditUserModal").find("."+account_type).removeClass("d-none");
		$("#EditUserModal").find("."+account_type).find("input").removeAttr("disabled");
	
   


}
$(".ConfirmDelete").click(function(){
   
	$("#DeleteForm").find("#SubmitDelete").click();
});
$(document).on("change",".SelectType",function(){
    if($(this).val()!=0){
    $("#AddUserModal").find(".col-sm-6").addClass("d-none");
    $("#AddUserModal").find(".col-sm-6").find("input").prop("disabled","true");

    $("#AddUserModal").find("."+$(this).val()).removeClass("d-none");
    $("#AddUserModal").find("."+$(this).val()).find("input").removeAttr("disabled");

    }
});




});

</script>
</body>
</html>