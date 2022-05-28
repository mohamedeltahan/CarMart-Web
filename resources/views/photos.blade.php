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
   <style>
    .table th img, .table td img{

        height: 170px;
        width: 170px;
        
        }

    .hint-text{

      display: none;
    }

    .table th img, .table td img{
        border-radius: 6px;
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
  <body>
  @if($errors->any())
     <input id="error-box" value="{{$errors->first()}}" class="d-none">         
  @endif
  <i class="fa fa-angle-double-up temppromote promote" aria-hidden="true"></i>
	<i class="fa fa-angle-double-down tempunpromote unpromote" aria-hidden="true"></i>
  <input value="0" id="DataTableIntialized" class="d-none">

	
  <!---temp subcategory to add it to Form and fill it  --->
	<div class="form-group d-none AddNewSubgroup">
		<label style="display: block">sub category</label>
		<input class="form-control" type="text" name="sub_categories[]" style="display: inline; width:95%" >
	    <i class="fa fa-times DeleteSubCategory"  aria-hidden="true" style="color: red" title="Delete Sub Category"></i>
	</div>

	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" method="post" action="{{route("photos.destroy")}}">
			@method("delete")
      @csrf
      <input class="d-none" name="path" id="path" value="">
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
                    <h4 class="font-weight-normal mb-3"><a href="{{route("photos.index","icons")}}" style="color: white">Icons</a><i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>

                    <h2 class="mb-5">{{sizeof(Storage::disk('public')->allFiles("icons"))}}</h2>
                    <h6 class="card-text">photo</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset("assets/images/dashboard/circle.svg")}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"><a href="{{route("photos.index","today")}}" style="color: white">Whats in today</a><i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{sizeof(Storage::disk('public')->allFiles("today"))}}</h2>
                    <h6 class="card-text">photo</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset("assets/images/dashboard/circle.svg")}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"><a href="{{route("photos.index","banners")}}" style="color: white">Banners</a><i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{sizeof(Storage::disk('public')->allFiles("banners"))}}</h2>
                    <h6 class="card-text">photo</h6>
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
					<a href="{{route("photos.index","icons")}}" style="color: white">	<h2>Manage <b>Photos</b></h2> </a>
					</div>
					<div class="col-sm-4" style="visibility: hidden">
						  <div class="input-group mb-3">
							 <input type="text" @if(isset($value)) value="{{$value}}" @endif name="value" class="form-control" placeholder="Enter User Details"  aria-describedby="basic-addon2">
							 <div class="input-group-append">
							   <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i>
							   </button>
							 </div>
						  </div>
					</div>
					<div class="col-sm-4">
						<a href="#AddPhotoModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Photo</span></a>
					</div>
				</div>
			</div>
		@if($errors->any())
          <input id="error-box" value="{{$errors->first()}}" class="d-none"> 
        @endif

			
        <table class="table table-striped table-hover" style="text-align: center"  id="MainTable"> 
          <thead>
            <tr>
              <th>title</th>
              <th>photo</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
      
            @foreach($arr as $key=>$file)				
            <tr>
          
              
              <td class="title">{{$key}}</td>
              <td class="image"><img src="{{asset($file)}}"></td>
              <td><i data-path="{{$file}}" class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeletePhotoModal" aria-hidden="true"></i></td>
  
  
            
            </tr> 
            @endforeach
          </tbody>
        </table>
        <div class="clearfix">
          <div class="hint-text">Showing <b></b> out of <b></b> entries</div>
          <ul class="pagination">
            @if(isset($sss))
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
                         <li class="page-item"><a class="page-link" href="{{route("photos.index")}}?index={{$i+1}}">{{$i+1}}</a></li>
  
                      @endfor
                      @endif
          </ul>
        </div>
		</div>
	</div>        
</div>
            </div>
          </div>
          <!-- content-wrapper ends -->

            <!-- Users Modal --!>
                <!-- Add Modal HTML -->
                <div id="AddPhotoModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="post" action="{{route("photos.store")}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">						
                          <h4 class="modal-title">Add Photo</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">					
                          
                          @if(str_contains(url()->current() ,"banners"))
                          <div class="form-group">
                            <label>Vendor</label>
                            <select  class="form-control" name="vendor" >
                              @foreach($vendors as $vendor)
                              <option  value="{{$vendor->id}}">{{$vendor->full_name}}</option>
                              @endforeach
                            </select>
                          </div>

                          @endif
                          


                          <div class="form-group">
                            <label>Image Name</label>
                            <span class="astric">&#42;</span>
                            <input required type="text"  class="form-control" name="photo_name" >
                          </div>

                          <div class="form-group">
                            <label>Image</label>
                            <span class="astric">&#42;</span>
                            <input required type="file" class="form-control"  name="photo_link" >

                          </div>

                          <div class="form-group">
                            <label>Folder</label>
                            <span class="astric">&#42;</span>
                            <select required class="form-control"  name="folder_name">
                                <option value="icons">icons</option>
                                <option value="today">what is in today</option>
                                <option value="banners">Brand Banners</option>

                            </select>
                         
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
                <div id="EditPhotoModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form id="EditForm" method="post" data-link="" action="" enctype="multipart/form-data">
                        @csrf
                        @method("put")
                        <div class="modal-header">						
                          <h4 class="modal-title">Edit Category</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">					
                          <div class="form-group">
                            <label>Title</label>
                            <input type="text"  name="title" class="form-control title" required>
                          </div>
                          <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="file" name="photo_link" >
                          </div>
                          <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control description" required></textarea>
                          </div>
                
                          <div class="form-group ToInsertBeforeEditModal">
                            <button type="button" class="btn btn-success AddNewSubgroupButton" data-class="ToInsertBeforeEditModal">Add New SubCategory <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
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
                <div id="DeletePhotoModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form>
                        <div class="modal-header">						
                          <h4 class="modal-title">Delete Photo</h4>
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
      
      var title=targeted_row.find(".title").text();
      var description=targeted_row.find(".description").text();
      var sub_categories=targeted_row.find(".sub_categories").attr("data-val");
      var categories_array=JSON.parse(sub_categories);
      $.each(categories_array,function(key,value){
      Fill_NewSubgroup(value,"ToInsertBeforeEditModal","before");
      });
      $("#EditCategoryModal").find(".title").val(title);
      $("#EditCategoryModal").find(".description").val(description);
      $("#EditForm").attr("action",$("#EditForm").attr("data-link")+"/"+id);
    
      
    });
    
    $(document).on("click",".delete_row",function(){
      var targeted_row=$(this).parent().parent();
      var id=targeted_row.attr("data-id");
      var path=$(this).attr("data-path");
      $("#path").attr("value",path);
      //$("#DeleteForm").attr("action",$("#DeleteForm").attr("data-link")+"/"+path);
    
    
    
    });
    
    
    $(".ConfirmDelete").click(function(){
       
      $("#DeleteForm").find("#SubmitDelete").click();
    });
    
    
    });

    function calculateRatio(num_1, num_2){
      for(num=num_2; num>1; num--) {
          if((num_1 % num) == 0 && (num_2 % num) == 0) {
              num_1=num_1/num;
              num_2=num_2/num;
          }
      }
      var ratio = num_1+":"+num_2;
      alert(ratio);
  }


    
    </script>
  </body>
</html>