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
    <input value="{{route("categories.update","X")}}" id="categoriesupdate" class="d-none">

    <input value="0" id="DataTableIntialized" class="d-none">

	
  <!---temp subcategory to add it to Form and fill it  --->
	<div class="form-group d-none AddNewSubgroup">
		<label style="display: block">sub category</label>
		<input class="form-control" type="text" name="sub_categories[]" style="display: inline; width:95%" >
	    <i class="fa fa-times DeleteSubCategory"  aria-hidden="true" style="color: red" title="Delete Sub Category"></i>
	</div>

	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="{{route("categories.destroy","")}}">
      @csrf
      @method("delete")

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
                    <h4 class="font-weight-normal mb-3">Categories <i class="mdi mdi-source-branch  mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\Category::count()}}</h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset("assets/images/dashboard/circle.svg")}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Highest Sells Category<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\Category::GetHighestCategory()->name}}</h2>
                    <h6 class="card-text">
                      {{App\Models\Category::GetHighestCategory()->count}}
                    </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset("assets/images/dashboard/circle.svg")}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Lowest Sells Category <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\Category::GetLowestCategory()->name}}</h2>
                    <h6 class="card-text">
                      {{App\Models\Category::GetLowestCategory()->count}}
                    </h6>

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
					<a href="{{route("categories.index")}}" style="color: white">	<h2>Manage <b>Categories</b></h2> </a>
					</div>
					<div class="col-sm-4">
						<form method="post" action="{{route("categories.search")}}">
						  <div class="input-group mb-3">
							 <input type="text" @if(isset($value)) value="{{$value}}" @endif name="value" class="form-control" placeholder="Enter Category Details"  aria-describedby="basic-addon2">
							 <div class="input-group-append">
							   <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i>
							   </button>
							 </div>
						  </div>
						</form>
					</div>
					<div class="col-sm-4">
						<a href="#AddCategoryModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Category</span></a>
					</div>
				</div>
			</div>
		@if($errors->any())
          <input id="error-box" value="{{$errors->first()}}" class="d-none"> 
        @endif

			
        <table class="table table-striped table-hover" style="text-align: center"  id="MainTable"> 
          <thead>
            <tr>
              <th>English title</th>
              <th>Arabic title</th>
              <th>photo</th>
              <th>english description</th>
              <th>arabic description</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
      
            @foreach($categories["data"] as $category)				
            <tr data-id={{$category["id"]}} data-color_code="{{$category["color_code"]}}">
        
              <td class="en_title">{{$category["en_title"]}}</td>
              <td class="ar_title">{{$category["ar_title"]}}</td>
              <td class="image"><img class="category_image" src="{{asset("categories-photos/".$category["photo_link"])}}" style="max-width:70px"></td>
              <td class="en_description">{{$category["en_description"]}}</td>
              <td class="ar_description">{{$category["ar_description"]}}</td>
              <td ><i class="fa fa-pencil-square-o edit_row" href="#EditCategoryModal"  data-toggle="modal" aria-hidden="true"></i></td>
              <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeleteCategoryModal" aria-hidden="true"></i>
              </td>
  
  
            
            </tr> 
            @endforeach
          </tbody>
        </table>
        <div class="clearfix">
          <div class="hint-text">Showing <b>{{sizeof($categories["data"])}}</b> out of <b>{{$categories["total"]}}</b> entries</div>
          <ul class="pagination" id="pagination-demo">
            @foreach($categories["links"] as $url)
          
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
                <!-- Add Modal HTML -->
                <div id="AddCategoryModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="post" action="{{route("categories.store")}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">						
                          <h4 class="modal-title">Add Category</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">					
                          <div class="form-group">
                            <label>English Title</label>
                            <span class="astric">&#42;</span>
                            <input required type="text" name="en_title" class="form-control" required>
                          </div>

                          					
                          <div class="form-group">
                            <label>Arabic Title</label>
                            <span class="astric">&#42;</span>
                            <input required type="text" name="ar_title" class="form-control" required>
                          </div>
                          
                          <div class="form-group">
                            <label>Image</label>
                            <span class="astric">&#42;</span>
                            <input required type="file" name="photo_link" >
                          </div>
                          <div class="form-group">
                            <label>icon</label>
                            <span class="astric">&#42;</span>
                            <input required type="file" name="icon" class="icons">
                          </div>

                          <div class="form-group">
                            <label>English Description</label>
                            <textarea name="en_description" class="form-control description" required></textarea>
                          </div>

                          <div class="form-group">
                            <label>Arabic Description</label>
                            <textarea name="ar_description" class="form-control description" required></textarea>
                          </div>
                
                
                          <div class="form-group d-none">
                            <label>Sub Category</label>
                            <input disabled class="form-control" type="text" name="sub_categories[]" >
                          </div>
                          
                          <div class="form-group ToInsertBeforeAddModal d-none">
                            <button type="button" class="btn btn-success AddNewSubgroupButton" data-class="ToInsertBeforeAddModal">Add New SubCategory <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
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
                <div id="EditCategoryModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form id="EditForm" method="post" data-link="{{route("categories.update","")}}" action="" enctype="multipart/form-data">
                        @csrf
                        @method("put")
                        <div class="modal-header">						
                          <h4 class="modal-title">Edit Category</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">					
                          <div class="form-group">
                            <label>English Title</label>
                            <span class="astric">&#42;</span>
                            <input type="text"  name="en_title" class="form-control title en_title" required>
                          </div>

                          <div class="form-group">
                            <label>Arabic Title</label>
                            <span class="astric">&#42;</span>
                            <input type="text"  name="ar_title" class="form-control title ar_title" required>
                          </div>

                          <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="file" name="photo_link" >
                          </div>
                          <div class="form-group">
                            <label>icon</label>
                            <input type="file" class="file" name="icon" class="icons" >
                          </div>
                      
                          <div class="form-group">
                            <label>English Description</label>
                            <textarea name="en_description" class="form-control  en_description" required></textarea>
                          </div>

                          <div class="form-group">
                            <label>Arabic Description</label>
                            <textarea name="ar_description" class="form-control ar_description" required></textarea>
                          </div>
                
                          <div class="form-group ToInsertBeforeEditModal d-none">
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
                @include("includes.imgmodal")

                <!-- Delete Modal HTML -->
                <div id="DeleteCategoryModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form>
                        <div class="modal-header">						
                          <h4 class="modal-title">Delete Category</h4>
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
          <footer class="footer">
            @include("includes.footer")
          </footer>
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
      /*  var temp=$(".AddNewSubgroup").clone();
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
        */
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

      var ar_title=targeted_row.find(".ar_title").text();
      var en_title=targeted_row.find(".en_title").text();

      var ar_description=targeted_row.find(".ar_description").text();
      var en_description=targeted_row.find(".en_description").text();

      var sub_categories=targeted_row.find(".sub_categories").attr("data-val");
      /*var categories_array=JSON.parse(sub_categories);
      $.each(categories_array,function(key,value){
      Fill_NewSubgroup(value,"ToInsertBeforeEditModal","before");
      });*/
      $("#EditCategoryModal").find(".ar_title").val(ar_title);
      $("#EditCategoryModal").find(".ar_description").val(ar_description);
      
      $("#EditCategoryModal").find(".en_title").val(en_title);
      $("#EditCategoryModal").find(".en_description").val(en_description);

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
    
    function CheckDimension() {
      //Get reference of File.
      var fileUpload = document.getElementById("colored_icon");
   
      //Check whether the file is valid Image.
      var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
      if (regex.test(fileUpload.value.toLowerCase())) {
   
          //Check whether HTML5 is supported.
          if (typeof (fileUpload.files) != "undefined") {
              //Initiate the FileReader object.
              var reader = new FileReader();
              //Read the contents of Image File.
              reader.readAsDataURL(fileUpload.files[0]);
              reader.onload = function (e) {
                  //Initiate the JavaScript Image object.
                  var image = new Image();
   
                  //Set the Base64 string return from FileReader as source.
                  image.src = e.target.result;
                         
                  //Validate the File Height and Width.
                  image.onload = function () {
                      var height = this.height;
                      var width = this.width;
                      if (height > 500 || width > 500) {
   
                         //show width and height to user
                          document.getElementById("width").innerHTML=width;
                          document.getElementById("height").innerHTML=height;
                          alert("Height and Width must not exceed 500px.");
                          return false;
                      }
                      alert("Uploaded image has valid Height and Width.");
                      return true;
                  };
   
              }
          } else {
              alert("This browser does not support HTML5.");
              return false;
          }
      } else {
          alert("Please select a valid Image file.");
          return false;
      }
  } 

    //$("#colored_icon").on("change",function(){CheckDimension()});

    var _URL = window.URL || window.webkitURL;
$(".icons").on("change",function (e) {
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
        var width=this.width;
         var height=this.height;
         
          $("#width").html(width);
          $("#height").html(height);
         if(width > 200 || height > 200)
         {
           alert("Width and heigth should not be more than 200px ");
         }                          
        };
        img.src = _URL.createObjectURL(file);
    }
});


$(".category_image").click(function(){
  $("#myModal").css("display","block");
  $("#img01").attr("src",$(this).attr("src"));
});

$(".close").click(function(){
  $("#myModal").css("display","none");
});
     

    
    </script>
  </body>
</html>