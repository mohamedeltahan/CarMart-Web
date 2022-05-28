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

    <input id="map_link" class="d-none" value="http://maps.google.com/maps?q=X,Y&z=15&output=embed"> 

      <input id="RequestsUpdate" class="d-none" value="{{route("requests.update","X")}}"> 
     @if($errors->any())
     <input id="error-box" value="{{$errors->first()}}" class="d-none">         
     @endif
    <i class="fa fa-angle-double-up temppromote promote" aria-hidden="true"></i>
    <i class="fa fa-angle-double-down tempunpromote unpromote" aria-hidden="true"></i>
    <i class="fa fa-check-square-o approve-icon approve" aria-hidden="true"></i>
    <i class="fa fa-times disapprove-icon approve" aria-hidden="true"></i>


    
    <input value="{{route("services.users.index","X")}}" id="GetServiceUsers">
    <input value="0" id="DataTableIntialized" class="d-none">


	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="{{route("requests.update","")}}">
			@method("put")
            @csrf
            <input name="state" value="Rejected">
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
            @if(Auth::user()->account_type!="Admin")
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin" style="height: 156px;">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Requests<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\UserService::where("vendor_id",Auth::id())->count()}} </h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin" style="height: 156px;">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Requests Completed <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\UserService::where("vendor_id",Auth::id())->where("state","received")->count()}}</h2>
                    <h6 class="card-text"> </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin" style="height: 156px;"> 
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Revenue <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{Auth::user()->TotalRevenue()}} L.E</h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
            </div>
            @else
            <div class="row">
              <div class="col-md-3 stretch-card grid-margin" style="height: 156px;">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"><a style="color: white" href="{{route("requests.index",["state"=>"all","type"=>"emergency_car"])}}">Emergency Car Requests </a><i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> </h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-3 stretch-card grid-margin" style="height: 156px;">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"><a style="color: white" href="{{route("requests.index",["state"=>"all","type"=>"car_washer"])}}">Car Washer Requests</a> <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"></h2>
                    <h6 class="card-text"> </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-3 stretch-card grid-margin" style="height: 156px;"> 
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"><a style="color: white" href="{{route("requests.index",["state"=>"all","type"=>"supplier"])}}">Supplier Requests </a><i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{Auth::user()->TotalRevenue()}} L.E</h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-3 stretch-card grid-margin" style="height: 156px;"> 
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"><a style="color: white" href="{{route("requests.index",["state"=>"all","type"=>"mechanic"])}}">Maintenance Requests </a><i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{Auth::user()->TotalRevenue()}} L.E</h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
            </div>
            @endif
           
          
            <div class="row">
                <div class="container-xl">
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-4">
                                    <a href="{{route("requests.index")}}?state=all" style="color: white">	<h2>Manage <b>Requests</b></h2> </a>
                                    </div>
                                    <div class="col-sm-4">
                                        <form method="post" action="{{route("requests.search")}}">
                                            <div class="input-group mb-3">
                                                <input class="d-none" name="state" value="all">
                                             <input type="text" @if(isset($value)) value="{{$value}}" @endif name="value" class="form-control" placeholder="Enter Service Info"  aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                               <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i>
                                               </button>
                                             </div>
                                          </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                </div>
                            </div>
                         @if($errors->any())
                          <input id="error-box" value="{{$errors->first()}}" class="d-none">         
                         @endif
                
                            <table class="table table-striped table-hover" style="text-align: center"  id="MainTable"> 
                                <thead>
                                  @if(Auth::user()->category_title=="supplier" || (request()->filled("type") && request()->type=='supplier'))
                                    <tr>
                                        <th>full name</th>
                                        <th>phone</th>
                                        <th>request time</th>
                                        <th>title</th>
                                        <th>type</th>
                                        <th>brand</th>
                                        <th>price</th>
                                        <th>color</th>
                                        <th>country</th>
                                        <th>quantity</th>
                                        <th>state</th>
                                        <th>delete</th>
                                        <th>respond</th>
                                    </tr>


                                    @elseif(Auth::user()->category_title=="car_washer" || (request()->filled("type") && request()->type=='car_washer'))
                                    <tr>
                                        <th>full name</th>
                                        <th>phone</th>
                                        <th>request time</th>
                                        <th>title</th>
                                        <th>booking date</th>
                                        <th>booking time</th>
                                        <th>car</th>
                                        <th>state</th>
                                        <th>delete</th>
                                        <th>respond</th>
                                    </tr>

                                    @elseif(Auth::user()->category_title=="emergency_car" || (request()->filled("type") && request()->type=='emergency_car'))
                                    <tr>
                                        <th>full name</th>
                                        <th>phone</th>
                                        <th>request time</th>
                                        <th>car</th>
                                        <th>state</th>
                                        <th>delete</th>
                                        <th>respond</th>
                                    </tr>
                                    @endif
                                </thead>
                                <tbody>
                                  @if(Auth::user()->category_title=="car_washer" || (request()->filled("type") && request()->type=='car_washer'))
                                  @foreach($services["data"] as $service)				
                                    <tr data-response="{{$service["response_note"]}}" data-car="{{$service["car_brand"]."-".$service["car_model"]."-".$service["car_year"]}}" data-distance="{{App\Models\UserService::find($service["id"])->getDistanceBetweenPointsNew()}}" data-source_latitude="{{$service["source_latitude"]}}" data-source_longitude="{{$service["source_longitude"]}}"  data-destination_latitude="{{$service["destination_latitude"]}}" data-destination_longitude="{{$service["destination_longitude"]}}"  data-id="{{$service["id"]}}" data-title="{{$service["id"]}}" data-description="{{$service["description"]}}" data-request_note="{{$service["request_note"]}}" data-customer_name="{{$service["customer_name"]}}" data-customer_phone="{{$service["customer_phone"]}}">
                                        <td class="full_name">{{$service["user"]["full_name"]}}</td>
                                        <td class="phone">{{$service["user"]["phone"]}}</td>
                                        <td class="request_time">{{$service["request_time"]}}</td>
                                        <td class="title">{{$service["title"]}}</td>
                                        <td class="booking_date">{{$service["booking_date"]}}</td>
                                        <td class="booking_time">{{$service["booking_time"]}}</td>                                  
                                        <td class="car">{{$service["car_brand"]."-".$service["car_model"]."-".$service["car_year"]}}</td>
                                        <td class="state">{{$service["state"]}}</td>
                                        <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#RejectServiceModal" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-comments respond_row" data-toggle="modal" href="#respond-Modal" aria-hidden="true"></i></td>
                                    </tr> 
                                    @endforeach
                                  @endif
                                  
                                  @if(Auth::user()->category_title=="supplier" || (request()->filled("type") && request()->type=='supplier'))
                                    @foreach($services["data"] as $service)				
                                    <tr data-response="{{$service["response_note"]}}"  data-car="{{$service["car_brand"]."-".$service["car_model"]."-".$service["car_year"]}}" data-distance="{{App\Models\UserService::find($service["id"])->getDistanceBetweenPointsNew()}}" data-source_latitude="{{$service["source_latitude"]}}" data-source_longitude="{{$service["source_longitude"]}}"  data-destination_latitude="{{$service["destination_latitude"]}}" data-destination_longitude="{{$service["destination_longitude"]}}"  data-id="{{$service["id"]}}" data-title="{{$service["id"]}}" data-description="{{$service["description"]}}" data-request_note="{{$service["request_note"]}}" data-customer_name="{{$service["customer_name"]}}" data-customer_phone="{{$service["customer_phone"]}}" data-destination_address="{{$service["destination_address"]}}">
                                        <td class="full_name">{{$service["user"]["full_name"]}}</td>
                                        <td class="phone">{{$service["user"]["phone"]}}</td>
                                        <td class="request_time">{{$service["request_time"]}}</td>
                                        <td class="title">{{$service["title"]}}</td>
                                        <td class="type">{{$service["type"]}}</td>
                                        <td class="brand">{{$service["brand"]}}</td>
                                        <td class="price">{{$service["price"]}}</td>
                                        <td class="color">{{$service["color"]}}</td>
                                        <td class="country">{{$service["manfacture_country"]}}</td>
                                        <td class="quantity">{{$service["quantity"]}}</td>
                                        <td class="state">{{$service["state"]}}</td>
                                        <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#RejectServiceModal" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-comments respond_row" data-toggle="modal" href="#respond-Modal" aria-hidden="true"></i></td>
                                    </tr> 
                                    @endforeach
                                  @endif

                                  @if(Auth::user()->category_title=="emergency_car" || (request()->filled("type") && request()->type=='emergency_car'))
                                  @foreach($services["data"] as $service)				
                                    <tr data-response="{{$service["response_note"]}}"  data-car="{{$service["car_brand"]."-".$service["car_model"]."-".$service["car_year"]}}" data-distance="{{App\Models\UserService::find($service["id"])->getDistanceBetweenPointsNew()}}" data-source_latitude="{{$service["source_latitude"]}}" data-source_longitude="{{$service["source_longitude"]}}"  data-destination_latitude="{{$service["destination_latitude"]}}" data-destination_longitude="{{$service["destination_longitude"]}}"  data-id="{{$service["id"]}}" data-title="{{$service["id"]}}" data-description="{{$service["description"]}}" data-request_note="{{$service["request_note"]}}" data-customer_name="{{$service["customer_name"]}}" data-customer_phone="{{$service["customer_phone"]}}" data-min_cost_per_kilo="{{$service["min_cost_per_kilo"]}}" data-max_cost_per_kilo="{{$service["max_cost_per_kilo"]}}">
                                        <td class="full_name">{{$service["customer_name"]}}</td>
                                        <td class="phone">{{$service["customer_phone"]}}</td>
                                        <td class="request_time">{{$service["request_time"]}}</td>
                                        <td class="car">{{$service["car_brand"]."-".$service["car_model"]."-".$service["car_year"]}}</td>
                                        <td class="state">{{$service["state"]}}</td>
                                        <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#RejectServiceModal" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-comments respond_row" data-toggle="modal" href="#respond-Modal" aria-hidden="true"></i></td>
                                    </tr> 
                                    @endforeach
                                  @endif
                                  
                                  

                                </tbody>
                            </table>
                            <div class="clearfix">
                                <div class="hint-text">Showing <b>{{$services["total"]}}</b> out of <b>{{$services["total"]}}</b> entries</div>
                                <ul class="pagination">
                                  @foreach($services["links"] as $url)
          
                                  <li class="page-item @if($url["active"]==true) active @endif" ><a class="page-link"  href="{{$url["url"]}}&state={{$state}}">
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
                <td class="response_time"> </td>
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
                                
                                    <table class="table table-striped table-hover" style="text-align: center"  id="ServiceUsersTable"> 
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
                            <div class="modal-body">					
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <label>Vendor Name</label>
                                            <span class="astric">&#42;</span>
                                            <select   name="vendor_id" class="form-control vendor_id">
                                              @if(Auth::user() && Auth::user()->account_type=="Vendor")
                                              <option value="{{Auth::user()->id}}">{{Auth::user()->full_name}}</option>
                                              @endif
                                             
                                           
                                          
                                            </select>
                                         </div>
            
                                         <div class="col-sm-6">
                                            <label>Title</label>
                                            <span class="astric">&#42;</span>
                                            <input required type="text" name="title" class="form-control">
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

                                            <textarea required type="text" name="color" class="form-control" rows="4"   > </textarea>
                                          </div>
                                          
                                        <div class="col-sm-6">
                                          <label>Branches</label>
                                          <span class="astric">&#42;</span>
                                          <select  multiple class="selectator AddServiceSelectator" name="branches[]"  >
                                            <option value="">&nbsp;</option>
                                            
                                            
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
                                              <span class="astric">&#42;</span>
                                              <input required type="file" name="image_link" class="form-control">
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
                            <div class="modal-body">					
                                <div class="form-row">
                                    <div class="col-sm-6">
                                      <label>Vendor Name</label>
            
                                      <select required class="form-control edit_vendor_id">
                                 
                                        <option class="first_option" value=""></option>
                                      
                                      </select>
                                     </div>
            
                                     <div class="col-sm-6">
                                        <label>Name</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="text" name="name" class="form-control">
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
                                      <select  multiple class="" id="offer_branches" name="branches[]"  data-selectator-keep-open="true" data-MORE-OPTION="OPTION VALUE">
                                        <option value="">&nbsp;</option>
                                      </select>                                      
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-sm-4">
                                      <label>Discount</label>
                                      <span class="astric">&#42;</span>
                                      <input required type="text" name="discount" class="form-control price_change" maxlength="2" >
                                    </div>
                                    <div class="col-sm-4">
                                      <label>Price Before Discount</label>
                                      <span class="astric">&#42;</span>
                                      <input type="number" name="price_before_discount" class="form-control price_change">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Price After Discount</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="price_after_discount" class="form-control" readonly>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="col-sm-3">
                                        <label>Points</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="points" class="form-control">
                                      </div>
                                      <div class="col-sm-3">
                                        <label>Offer Usage</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="offer_usage" class="form-control">
                                      </div>
                                      <div class="col-sm-3">
                                        <label>User Usage</label>
                                        <span class="astric">&#42;</span>
                                        <input required type="number" name="user_usage" class="form-control">
                                      </div>
                                      <div class="col-sm-3">
                                          <label>Image</label>
                                          <input type="file" name="image_link" class="form-control">
                                      </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label>Duration</label>
                                        <input type="text" name="duration" class="form-control">
                                      </div>
                                      
                                    <div class="col-sm-6">
                                      <label>Type</label>
                                      <span class="astric">&#42;</span>
                                      <select required name="type" class="form-control">
                                        <option value="0">Select Type</option>
            
                                        <option value="free">free</option>
                                        <option value="paid">paid</option>
            
                                    
                                    </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                  <div class="col-sm-4">
                                      <label>Holding Value</label>
                                      <input  type="number" name="premuim_paid" class="form-control">
                                  </div>
                                  <div class="col-sm-4">
                                    <label>Vendor %</label>
                                    <input required type="number" name="vendor_percent" class="form-control">
                                  </div>
                                  <select class="offer_malls" name="malls[]" id="" multiple="multiple" class="form-control">
                                
                                   </select>
                                  </div>
                                  <div class="col-sm-4 d-none">
                                    <label>Admin %</label>
                                    <input  type="number" name="admin_percent" class="form-control">
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
                         @if(Auth::user()->category_title=="emergency_car" || (request()->filled("type") && request()->type=='emergency_car'))
                          <div class="modal-body" >	
                            <div class="form-row">
                              <div class="col-sm-6">
                                <label>From</label>
                                <iframe id="source_iframe" style="display:block;" src="http://maps.google.com/maps?q=X,Y&z=15&output=embed" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                              </div>
                              <div class="col-sm-6">
                                <label>to</label>
                                <iframe id="destination_iframe" style="margin-left: 5%; display:block;" src="http://maps.google.com/maps?q=X,Y&z=15&output=embed" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                              </div>
                            </div>
                              <div class="form-row">
                                  <div class="col-sm-6">
                                    <label>Message</label>
                                    <textarea type="text" id="request_note" readonly class="form-control"  placeholder=""  ></textarea>
                                  </div>
                                  <div class="col-sm-6">
                                    <label>Response</label>
                                    <span class="astric">&#42;</span>
                                    <textarea required type="text" id="response_note" name="response_note" class="form-control"  placeholder=""  ></textarea>
                                  </div>               
                              </div>
                              <div class="form-row">
                                <div class="col-sm-6">
                                  <label>Customer Name</label>
                                  <input type="text" id="customer_name"  class="form-control"  readonly  >
                                </div>
                                <div class="col-sm-6">
                                  <label>Customer Phone</label>
                                  <input required type="text" id="customer_phone"  class="form-control"  readonly  >
                                </div>               
                              </div>

                              <div class="form-row">
                                <div class="col-sm-6">
                                  <label>Car Model</label>
                                  <input type="text" id="car"  class="form-control"  placeholder="" value=""  >
                                </div>
                                <div class="col-sm-6">
                                  <label>Estimated Distance</label>
                                  <input required type="text" name="distance" id="estimated_distance"  class="form-control"  placeholder=""  readonly >
                                </div>                    
                              </div>
                              
                              
                              <div class="form-row"> 
                                <div class="col-sm-3">
                                  <label>Min Cost Per kilo</label>
                                  <input required type="text" name="min_cost_per_kilo" id="min_cost_per_kilo"  class="form-control"  placeholder=""  >
                                </div>    
                                <div class="col-sm-3">
                                  <label>Min Estimated Cost</label>
                                  <input required type="text" id="min_estimated_cost"  class="form-control"  placeholder=""  >
                                </div>    
                                <div class="col-sm-3">
                                  <label>Max Cost Per kilo</label>
                                  <input required type="text" name="max_cost_per_kilo" id="max_cost_per_kilo"  class="form-control"  placeholder=""  >
                                </div>   
                                <div class="col-sm-3">
                                  <label>Max Estimated Cost</label>
                                  <input required type="text" id="max_estimated_cost"  class="form-control"  placeholder=""  >
                                </div>    
                                        
                              </div>
                              
                            
                            
                              <div class="form-row">
                                <div class="col-sm-3">
                                  <label>Accept</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="accepted"  placeholder=""  >
                                </div>
                                <div class="col-sm-3">
                                  <label>Reject</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="rejected"  placeholder=""  >
                                </div>
                               </div>
                               <input value="" name="state"  class="d-none hidden_state">
                          </div>
                          @elseif(Auth::user()->category_title=="car_washer" || (request()->filled("type") && request()->type=='car_washer'))
                          <div class="modal-body" >	

                              <div class="form-row">
                                  <div class="col-sm-12">
                                    <label>Message</label>
                                    <textarea type="text" id="request_note" readonly class="form-control"  placeholder=""  ></textarea>
                                  </div>
                              </div>
                              <div class="form-row">
                                <div class="col-sm-12">
                                  <label>Response</label>
                                  <span class="astric">&#42;</span>
                                  <textarea required type="text" id="response_note" name="response_note" class="form-control"  placeholder=""  ></textarea>
                                </div>
                               </div>

                               <div class="form-row">
                                <div class="col-sm-6">
                                  <label>Accept</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="accepted"  placeholder=""  >
                                </div>
                                <div class="col-sm-6">
                                  <label>Reject</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="rejected"  placeholder=""  >
                                </div>
                               </div>


                               <input value="" name="state"  class="d-none hidden_state">
                          
                                  
                      
                          </div>
                          @elseif(Auth::user()->category_title=="supplier" || (request()->filled("type") && request()->type=='supplier')) 
                          <div class="modal-body" >	
                           
                            <div class="form-row">
                              <div class="col-sm-6">
                                <label>Address</label>
                                <input type="text" id="destination_address"  class="form-control"  placeholder=""  >
                              </div>
                              <div class="col-sm-6">
                                <label>Location</label>
                                <iframe id="location" style="display:block;" src="http://maps.google.com/maps?q=X,Y&z=15&output=embed" width="400" height="50" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                              </div>               
                            </div>
                            
                              <div class="form-row">
                                  <div class="col-sm-12">
                                    <label>Message</label>
                                    <textarea type="text" id="request_note" readonly class="form-control"  placeholder=""  ></textarea>
                                  </div>
                              </div>
                              <div class="form-row">
                                <div class="col-sm-12">
                                  <label>Response</label>
                                  <span class="astric">&#42;</span>
                                  <textarea required type="text" id="response_note" name="response_note" class="form-control"  placeholder=""  ></textarea>
                                </div>
                               </div>

                               <div class="form-row">
                                <div class="col-sm-3">
                                  <label>Accept</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="accepted"  placeholder=""  >
                                </div>
                                <div class="col-sm-3">
                                  <label>Reject</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="rejected"  placeholder=""  >
                                </div>
                                <div class="col-sm-3">
                                  <label>Shipping</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="shipping"  placeholder=""  >
                                </div>
                                <div class="col-sm-3">
                                  <label>Received</label>
                                  <span class="astric">&#42;</span>
                                  <input class="state_radio" type="radio" name="state_checkbox" value="received"  placeholder=""  >
                                </div>
                               </div>


                               <input value="" name="state"  class="d-none hidden_state">
                          
                                  
                      
                          </div>
                          @endif
                          <div class="modal-footer">
                              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                              <input type="submit" class="btn btn-success" value="Send">
                          </div>
                      </form>
                  </div>
              </div>
        </div>

            <!-- Delete Modal HTML -->
            <div id="RejectServiceModal" class="modal fade DeleteModal">
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
    
    
      $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $(this).find("textarea[name=branches_name]").text("");
    
      })
    
      $(".multiselect-native-select").addClass("form-control");

    $(document).on("click",".edit_row",function(){
      
      var targeted_row=$(this).parent().parent();
      var id=targeted_row.attr("data-id");
      var category_type=targeted_row.attr("data-category_type");
      var premuim_paid=targeted_row.attr("data-premuim_paid");

      var name=targeted_row.find(".name").text();
      var vendor_name=targeted_row.find(".vendor_name").text();
      var vendor_id=targeted_row.find(".vendor_name").attr("data-vendor_id");

      var description=targeted_row.attr("data-description");
      var duration=targeted_row.attr("data-duration");
      var type=targeted_row.attr("data-type");
      var vendor_percent=targeted_row.attr("data-vendor_percent");

      var branches_name=JSON.parse(targeted_row.attr("data-branches"));
      var malls=JSON.parse(targeted_row.attr("data-malls_id"));
      $(".added_option").remove();
      var options = [];
     // $('.offer_malls').multiselect();
     var all_malls=JSON.parse($("#all_malls").text());
     console.log(all_malls);


      $.each(all_malls,function(key,value){
        if(malls.indexOf(value.id)!=-1){
          options.push({label: value.name, title:value.name, value: value.id,selected:true});

        }
        else{
          options.push({label: value.name, title:value.name, value: value.id,selected:false});

        }

      //  $('.offer_malls').append($('<option selected class="added_option">').val(value.id).text(value.name))
        console.log(value);
      });


    $('.offer_malls').multiselect('dataprovider', options)
     
      $("#EditForm").find(".btn-group").css("margin-top","29px");

      $.each(branches_name,function(key,value){
           $('#offer_branches').append($('<option selected>').val(value.id).text(value.name))

          //to view each branch in new line
          if(key!=branches_name.length-1){
             $("#EditOfferModal").find("textarea[name=branches_name]").append(value.name+"\n");
          }
          // and if its the last line i only add the branch name without new line
          else{
             $("#EditOfferModal").find("textarea[name=branches_name]").append(value.name);
          }
    
      });
      $('#offer_branches').selectator();

    
      var discount=targeted_row.find(".discount").find("span").text();
      var price_before_discount=targeted_row.find(".price_before_discount").text();
      var price_after_discount=targeted_row.find(".price_after_discount").text();
      var points=targeted_row.find(".points").text();
      var offer_usage=targeted_row.attr("data-offer_usage");
      var user_usage=targeted_row.attr("data-user_usage");


     
      $("#EditServiceModal").find("select[name=type]").val(type);
      $("#EditServiceModal").find("input[name=duration]").val(duration);
      $("#EditServiceModal").find("input[name=vendor_percent]").val(vendor_percent);

     // $("#EditOfferModal").find("select[name=category_type]").val(category_type);
      $("#EditServiceModal").find("input[name=name]").val(name);
      $("#EditServiceModal").find("textarea[name=description]").val(description);
    
      $("#EditServiceModal").find("input[name=price_before_discount]").val(price_before_discount);
      $("#EditServiceModal").find("input[name=price_after_discount]").val(price_after_discount);
      $("#EditServiceModal").find("input[name=points]").val(points);
      $("#EditServiceModal").find("input[name=offer_usage]").val(offer_usage);
      $("#EditServiceModal").find("input[name=user_usage]").val(user_usage);
      $("#EditServiceModal").find("input[name=premuim_paid]").val(premuim_paid);

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
    
    $(".price_change").on("change",function(){
        
      var targeted_model=$(this).parent().parent().parent();	
      var price_before_discount=parseFloat(targeted_model.find("input[name=price_before_discount]").val());
      var discount=parseFloat(targeted_model.find("input[name=discount]").val())/100;
      targeted_model.find("input[name=price_after_discount]").val(price_before_discount-(price_before_discount*discount));
    
    
    })
    
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
                    tr.find(".account_name").text(result[i].user.account_name);
                    tr.find(".phone").text(result[i].user.phone);
                    tr.find(".email").text(result[i].user.email);
                    tr.find(".state").text(result[i].state);
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
    
    $(".close").click(function(){
      $("#myModal").css("display","none");

   //  t.clear().draw();

    });
    
    $(document).on("click",".promote",function(){
        var id=$(this).parent().parent().attr("data-id");
        var url=$("#offersupdate").val();
        var res = url.replace("X", id);
        var result=ajaxFunction({"promote":1},res,"put");
        console.log(result);
        if(result.promoted==1){
            alert("Offer has Promoted");
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
      var url=$("#offersupdate").val();
      var res = url.replace("X", id);
      if($(this).hasClass("fa-times")){
        var result=ajaxFunction({"approved":0},res,"put");
      }
      else{
        var result=ajaxFunction({"approved":1},res,"put");
      }
      console.log(result);
      if(result.approved==1){
          alert("Offer has Approved");
          var parenttag=$(this).parent();
          $(this).remove();
          parenttag.append($(".disapprove-icon").clone().removeClass("disapprove-icon"));
      }
      else if(result.approved==0){
        alert("Offer has Disapproved");
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
        var url=$("#offersupdate").val();
        var res = url.replace("X", id);
        var result=ajaxFunction({"promote":0},res,"put");
        console.log(result);
    
        if(result.promoted==0){
            alert("Offer has UnPromoted");
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
      var source_latitude=targeted_row.attr("data-source_latitude");
      var source_longitude=targeted_row.attr("data-source_longitude");
      var destination_latitude=targeted_row.attr("data-destination_latitude");
      var destination_longitude=targeted_row.attr("data-destination_longitude");
      var max_cost_per_kilo=targeted_row.attr("data-max_cost_per_kilo");
      var min_cost_per_kilo=targeted_row.attr("data-min_cost_per_kilo");
      var distance=targeted_row.attr("data-distance");

      $("#min_cost_per_kilo").val(min_cost_per_kilo);
      $("#max_cost_per_kilo").val(max_cost_per_kilo);
      $("#min_estimated_cost").val(min_cost_per_kilo*distance);
      $("#max_estimated_cost").val(max_cost_per_kilo*distance);

      var link= $("#map_link").val();
      link=link.replace("X", source_latitude);
      link=link.replace("Y", source_longitude);
      $("#source_iframe").attr("src",link)

      link= $("#map_link").val();
      link=link.replace("X", destination_latitude);
      link=link.replace("Y", destination_longitude);

      $("#destination_iframe").attr("src",link)

      
      var customer_name=targeted_row.attr("data-customer_name");
      var customer_phone=targeted_row.attr("data-customer_phone");
      
      var car=targeted_row.attr("data-car");
      var destination_address=targeted_row.attr("data-destination_address");
      link= $("#map_link").val();
      link=link.replace("X", destination_latitude);
      link=link.replace("Y", destination_longitude);
      $("#location").attr("src",link);

      var response=targeted_row.attr("data-response");
      $("#response_note").val(response);
      $("#car").val(car);
      $("#estimated_distance").val(distance);
      $("#destination_address").val(destination_address);

      var state= targeted_row.find(".state").text();
      $("input[name=state_checkbox][value='"+state+"']").prop("checked",true);




 
      var url=$("#RequestsUpdate").val();
      var res = url.replace("X", id);
      $("#request_note").val(targeted_row.attr("data-request_note"));
      $("#updateform").attr("action",res);





    });
    
var modal = $("#myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = $("#offer_image");
var modalImg = $("#img01");
var captionText = $("#caption");
$(".offer_image").click(function(){
  $("#myModal").css("display","block");
  $("#img01").attr("src",$(this).attr("src"));
});


  $(".state_radio").change(function(){
  $(".hidden_state").val($('input[name="state_checkbox"]:checked').val());

  });

  $(document).on("change","#min_cost_per_kilo",function(){
        var val=$(this).val();
        $("#min_estimated_cost").val(val*$("#estimated_distance").val());

  })
  $(document).on("change","#max_cost_per_kilo",function(){
    var val=$(this).val();
    $("#max_estimated_cost").val(val*$("#estimated_distance").val());

})


    </script>
    
  </body>
</html>