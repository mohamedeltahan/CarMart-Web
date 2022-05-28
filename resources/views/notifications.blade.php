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
     @if($errors->any())
     <input id="error-box" value="{{$errors->first()}}" class="d-none">         
     @endif
    <i class="fa fa-angle-double-up temppromote promote" aria-hidden="true"></i>
	<i class="fa fa-angle-double-down tempunpromote unpromote" aria-hidden="true"></i>

    <input value="0" id="DataTableIntialized" class="d-none">

	

	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="{{route("notifications.destroy","")}}">
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
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Notifications<i class="mdi mdi-bookmark-check mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"></h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Seen Notifications <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"></h2>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Unseen Notifications <i class="mdi mdi-diamond mdi-24px float-right"></i>
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
                                    <a href="{{route("notifications.index")}}" style="color: white">	<h2>Manage <b>Notifications</b></h2> </a>
                                    </div>
                                    <div class="col-sm-4">
                                        <form method="GET" action="{{route("notifications.search")}}">
                                          <div class="input-group mb-3">
                                             <input type="text" @if(isset($value)) value="{{$value}}" @endif name="value" class="form-control" placeholder="Enter Notification Info"  aria-describedby="basic-addon2">
                                             <div class="input-group-append">
                                               <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i>
                                               </button>
                                             </div>
                                          </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="#PushNotificationModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Push Notification</span></a>
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
                                        <th>type</th>
                                        <th>user</th>
                                        <th>seen</th>
                                        <th>description</th>
                                        <th>delete</th>

                                    </tr>
                                </thead>
                                <tbody>
                        
                                    @foreach($notifications["data"] as $notification)
                                    <tr data-id="{{$notification["id"]}}">			
                                        <td>{{$notification["title"]}}</td>	
                                        <td>{{$notification["type"]}}</td>	
                                        <td>{{$notification["user"]["email"]}}</td>	
                                        <td>{{$notification["state"]}}</td>	
                                        <td>{{$notification["description"]}}</td>	
                                        <td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeleteNotificationModal" aria-hidden="true"></i></td>           
                                    </tr> 
                                    
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="clearfix">
                                <div class="hint-text">Showing <b>{{$notifications["total"]}}</b> out of <b>{{$notifications["total"]}}</b> entries</div>
                                <ul class="pagination">
                                  @foreach($notifications["links"] as $url)
          
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
                <td class="account_name"></td>
                <td class="phone"></td>
                <td class="email"></td>
                
            </tr> 
            </table>
            
            <!-- Add Modal HTML -->
            <div id="PushNotificationModal" class="modal fade">
                <div class="modal-dialog" style="width: 85%">
                    <div class="modal-content">
                        <form  method="post" action="{{route("notifications.store")}}" enctype='multipart/form-data'>
                            @csrf
                            <div class="modal-header">						
                                <h4 class="modal-title">Push Notification</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">					
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                          <label>Type</label>
                                          <span class="astric">&#42;</span>
                                          <select required name="type" class="form-control">
                                            <option value="0">Select Type</option>
                                            <option value="alert">alert</option>
                                            <option value="ads">ads</option>

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
                                            <label>Description</label>
                                            <span class="astric">&#42;</span>
                                            <textarea required type="text" name="description" class="form-control" rows="4"   ></textarea>
                                          </div>
                                          
                                        <div class="col-sm-6">
                                          <label>Districs</label>
                                          <select  name="districts[]" multiple class="selectator"  data-selectator-keep-open="true" data-MORE-OPTION="OPTION VALUE">
                                            <option value="">&nbsp;</option>
                                            
                                          </select>  
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                          <label>phone</label>
                                          <input  type="text" name="phone" class="form-control" >
                                        </div>    
                                        <div class="col-sm-6">
                                            <label>Image</label>
                                            <input  type="file" name="image_link" class="form-control">
                                        </div>
                                    </div>
            
                                    
            
                                    <div class="form-row">
                                     

                                        <div class="col-sm-6">
                                          <label>Target Audience</label>
                                          <select name="target_audience" class="form-control">
                                            <option value="0">Select Audience</option>
                                            <option value="ios">ios</option>
                                            <option value="android">Android</option>
                                            <option value="premuim">PremuimAccount</option>
                                        </select>
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
            <div id="EditOfferModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="EditForm" method="post" data-link="" action="" enctype="multipart/form-data">
                            @csrf
                            @method("put")
                            <div class="modal-header">						
                                <h4 class="modal-title">Edit Offer</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">					
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label>Category Type</label>
            
                                        <select name="category_type" class="form-control">
                                            <option value="0">Select Category</option>
            
                                           
                                        </select>
                                     </div>
            
                                     <div class="col-sm-6">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control">
                                      </div>
                       
                                </div>
            
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label>Description</label>
                                        <textarea type="text" name="description" class="form-control"   > </textarea>
                                      </div>
                                      
                                    <div class="col-sm-6">
                                      <label>Branches</label>
                                      <textarea type="text" name="branches_name" class="form-control"> </textarea>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-sm-4">
                                      <label>Discount</label>
                                      <input type="text" name="discount" class="form-control price_change" maxlength="2" >
                                    </div>
                                    <div class="col-sm-4">
                                      <label>Price Before Discount</label>
                                      <input type="number" name="price_before_discount" class="form-control price_change">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Price After Discount</label>
                                        <input type="number" name="price_after_discount" class="form-control" readonly>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="col-sm-4">
                                        <label>Points</label>
                                        <input type="number" name="points" class="form-control">
                                      </div>
                                      <div class="col-sm-4">
                                        <label>Usage</label>
                                        <input type="number" name="usage" class="form-control">
                                      </div>
                                      <div class="col-sm-4">
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
                                      <select name="type" class="form-control">
                                        <option value="0">Select Type</option>
            
                                        <option value="free">free</option>
                                        <option value="paid">paid</option>
            
                                    
                                    </select>
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
            <div id="DeleteNotificationModal" class="modal fade DeleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">						
                                <h4 class="modal-title">Delete Notification</h4>
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
    
    
    $(document).on("click",".edit_row",function(){
      var targeted_row=$(this).parent().parent();
      var id=targeted_row.attr("data-id");
      var category_type=targeted_row.attr("data-category_type");
      var name=targeted_row.find(".name").text();
      var description=targeted_row.attr("data-description");
      var duration=targeted_row.attr("data-duration");
      var type=targeted_row.attr("data-type");
    
      var branches_name=JSON.parse(targeted_row.attr("data-branches"));
      $.each(branches_name,function(key,value){
          //to view each branch in new line
          if(key!=branches_name.length-1){
             $("#EditOfferModal").find("textarea[name=branches_name]").append(value+"\n");
          }
          // and if its the last line i only add the branch name without new line
          else{
             $("#EditOfferModal").find("textarea[name=branches_name]").append(value);
          }
    
      });
      
    
      var discount=targeted_row.find(".discount").text();
      var price_before_discount=targeted_row.find(".price_before_discount").text();
      var price_after_discount=targeted_row.find(".price_after_discount").text();
      var points=targeted_row.find(".points").text();
      var usage=targeted_row.find(".usage").text();
    
     
      $("#EditOfferModal").find("select[name=type]").val(type);
      $("#EditOfferModal").find("input[name=duration]").val(duration);
    
      $("#EditOfferModal").find("select[name=category_type]").val(category_type);
      $("#EditOfferModal").find("input[name=name]").val(name);
      $("#EditOfferModal").find("textarea[name=description]").val(description);
    
      $("#EditOfferModal").find("input[name=price_before_discount]").val(price_before_discount);
      $("#EditOfferModal").find("input[name=price_after_discount]").val(price_after_discount);
      $("#EditOfferModal").find("input[name=points]").val(points);
      $("#EditOfferModal").find("input[name=usage]").val(usage);
    
      $("#EditOfferModal").find("input[name=discount]").val(discount);
    
    
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
    
    $(".price_change").change(function(){
        
      var targeted_model=$(this).parent().parent().parent();	
      var price_before_discount=parseFloat(targeted_model.find("input[name=price_before_discount]").val());
      var discount=parseFloat(targeted_model.find("input[name=discount]").val())/100;
      targeted_model.find("input[name=price_after_discount]").val(price_before_discount-(price_before_discount*discount));
    
    
    })
    
    var t=null;
    $(".fa-users").click(function() {
    
        var id=$(this).parent().parent().attr("data-id");
    
        var url=$("#GetOfferUsers").val();
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
                t= $('#OfferUsersTable').DataTable({
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
    
                    tr.find(".full_name").text(result[i].full_name);
                    tr.find(".account_name").text(result[i].account_name);
                    tr.find(".phone").text(result[i].full_name);
                    tr.find(".email").text(result[i].account_name);
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
    t.clear().draw();
    
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
    </script>
  </body>
</html>