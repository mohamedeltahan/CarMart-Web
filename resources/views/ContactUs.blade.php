<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GPless</title>
    <link  rel="shortcut icon" href="{{asset("assets/images/logo.ico")}}" />
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset("assets/vendors/mdi/css/materialdesignicons.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/vendors/css/vendor.bundle.base.css")}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/014e2f671f.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">
    <!-- End layout styles -->
    <link rel="stylesheet" href="{{asset("assets/css/CrudStyle.css")}}">

  </head>

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
  <body>
     @if($errors->any())
     <input id="error-box" value="{{$errors->first()}}" class="d-none">         
     @endif
    <i class="fa fa-angle-double-up temppromote promote" aria-hidden="true"></i>
	<i class="fa fa-angle-double-down tempunpromote unpromote" aria-hidden="true"></i>
    <input value="{{route("contactus.update","X")}}" id="contactusupdate" class="d-none">

    <input value="0" id="DataTableIntialized" class="d-none">

	

	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="{{route("contactus.destroy","")}}">
			@method("delete")
			@csrf
			<button type="submit" id="SubmitDelete">
		</form>
	</div>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include("includes.navbar")
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
       @include("includes.sidebar")
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset("assets/images/dashboard/circle.svg")}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Contact Us <i class="mdi mdi-source-branch  mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"></h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset("assets/images/dashboard/circle.svg")}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Responded<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"></h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset("assets/images/dashboard/circle.svg")}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Emails <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"></h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-4">
					<a href="{{route("contactus.index")}}" style="color: white">	<h2>Manage <b>Contact Us</b></h2> </a>
					</div>
					<div class="col-sm-4 d-none">
						<form method="GET" action="{{route("branches.search")}}">
						  <div class="input-group mb-3">
							 <input type="text" @if(isset($value)) value="{{$value}}" @endif name="value" class="form-control" placeholder="Enter Branch Title"  aria-describedby="basic-addon2">
							 <div class="input-group-append">
							   <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i>
							   </button>
							 </div>
						  </div>
						</form>
					</div>
					<div class="col-sm-4 d-none">
						<a href="#AddBranchModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Branch</span></a>
					</div>
				</div>
			</div>
		@if($errors->any())
          <input id="error-box" value="{{$errors->first()}}" class="d-none"> 
    @endif

			<table class="table table-striped table-hover" style="text-align: center"  id="MainTable"> 
				<thead>
					<tr>
						<th>name</th>
						<th>email</th>
						<th>phone</th>
						<th>title</th>
            <th>description</th>
            <th>response</th>
            <th>respond</th>
						<th>delete</th>
					
					</tr>
				</thead>
				<tbody>
		
					@foreach($contacts["data"] as $contact)				
					<tr data-id={{$contact["id"]}}>
				
						
						<td class="name">{{$contact["name"]}}</td>
						<td class="email">{{$contact["email"]}}</td>
						<td class="phone">{{$contact["phone"]}}</td>
						<td class="title">{{$contact["title"]}}</td>
            <td class="description">{{$contact["description"]}}</td>
            <td class="response">{{$contact["response"]}}</td>

            <td><i class="fa fa-comments respond_row" data-toggle="modal" href="#respond-Modal" aria-hidden="true"></i></td>
            <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeleteContactUsModal" aria-hidden="true"></i></td>



					
					</tr> 
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="hint-text">Showing <b>{{$contacts["per_page"]}}</b> out of <b>{{$contacts["total"]}}</b> entries</div>
				<ul class="pagination">
          @foreach($contacts["links"] as $url)
          
            <li class="page-item @if($url["active"]==true) active @endif" ><a class="page-link"  href="{{$url["url"]}}">
              @if($url["label"]=="&laquo; Previous")
              back
              @elseif($url["label"]=="Next &raquo;")
              next
              @else
              {{$url["label"]}}

              @endif
            </a>
          
          </li>
         @endforeach
         
			
				</ul>
			</div>
		</div>
	</div>        
</div>
            </div>
          </div>
          <!-- content-wrapper ends -->

            <!-- Users Modal --!>


            <div id="respond-Modal" class="modal fade">
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <form id="updateform" method="post" action="" enctype="multipart/form-data">
                            @csrf
                            @method("put")
                            <div class="modal-header">						
                                <h4 class="modal-title">Respond</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body" >	
                                 
                                <div class="form-row">
                                    <div class="col-sm-12">
                                      <label>Message</label>
                                      <textarea type="text" id="message" readonly class="form-control"  placeholder=""  ></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                  <div class="col-sm-12">
                                    <label>Response</label>
                                    <span class="astric">&#42;</span>
                                    <textarea required type="text" id="response" name="response" class="form-control"  placeholder=""  ></textarea>
                                  </div>
                              </div>
                                    
                        
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="btn btn-success" value="Send">
                            </div>
                        </form>
                    </div>
                </div>
          </div>

                <!-- Add Modal HTML -->
                <div id="AddBranchModal" class="modal fade">
                    <div class="modal-dialog" >
                        <div class="modal-content">
                            <form method="post" action="{{route("branches.store")}}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">						
                                    <h4 class="modal-title">Add Branch</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body" >	
                                     
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                          <label>Name</label>
                                          <input type="text" name="name" class="form-control"  placeholder=""  >
                                        </div>
                                        <div class="col-sm-6">
                                          <label>City</label>
                                          <input type="text" name="city" class="form-control" placeholder=""  >
                                        </div>
                                    </div>			
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <label>Longitude</label>
                                            <input type="text" name="longitude" class="form-control" placeholder=""  >
                                          </div>
                                        <div class="col-sm-6">
                                          <label>Latitude</label>
                                          <input type="text" name="latitude" class="form-control"  placeholder=""  >
                                        </div>
                                    </div>	
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder=""  >
                                          </div>
                                        <div class="col-sm-6">
                                          <label>Address</label>
                                          <input type="text" name="address" class="form-control"  placeholder=""  >
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
                <div id="EditBranchModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="EditForm" method="post" data-link="{{route("branches.update","")}}" action="" enctype="multipart/form-data">
                                @csrf
                                @method("put")
                                <div class="modal-header">						
                                    <h4 class="modal-title">Edit Category</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">					
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                          <label>Name</label>
                                          <input type="text" name="name" class="form-control"  placeholder=""  >
                                        </div>
                                        <div class="col-sm-6">
                                          <label>City</label>
                                          <input type="text" name="city" class="form-control" placeholder=""  >
                                        </div>
                                    </div>			
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <label>Longitude</label>
                                            <input type="text" name="longitude" class="form-control" placeholder=""  >
                                          </div>
                                        <div class="col-sm-6">
                                          <label>Latitude</label>
                                          <input type="text" name="latitude" class="form-control"  placeholder=""  >
                                        </div>
                                    </div>	
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder=""  >
                                          </div>
                                        <div class="col-sm-6">
                                          <label>Address</label>
                                          <input type="text" name="address" class="form-control"  placeholder=""  >
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
                <div id="DeleteContactUsModal" class="modal fade DeleteModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form>
                                <div class="modal-header">						
                                    <h4 class="modal-title">Delete ContactUs</h4>
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
                        
            
            
         <!-- partial:partials/_footer.html -->
         @include("includes.footer")
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <!-- endinject -->
    <!-- Plugin js for this page -->
    @include("includes.dashboardscripts")
    <!-- End custom js for this page -->
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
        
        
    
    
    
    
      $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
      })

      $(document).on("click",".respond_row",function(){

        var targeted_row=$(this).parent().parent();
        var id=targeted_row.attr("data-id");
        var description=targeted_row.find(".description").text();
        var response=targeted_row.find(".response").text();
        var title=targeted_row.find(".title").text();
        $("#message").val(title);
        var url=$("#contactusupdate").val();
        var res = url.replace("X", id);
        $("#response").val(response);
        $("#updateform").attr("action",res);





      })

    
    
    $(document).on("click",".edit_row",function(){
      var targeted_row=$(this).parent().parent();
      var id=targeted_row.attr("data-id");
      
      var name=targeted_row.find(".name").text();
      var phone=targeted_row.find(".phone").text();
      var city=targeted_row.find(".city").text();
      var address=targeted_row.find(".address").text();
      var longitude=targeted_row.find(".longitude").text();
      var latitude=targeted_row.find(".latitude").text();
    
        
     
      $("#EditBranchModal").find("input[name=name]").val(name);
      $("#EditBranchModal").find("input[name=longitude]").val(longitude);
      $("#EditBranchModal").find("input[name=latitude]").val(latitude);
      $("#EditBranchModal").find("input[name=city]").val(city);
      $("#EditBranchModal").find("input[name=address]").val(address);
      $("#EditBranchModal").find("input[name=phone]").val(phone);
      
     
      $("#EditForm").attr("action",$("#EditForm").attr("data-link")+"/"+id);
    
      
    });
    
    $(document).on("click",".delete_row",function(){
        var targeted_row=$(this).parent().parent();
        var id=targeted_row.attr("data-id");
        $("#DeleteForm").attr("action",$("#DeleteForm").attr("data-link")+"/"+id);
    
    
    
    });
    
    
    $(".ConfirmDelete").click(function(){
       
        $("#DeleteForm").find("#SubmitDelete").click();
    });
    
    
    });
    
    </script>
  </body>
</html>