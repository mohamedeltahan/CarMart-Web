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
    <script type="text/javascript" src="{{asset("js/bootstrap-multiselect.js")}}"></script>
    <link rel="stylesheet" href="{{asset("css/bootstrap-multiselect.css")}}" type="text/css"/>
    <link href="{{asset("fm.selectator.jquery.css")}}" rel="stylesheet">
    <script src="{{asset("fm.selectator.jquery.js")}}"></script> 
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">
    <!-- End layout styles -->
    <link rel="stylesheet" href="{{asset("assets/css/CrudStyle.css")}}">
<style>
  .btn-group{
    margin-top: -11px
  }
  .multiselect-native-select{
    display: block;
  }
  #MainTable_wrapper{
    overflow: auto;
  }
  #ServiceUsersTable_wrapper{
    overflow: scroll;
  }
  .container, .container-sm, .container-md, .container-lg, .container-xl {
    max-width: 1244px;
}


</style>
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
    <i class="fa fa-check-square-o approve-icon approve" aria-hidden="true"></i>
    <i class="fa fa-times disapprove-icon approve" aria-hidden="true"></i>



    <div class="d-none" id="all_branches">
      @if(Auth::user()->account_type=="Vendor")
      {{App\Models\Branch::where("vendor_id",Auth::user()->id)->get()}}
      @else
      {{App\Models\Branch::all()}} 

      @endif
    
    </div>

    <input value="{{route("services.users.index","X")}}" id="GetServiceUsers">
    <input value="{{route("services.update","X")}}" id="serviceupdate">

    <input value="0" id="DataTableIntialized" class="d-none">


	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="{{route("services.destroy","")}}">
			@method("delete")
			@csrf
			<button type="submit" id="SubmitDelete"> </button>
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
                <div class="container-xl">
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-4">
                                    <a href="{{route("services.index")}}" style="color: white">	<h2>Manage <b>Services</b></h2> </a>
                                    </div>
                                    <div class="col-sm-4">
                                        <form method="POST" action="{{route("services.search")}}">
                                            <div class="input-group mb-3">
                                             <input type="text" @if(isset($value)) value="{{$value}}" @endif name="value" class="form-control" placeholder="Enter Service Info"  aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                               <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i>
                                               </button>
                                             </div>
                                          </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-4">
                                       @if(Auth::user()->account_type=="Vendor") <a href="#AddServiceModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Service</span></a> @endif
                                    </div>
                                </div>
                            </div>
                         @if($errors->any())
                          <input id="error-box" value="{{$errors->first()}}" class="d-none">         
                         @endif
                
                            <table class="table table-striped table-hover" style="text-align: center"  id="MainTable"> 
                                <thead>
                                    @if(request()->filled("type") && request()->type=='supplier')                                    <tr>
                                        <th>title</th>
                                        <th>type</th>
                                        <th>brand</th>
                                        <th>price</th>
                                        <th>discount</th>
                                        <th>vendor name</th>
                                        <th>image link </th>
                                        <th>color</th>
                                        <th>promote</th>
                                        <th>country</th>
                                        <th>no_available_items</th>
                                        <th>no_services_requested</th>
                                        <th>edit</th>
                                        <th>delete</th>
                                        <th>users</th>
                                    </tr>
                                    (request()->filled("type") && request()->type=='supplier')                                    <tr>
                                      <th>title</th>
                                      <th>price</th>
                                      <th>discount</th>
                                      <th>vendor name</th>
                                      <th>no_services_requested</th>
                                      <th>edit</th>
                                      <th>delete</th>
                                      <th>users</th>
                                    </tr>
                                    @endif
                                </thead>
                                <tbody>
                                   @if(Auth::user()->category_title=="car_washer")
                                    @foreach($services["data"] as $service)				
                                    <tr  data-id="{{$service["id"]}}" data-title="{{$service["id"]}}" data-description="{{$service["description"]}}" data-branches="{{App\Models\Service::find($service["id"])->GetBranches()}}" data-available_from="{{$service["available_from"]}}" data-available_to="{{$service["available_to"]}}" data-category="{{$service["category"]}}">
                                        <td class="title">{{$service["title"]}}</td>
                                        <td class="price">{{$service["price"]}}</td>
                                        <td class="discount"><span>{{$service["discount"]}}</span> %</td>
                                        <td data-vendor_id="{{$service["vendor_id"]}}" class="vendor_name">{{$service["full_name"]}}</td>
                                        <td class="no_services_requested">{{$service["no_services_requested"]}}</td>
                                        <td><i class="fa fa-pencil-square-o edit_row" href="#EditServiceModal"  data-toggle="modal" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeleteServiceModal" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-users" href="#ServiceUsersModal"  data-toggle="modal" aria-hidden="true"></i></td>
                                    </tr> 
                                    @endforeach
                                   @elseif(Auth::user()->category_title=="supplier")
                                      @foreach($services["data"] as $service)				
                                      <tr  data-id="{{$service["id"]}}" data-title="{{$service["id"]}}" data-description="{{$service["description"]}}" data-branches="{{App\Models\Service::find($service["id"])->GetBranches()}}" data-available_from="{{$service["available_from"]}}" data-available_to="{{$service["available_to"]}}" data-category="{{$service["category"]}}">
                                        <td class="title">{{$service["title"]}}</td>
                                        <td class="type">{{$service["type"]}}</td>
                                        <td class="brand">{{$service["brand"]}}</td>
                                        <td class="price">{{$service["price"]}}</td>
                                        <td class="discount"><span>{{$service["discount"]}}</span> %</td>
                                        <td data-vendor_id="{{$service["vendor_id"]}}" class="vendor_name">{{$service["full_name"]}}</td>
                                        <td class="image"><img class="service_image" src="{{asset("services-photos/".$service["image_link"])}}" style="max-width:70px"></td>
                                        <td class="color">{{$service["color"]}}</td>
                                        <td class="promote_td"> 
                                          @if($service["promoted"]==0)
                                          <i class="fa fa-angle-double-up promote" aria-hidden="true"></i>
                                          @else
                                          <i class="fa fa-angle-double-down unpromote" aria-hidden="true"></i>
                                          @endif
                                        </td>
                                        <td class="country">{{$service["manfacture_country"]}}</td>
                                        <td class="no_available_items">{{$service["no_available_items"]}}</td>
                                        <td class="no_services_requested">{{$service["no_services_requested"]}}</td>
                                        <td><i class="fa fa-pencil-square-o edit_row" href="#EditServiceModal"  data-toggle="modal" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeleteServiceModal" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-users" href="#ServiceUsersModal"  data-toggle="modal" aria-hidden="true"></i></td>
                                      </tr> 
                                      @endforeach
                                    @endif

                                    
                                </tbody>
                            </table>
                            <div class="clearfix">
                                <div class="hint-text">Showing <b>{{$services["total"]}}</b> out of <b>{{$services["total"]}}</b> entries</div>
                                <ul class="pagination">
                                  @foreach($services["links"] as $url)
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

          <table id="tempTable">
            <tr class="tr">
                <td class="full_name"></td>
                <td class="phone"></td>
                <td class="request_time"></td>
                <td class="request_note"></td>
                <td class="response_time"></td>
                <td class="response_note"></td>
                <td class="state"></td>
            </tr> 
            </table>
            <!-- Users Modal --!>
                <div id="ServiceUsersModal" class="modal fade">
                    <div class="modal-dialog" style="width: 85%">
                        <div class="modal-content">
                            <form  method="post" action="{{route("services.store")}}" enctype='multipart/form-data'>
                                @csrf
                                <div class="modal-header">						
                                    <h4 class="modal-title">Service Users</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">					
                                
                                    <table class="table table-striped table-hover" style="text-align: center;"  id="ServiceUsersTable"> 
                                        <thead>
                                            <tr>
                                                <th>full name</th>
                                                <th>phone</th>
                                                <th>request_time</th>
                                                <th>request_note</th>
                                                <th>response_time</th>
                                                <th>response_note</th>
                                                <th>state</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            
                                            
                                        </tbody>
                                    </table>
                
            
                
                
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <input type="submit" class="btn btn-success" value="Add">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
            <!-- Add Modal HTML -->
            <div id="AddServiceModal" class="modal fade">
                <div class="modal-dialog" style="width: 85%">
                    <div class="modal-content">
                        <form  method="post" action="{{route("services.store")}}" enctype='multipart/form-data'>
                            @csrf
                            <div class="modal-header">						
                                <h4 class="modal-title">Add Service</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            @if(Auth::user()->category_title=="supplier")
                            <div class="modal-body">					
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <label>Vendor Name</label>
                                            <span class="astric">&#42;</span>
                                            <select   name="vendor_id" class="form-control vendor_id">
                                              @if(Auth::user() && Auth::user()->account_type=="Vendor")
                                              <option value="{{Auth::user()->id}}">{{Auth::user()->full_name}}</option>
                                              @endif
                                            </select>
                                         </div>
                                         <div class="col-sm-4">
                                            <label>Title</label>
                                            <span class="astric">&#42;</span>
                                            <input required type="text" name="title" class="form-control">
                                          </div>

                                          <div class="col-sm-4">
                                            <label>Category</label>
                                            <span class="astric">&#42;</span>
                                            <select   name="category" class="form-control ">
                                              <option value="">Select Category</option>
                                              @foreach(App\Models\Category::all() as  $category)
                                              <option value="{{$category->en_title}}">{{$category->en_title}}</option>
                                              @endforeach
                                            </select>

                                            </div>
                                    </div>

                                    <div class="form-row">
                                      <div class="col-sm-6">
                                        <label>Type</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="text" name="type" class="form-control" >
                                      </div>
                                      <div class="col-sm-6">
                                        <label>Brand</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="text" name="brand" class="form-control">
                                      </div>
                                    </div>
                                  
                                    <div class="form-row">
                                      <div class="col-sm-6">
                                        <label>Price</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="price" class="form-control" >
                                      </div>
                                      <div class="col-sm-6">
                                        <label>Discount</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="discount" class="form-control">
                                      </div>
                                    </div>
            
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <label>Description</label>
                                            <span class="astric">&#42;</span>

                                            <textarea required type="text" name="description" class="form-control" rows="4"   > </textarea>
                                          </div>
                                          
                                        <div class="col-sm-4">
                                          <label>Branches</label>
                                          <span class="astric">&#42;</span>
                                          <select  multiple class="selectator AddServiceSelectator" name="branches[]"  >
                                            <option  value="all_branches" data-subtitle="All Branches" >All Branches</option>
                                            @foreach(App\Models\Branch::where("vendor_id",Auth::user()->id)->get() as $branch)
                                            <option class="{{$branch->vendor_id}}" value="{{$branch->id}}" data-subtitle="{{$branch->city}}" >{{$branch->name}}</option>
                                            @endforeach
                                          
                                          </select>  
                                        </div>

                                        <div class="col-sm-4">
                                          <label>Cars</label>
                                          <span class="astric">&#42;</span>
                                          <select  multiple class="selectator AddServiceSelectator" name="cars[]"  >
                                            <option  value="all_cars" data-subtitle="All Cars" >All Cars</option>
                                            @foreach(App\Models\Car::all() as $car)
                                            <option  value="{{$car->id}}" data-subtitle="{{$car->brand}}" >{{$car->model}}</option>
                                            @endforeach
                                          
                                          </select>  
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                    
                                      <div class="col-sm-4">
                                        <label>Available Form</label>
                                        <input required type="time" name="available_from" class="form-control">
                                      </div>
                                            
                                      <div class="col-sm-4">
                                        <label>Available To</label>
                                        <input required type="time" name="available_to" class="form-control">
                                      </div>

                                      <div class="col-sm-4">
                                        <label>Available Items</label>
                                        <input required type="number" name="no_available_items" class="form-control">
                                      </div>

                                      
                                     
                                    </div>
                                
            
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <label>Color</label>
                                            <span class="astric">&#42;</span>
                                            <input required type="text" name="color" class="form-control">
                                          </div>
                                          <div class="col-sm-4">
                                            <label>Manfacture Country</label>
                                            <span class="astric">&#42;</span>
                                            <input required type="text" name="manfacture_country" class="form-control">
                                          </div>
                                          
                                          <div class="col-sm-4">
                                              <label>Image</label>
                                              <span class="astric">&#42;</span>
                                              <input required type="file" name="image_link" class="form-control icons">
                                          </div>
                                    </div>
                            </div>
                            @elseif(Auth::user()->category_title=="car_washer")
                            <div class="modal-body">					
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <label>Vendor Name</label>
                                            <span class="astric">&#42;</span>
                                            <select  name="vendor_id" class="form-control vendor_id">
                                              @if(Auth::user() && Auth::user()->account_type=="Vendor")
                                              <option value="{{Auth::user()->id}}">{{Auth::user()->full_name}}</option>
                                              @endif
                                            </select>
                                         </div>
                                         <div class="col-sm-4">
                                            <label>Title</label>
                                            <span class="astric">&#42;</span>
                                            <input required type="text" name="title" class="form-control">
                                          </div>

                                          <div class="col-sm-4">
                                            <label>Category</label>
                                            <span class="astric">&#42;</span>
                                            <select   name="category" class="form-control ">
                                              <option value="">Select Category</option>
                                              @foreach(App\Models\Category::all() as  $category)
                                              <option value="{{$category->en_title}}">{{$category->en_title}}</option>
                                              @endforeach
                                            </select>

                                            </div>
                                    </div>

                                  
                                    <div class="form-row">
                                      <div class="col-sm-6">
                                        <label>Price</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="price" class="form-control" >
                                      </div>
                                      <div class="col-sm-6">
                                        <label>Discount</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="discount" class="form-control">
                                      </div>
                                    </div>
            
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <label>Description</label>
                                            <span class="astric">&#42;</span>

                                            <textarea required type="text" name="description" class="form-control" rows="4"   > </textarea>
                                          </div>
                                          
                                        <div class="col-sm-4">
                                          <label>Branches</label>
                                          <span class="astric">&#42;</span>
                                          <select  multiple class="selectator AddServiceSelectator" name="branches[]"  >
                                            <option  value="all_branches" data-subtitle="All Branches" >All Branches</option>
                                            @foreach(App\Models\Branch::where("vendor_id",Auth::user()->id)->get() as $branch)
                                            <option class="{{$branch->vendor_id}}" value="{{$branch->id}}" data-subtitle="{{$branch->city}}" >{{$branch->name}}</option>
                                            @endforeach
                                          
                                          </select>  
                                        </div>

                                        <div class="col-sm-4">
                                          <label>Cars</label>
                                          <span class="astric">&#42;</span>
                                          <select  multiple class="selectator AddServiceSelectator" name="cars[]"  >
                                            <option  value="all_cars" data-subtitle="All Cars" >All Cars</option>
                                            @foreach(App\Models\Car::all() as $car)
                                            <option  value="{{$car->id}}" data-subtitle="{{$car->brand}}" >{{$car->model}}</option>
                                            @endforeach
                                          
                                          </select>  
                                        </div>
                                    </div>
                                    
                            </div>
                            @endif
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="btn btn-success" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal HTML -->
            <div id="EditServiceModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="EditForm" method="post" data-link="{{route("services.update","")}}" action="" enctype="multipart/form-data">
                            @csrf
                            @method("put")
                            <div class="modal-header">						
                                <h4 class="modal-title">Edit Service</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            @if(Auth::user()->category_title=="car_washer")
                            <div class="modal-body">					
                              <div class="form-row">
                                  <div class="col-sm-4">
                                    <label>Vendor Name</label>
          
                                    <select required class="form-control edit_vendor_id">
                               
                                      <option class="first_option" value=""></option>
                                    
                                    </select>
                                   </div>
          
                                   <div class="col-sm-4">
                                    <label>Title</label>
                                    <span class="astric">&#42;</span>
                                    <input required type="text" name="title" class="form-control">
                                  </div>

                                  
                                  <div class="col-sm-4">
                                    <label>Category</label>
                                    <span class="astric">&#42;</span>
                                    <select   name="category" class="form-control ">
                                      <option value="">Select Category</option>

                                      @foreach(App\Models\Category::all() as  $category)
                                      <option value="{{$category->en_title}}">{{$category->en_title}}</option>
                                      @endforeach
                                    </select>

                                    </div>
                     
                              </div>

                              

                              <div class="form-row">
                                <div class="col-sm-6">
                                  <label>Price</label>
                                  <span class="astric">&#42;</span>
                                  <input required type="number" name="price" class="form-control" >
                                </div>
                                <div class="col-sm-6">
                                  <label>Discount</label>
                                  <span class="astric">&#42;</span>
                                  <input required type="number" name="discount" class="form-control">
                                </div>
                              </div>
          
                              <div class="form-row">
                                  <div class="col-sm-6">
                                      <label>Description</label>
                                      <span class="astric">&#42;</span>
                                      <textarea required type="text" name="description" class="form-control"   > </textarea>
                                    </div>
                                    
                                  <div class="col-sm-6">
                                    <label>Branches</label>
                                    <span class="astric">&#42;</span>
                                    <select  multiple class="" id="service_branches" name="branches[]"  data-selectator-keep-open="true" data-MORE-OPTION="OPTION VALUE">
                                    </select>                                      
                                  </div>
                              </div>

                           
                          
      
                          </div>
                              
                            @else
                            <div class="modal-body">					
                                <div class="form-row">
                                    <div class="col-sm-4">
                                      <label>Vendor Name</label>
            
                                      <select required class="form-control edit_vendor_id">
                                 
                                        <option class="first_option" value=""></option>
                                      
                                      </select>
                                     </div>
            
                                     <div class="col-sm-4">
                                      <label>Title</label>
                                      <span class="astric">&#42;</span>
                                      <input required type="text" name="title" class="form-control">
                                    </div>

                                    
                                    <div class="col-sm-4">
                                      <label>Category</label>
                                      <span class="astric">&#42;</span>
                                      <select   name="category" class="form-control ">
                                        <option value="">Select Category</option>

                                        @foreach(App\Models\Category::all() as  $category)
                                        <option value="{{$category->en_title}}">{{$category->en_title}}</option>
                                        @endforeach
                                      </select>

                                      </div>
                       
                                </div>

                                <div class="form-row">
                                  <div class="col-sm-6">
                                    <label>Type</label>
                                    <span class="astric">&#42;</span>
                                    <input required type="text" name="type" class="form-control" >
                                  </div>
                                  <div class="col-sm-6">
                                    <label>Brand</label>
                                    <span class="astric">&#42;</span>
                                    <input required type="text" name="brand" class="form-control">
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="col-sm-6">
                                    <label>Price</label>
                                    <span class="astric">&#42;</span>
                                    <input required type="number" name="price" class="form-control" >
                                  </div>
                                  <div class="col-sm-6">
                                    <label>Discount</label>
                                    <span class="astric">&#42;</span>
                                    <input required type="number" name="discount" class="form-control">
                                  </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label>Description</label>
                                        <span class="astric">&#42;</span>
                                        <textarea required type="text" name="description" class="form-control"   > </textarea>
                                      </div>
                                      
                                    <div class="col-sm-6">
                                      <label>Branches</label>
                                      <span class="astric">&#42;</span>
                                      <select  multiple class="" id="service_branches" name="branches[]"  data-selectator-keep-open="true" data-MORE-OPTION="OPTION VALUE">
                                      </select>                                      
                                    </div>
                                </div>

                                <div class="form-row">
                              
                                  <div class="col-sm-4">
                                    <label>Available Form</label>
                                    <input required type="time" name="available_from" class="form-control">
                                  </div>
                                        
                                  <div class="col-sm-4">
                                    <label>Available To</label>
                                    <input required type="time" name="available_to" class="form-control">
                                  </div>
  
                                  <div class="col-sm-4">
                                    <label>Available Items</label>
                                    <input required type="number" name="no_available_items" class="form-control">
                                  </div>
  
                                  
                                 
                                </div>
                            
        
                                <div class="form-row">
                                    <div class="col-sm-4">
                                        <label>Color</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="text" name="color" class="form-control">
                                      </div>
                                      <div class="col-sm-4">
                                        <label>Country</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="text" name="manfacture_country" class="form-control">
                                      </div>
                                      
                                      <div class="col-sm-4">
                                          <label>Image</label>
                                          <input  type="file" name="image_link" class="form-control">
                                      </div>
                                </div>
                            </div>
                                
                            @endif
            
                                
                                

                                
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="btn btn-success" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @include("includes.imgmodal")
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
                                  <textarea required type="text" id="response_note" name="response" class="form-control"  placeholder=""  ></textarea>
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

            <!-- Delete Modal HTML -->
            <div id="DeleteServiceModal" class="modal fade DeleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">						
                                <h4 class="modal-title">Delete Service</h4>
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
        //$('.selectator').selectator();
    
        var result1;
    
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
                async:false,
                data: object,
                success: function (result)  {
                   result1=result;
                },
                error: function (data) {
                    alert('Error on updating, please try again later!');
                    return false;
                }
            }))
                return result1;
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

           $("#example-getting-started").multiselect()
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
        $(this).find("textarea[name=branches_name]").text("");
    
      })
    
      $(".multiselect-native-select").addClass("form-control");

    $(document).on("click",".edit_row",function(){
      var targeted_row=$(this).parent().parent();
      var id=targeted_row.attr("data-id");
      var vendor_name=targeted_row.find(".vendor_name").text();
      var vendor_id=targeted_row.find(".vendor_name").attr("data-vendor_id");
      var description=targeted_row.attr("data-description");
      var discount=targeted_row.find(".discount").find("span").text();
      var title=targeted_row.find(".title").text();
      var type=targeted_row.find(".type").text();
      var price=targeted_row.find(".price").text();
      var color=targeted_row.find(".color").text();
      var country=targeted_row.find(".country").text();
      var available_items=targeted_row.find(".no_available_items").text();
      var brand=targeted_row.find(".brand").text();
      var available_from=targeted_row.attr("data-available_from");
      var available_to=targeted_row.attr("data-available_to");
      var branches_name=JSON.parse(targeted_row.attr("data-branches"));
      var all_branches=JSON.parse($("#all_branches").text());
      var category=targeted_row.attr("data-category");


    //  var malls=JSON.parse(targeted_row.attr("data-malls_id"));
     // $(".added_option").remove();
    //  var options = [];
     // $('.offer_malls').multiselect();
     //var all_malls=JSON.parse($("#all_malls").text());
    // console.log(all_malls);


     /* $.each(all_malls,function(key,value){
        if(malls.indexOf(value.id)!=-1){
          options.push({label: value.name, title:value.name, value: value.id,selected:true});

        }
        else{
          options.push({label: value.name, title:value.name, value: value.id,selected:false});

        }

      //  $('.offer_malls').append($('<option selected class="added_option">').val(value.id).text(value.name))
        console.log(value);
      });
*/

     
      $("#EditForm").find(".btn-group").css("margin-top","29px");

      $.each(all_branches,function(key,value){
        if(branches_name.indexOf(value.id)!=-1){
          $('#service_branches').append($('<option selected>').val(value.id).text(value.name))

        }
        else{
          $('#service_branches').append($('<option>').val(value.id).text(value.name))

        }



          //to view each branch in new line
          if(key!=branches_name.length-1){

             $("#EditServiceModal").find("textarea[name=branches_name]").append(value.name+"\n");
          }
          // and if its the last line i only add the branch name without new line
          else{
             $("#EditServiceModal").find("textarea[name=branches_name]").append(value.name);
          }
    
      });
      $('#service_branches').selectator();
      

    
      
      $("#EditServiceModal").find("input[name=title]").val(title);
      $("#EditServiceModal").find("input[name=type]").val(type);

      $("#EditServiceModal").find("select[name=category]").val(category);
      $("#EditServiceModal").find("input[name=discount]").val(discount);
      $("#EditServiceModal").find("textarea[name=description]").val(description);
    
      $("#EditServiceModal").find("input[name=price]").val(price);
      $("#EditServiceModal").find("input[name=brand]").val(brand);
      $("#EditServiceModal").find("input[name=available_from]").val(available_from);
      $("#EditServiceModal").find("input[name=available_to]").val(available_to);
      $("#EditServiceModal").find("input[name=color]").val(color);
      $("#EditServiceModal").find("input[name=manfacture_country]").val(country);
      $("#EditServiceModal").find("input[name=no_available_items]").val(available_items);

      $("#EditServiceModal").find("input[name=discount]").val(discount);
      $(".first_option").attr("value",vendor_id);
      $(".first_option").text(vendor_name);
    
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
    
    
    var t=null;
    $(".fa-users").click(function() {
    
        var id=$(this).parent().parent().attr("data-id");
    
        var url=$("#GetServiceUsers").val();
        var res = url.replace("X", id);
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if($.ajax({
            url: res,
            type: "GET",
            //request data
            success: function (result) {
                console.log(result);
                if($("#DataTableIntialized").val()==0){
                t= $('#ServiceUsersTable').DataTable({
                    "paging":   true,
            
                    aaSorting: [],
                    "language": {
                        "lengthMenu":  "",
                        "info":  "",
                        "infoEmpty": "",
                        "infoFiltered": "",
                        
            
                    }
                });
                $("#DataTableIntialized").val(1);
            }
                for (var i = 0; i < result.length; i++) {
                    
    
    
    
                    var tr = $(".tr").clone();
    
                    tr.detach();
                    tr.attr("data-id",result[i].id);
                    tr.css("display","");
    
                    tr.attr("id","");
    
                    //  var href=tr.find(".name a").attr("href").replace("X",result[i].id);
                    tr.find(".id").text(result[i].id);
    
                    tr.find(".full_name").text(result[i].user.full_name);
                    tr.find(".phone").text(result[i].user.phone);
                    tr.find(".state").text(result[i].state);
                    tr.find(".request_time").text(result[i].request_time);
                    tr.find(".request_note").text(result[i].request_note);
                    tr.find(".response_time").text(result[i].response_time);
                    tr.find(".response_note").text(result[i].response_note);

                 //   tr.find(".points").text(result[i].points);

                    t.row.add(tr).draw( false );
    
    
    
                    // table.append(tr);
    
    
                    //     temp.parent().find("table").append("<tr><td>"+result[i].id+"</td><td>"+result[i].username+"</td><td>dsadasd</td><td>"+result[i].no_of_items+"</td><td>"+result[i].hour+"</td><td>"+result[i].delivery+"</td><td>"+result[i].customer_name+"</td><td>dsadasd</td></tr>");
                }
                
            
            
            
                
            
            },
            error: function (data) {
                alert('Error on updating, please try again later!');
                return false;
            }
        }));
    });
    
    $('body').on('hidden.bs.modal', '.modal', function () {
      $("#myModal").css("display","none");
      $("#service_branches").empty();
      $('#service_branches').selectator("destroy");


     t.clear().draw();

    });
    
    $(document).on("click",".promote",function(){
        var id=$(this).parent().parent().attr("data-id");
        var url=$("#serviceupdate").val();
        var res = url.replace("X", id);
        var result=ajaxFunction({"promoted":1},res,"put");
        console.log(result);
        if(result.promoted==1){
            alert("Service has Promoted");
            var parenttag=$(this).parent();
            $(this).remove();
            parenttag.append($(".tempunpromote").clone().removeClass("tempunpromote"));
        }
        else{
            alert("Operation failed kindly contact support");
        }
    });
    

    $(document).on("click",".approve",function(){
      var id=$(this).parent().parent().attr("data-id");
      var url=$("#serviceupdate").val();
      var res = url.replace("X", id);
      if($(this).hasClass("fa-times")){
        var result=ajaxFunction({"approved":0},res,"put");
      }
      else{
        var result=ajaxFunction({"approved":1},res,"put");
      }
      console.log(result);
      if(result.approved==1){
          alert("Service has Approved");
          var parenttag=$(this).parent();
          $(this).remove();
          parenttag.append($(".disapprove-icon").clone().removeClass("disapprove-icon"));
      }
      else if(result.approved==0){
        alert("Service has Disapproved");
        var parenttag=$(this).parent();
        $(this).remove();
        parenttag.append($(".approve-icon").clone().removeClass("approve-icon"));
      }
    
      else{
          alert("Operation failed kindly contact support");
      }
  });
  

    $(document).on("click",".unpromote",function(){
        var id=$(this).parent().parent().attr("data-id");
        var url=$("#serviceupdate").val();
        var res = url.replace("X", id);
        var result=ajaxFunction({"promoted":0},res,"put");
        console.log(result);
    
        if(result.promoted==0){
            alert("Service has UnPromoted");
            var parenttag=$(this).parent();
            $(this).remove();
            parenttag.append($(".temppromote").clone().removeClass("temppromote"));
        }
        else{
            alert("Operation failed kindly contact support");
    
        }
    });

    $(document).on("change",".vendor_id",function(){
      $(".selectator_option").addClass("d-none");

      var vendor_id=$(this).val();
      $(".selectator_option").filter("."+vendor_id).removeClass("d-none")
    });


    
    $(document).on("click",".respond_row",function(){

      var targeted_row=$(this).parent().parent();
      var id=targeted_row.attr("data-id");
 
      var url=$("#offersupdate").val();
      var res = url.replace("X", id);
      $("#updateform").attr("action",res);





    });
    
var modal = $("#myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
/*var img = $("#offer_image");
var modalImg = $("#img01");
var captionText = $("#caption");
$(".offer_image").click(function(){
  $("#myModal").css("display","block");
  $("#img01").attr("src",$(this).attr("src"));
});*/

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
          alert(calculateRatio(width,height));
         if(calculateRatio(width,height)!=$("#ratio").val())
         {
           alert("Width and heigth should be"+$("#ratio").val());
         }                          
        };
        img.src = _URL.createObjectURL(file);
    }
});

function calculateRatio(num_1, num_2){
  for(num=num_2; num>1; num--) {
      if((num_1 % num) == 0 && (num_2 % num) == 0) {
          num_1=num_1/num;
          num_2=num_2/num;
      }
  }
  var ratio = num_1+":"+num_2;
  return ratio;
}

    </script>
  </body>
</html>