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
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
     <style>
         details{
             font-size: 18px;
             padding: 40px;
         }
         summary{
             padding: 15px;
         }

     </style>

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

    <input value="0" id="DataTableIntialized" class="d-none">
    <input value="{{route("users.services.index","X")}}" id="GetUserServices">

	  <input value="{{route("check_user_existance","")}}" class="d-none" id="user_existance" >

	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="{{route("users.destroy","")}}">
			@method("delete")
			@csrf
			<button type="submit" id="SubmitDelete">
		</form>
	</div>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include("includes.navbar")
      <!-- partial -->
      <div class="container-fluid page-body-wrapper" style="margin-top: 50px;">
        <!-- partial:partials/_sidebar.html -->
       @include("includes.sidebar")
        <!-- partial -->
          
              
   <div class="container-xl">
       <details>
           <summary>
               Contact Details
           </summary>
           <form  method="post" action="{{route("users.update",Auth::id())}}" enctype="multipart/form-data">
            @csrf
          
            @method("put")

                          <div class="form-row">
                              <div class="col-sm-6 Admin Vendor Normal">
                                <label for="validationDefault02">email</label>
                                <span class="astric">&#42;</span>
                                <input required type="email" name="email" class="form-control" value="{{Auth::user()->email}}"  >
                              </div>
                              <div class="col-sm-6 Admin Vendor Normal">
                                <label for="validationDefault02">full name</label>
                                <span class="astric">&#42;</span>
                                <input required type="text" name="full_name" class="form-control" value="{{Auth::user()->full_name}}"  >
                              </div>
                          </div>
               
                          <div class="form-row">
                              <div class="col-sm-6  Vendor Normal">
                                <label for="validationDefault01">Phone</label>
                                <span class="astric">&#42;</span>
                                <input required type="text" name="phone" class="form-control" maxlength="11" size="11" value="{{Auth::user()->phone}}"  >
                              </div>
                              <div class="col-sm-6 Vendor">
                                <label for="validationDefault01">photo</label>
                                <span class="astric">&#42;</span>
                                <input  type="file" name="photo_link" class="form-control">
                              </div>
                          </div>
                           
                          <div class="form-row">
                            <div class="col-sm-6  Vendor">
                                <label for="validationDefault02">Specifications</label>
                                <span class="astric">&#42;</span>
                              <select style="overflow: auto" class="specifications_list"  name="specifications[]" id="" multiple="multiple" class="form-control">
                                @foreach(App\Models\specification::all() as $specification)       
                                <option @if(in_array($specification->ar_title,json_decode(Auth::user()->GetSpecifications()))) selected @endif>{{$specification->ar_title}}</option>          
                                @endforeach
                              </select>
                           </div>
                         </div>

                         <input type="submit" class="btn btn-success" value="Save" style="float: right">

  
              
                          
         </form>
      </details>
      <details>
        <summary>
            Location Details
        </summary>
        <form  method="post" action="{{route("users.update",Auth::id())}}" enctype="multipart/form-data">
         @csrf
         @method("put")

         <div class="form-row">
            <div class="col-sm-6  Vendor">
                <label for="validationDefault02">City</label>
                <span class="astric">&#42;</span>
                <select required type="text" name="city" class="form-control" value="{{Auth::user()->city}}"  >
                  <option value="">Select City</option>
                  <option @if(Auth::user()->city=="Cairo") selected @endif >Cairo</option>
                  <option @if(Auth::user()->city=="Alex") selected @endif>Alex</option>
                </select>
             </div>
            <div class="col-sm-6  Vendor Normal">
                 <label for="validationDefault02">Address</label>
                 <span class="astric">&#42;</span>
                 <input required type="text" name="address" class="form-control" value="{{Auth::user()->address}}" >
            </div>
         </div>
        <div class="form-row">
             <div class="col-sm-6  Vendor">
                <label for="validationDefault02">latitude</label>
                <span class="astric">&#42;</span>
                <input required type="text" name="latitude" class="form-control" value="{{Auth::user()->latitude}}"  >
             </div>
             <div class="col-sm-6  Vendor">
                <label for="validationDefault02">longitude</label>
                <span class="astric">&#42;</span>
                 <input required type="text" name="longitude" class="form-control" value="{{Auth::user()->longitude}}"  >
            </div>
         </div>
         <input type="submit" class="btn btn-success" value="Save" style="float: right">

      </form>
   </details>

   <details>
    <summary>
        Password
    </summary>
    <form  method="post" action="{{route("users.update",Auth::id())}}" enctype="multipart/form-data">
     @csrf
     @method("put")
        <div class="form-row">
             <div class="col-sm-6 Admin Vendor Normal">
                 <label for="validationDefault02">password</label>
                         <span class="astric">&#42;</span>
                         <input required type="text" name="password" class="form-control"  >
                       </div>
                       <div class="col-sm-6 Admin Vendor Normal">
                           <label for="validationDefault02">confirm password</label>
                           <span class="astric">&#42;</span>
                           <input required type="text" name="password_confirmation" class="form-control" >
                       </div>
                   </div>
                   <input type="submit" class="btn btn-success" value="Save" style="float: right">

  </form>
</details>
    
   </div>
            </div>
          </div>
          <!-- content-wrapper ends -->

            <!-- Users Modal --!>
               
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
                <!-- Image Modal HTML -->

                @include("includes.imgmodal")

                
            <!-- service modal !-->
            <div id="ServiceUsersModal" class="modal fade">
              <div class="modal-dialog" style="width: 85%">
                  <div class="modal-content">
                      <form  method="post" action="{{route("services.store")}}" enctype='multipart/form-data'>
                          @csrf
                          @method("put")

                          <div class="modal-header">						
                              <h4 class="modal-title">Service Users</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
                          <div class="modal-body">					
                          
                              <table class="table table-striped table-hover" style="text-align: center"  id="ServiceUsersTable"> 
                                  <thead>
                                      <tr>
                                          <th>title</th>
                                          <th>type</th>
                                          <th>brand</th>
                                          <th>price</th>
                                          <th>state</th>
                                          <th>vendor</th>

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

          <table id="tempTable">
            <tr class="tr">
                <td class="title"></td>
                <td class="type"></td>
                <td class="brand"></td>
                <td class="price"></td>
                <td class="state"></td>
                <td class="vendor"></td>
            </tr> 
          </table>
       
            
            
         <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2017 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
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
	
	};

	
/*	var obj={};
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
	}*/
	
  
 // ajaxFunction({"permissions":["photos"],"id":2},,"post");

	$(document ).ready(function() {

    $('.specifications_list').multiselect({dropUp: true , maxHeight: 400,
      onDropdownHide: function(event) {
      /*var x=event.target;
        var id=$(x).parent().find("select").attr("data-attr");
        var arr=[];
        $(x).find(".active").each(function() {
          arr.push($(this).attr("title"));
        })
        ajaxFunction({"permissions":arr,"id":id},$("#permission_link").val(),"post");*/

    }
    });
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
  var address=targeted_row.attr("data-address");
  var verified=targeted_row.attr("data-verified");
  var blocked=targeted_row.attr("data-blocked");
  var email=targeted_row.find(".email").text();
  var longitude=targeted_row.attr("data-longitude");
  var latitude=targeted_row.attr("data-longitude");
  var city=targeted_row.attr("data-city");
  var latitude=targeted_row.attr("data-latitude");
  var longitude=targeted_row.attr("data-longitude");
  var specifications_array=targeted_row.find(".specifications").attr("data-specifications");
  var all_branches=JSON.parse(specifications_array);
  

      

  $("#EditUserModal").find(".specifications_list2").find("option").each(function(){
   if(all_branches.indexOf($(this).text())!=-1){
    $(this).attr("selected",true);
   }
  });
  $('.specifications_list2').multiselect();

  /*specifications_array.each(function(){
    

  });*/


  $("#EditUserModal").find("input[name=account_name]").val(account_name);
  $("#EditUserModal").find("input[name=longitude]").val(longitude);
  $("#EditUserModal").find("input[name=latitude]").val(latitude);

  $("#EditUserModal").find("input[name=full_name]").val(full_name);
  $("#EditUserModal").find("select[name=account_type]").val(account_type);
  $("#EditUserModal").find("input[name=phone]").val(phone);
  $("#EditUserModal").find("select[name=category_title]").val(category_title);
  $("#EditUserModal").find("input[name=email]").val(email);

  $("#EditUserModal").find("input[name=latitude]").val(latitude);
  $("#EditUserModal").find("input[name=longitude]").val(longitude);


  $("#EditUserModal").find("input[name=address]").val(address);
  $("#EditUserModal").find("select[name=blocked]").val(blocked);
  $("#EditUserModal").find("select[name=featured]").val(featured);
  $("#EditUserModal").find("select[name=city]").val(city);

 


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
   /* if($(this).val()!=""){
    $("#AddUserModal").find(".col-sm-6").addClass("d-none");
    $("#AddUserModal").find(".col-sm-6").find("input").prop("disabled","true");
    $("#AddUserModal").find(".col-sm-6").find("input").removeAttr("required");
    
    $("#AddUserModal").find(".col-sm-6").find("select").prop("disabled","true");
    $("#AddUserModal").find(".col-sm-6").find("select").removeAttr("required");

    $("#AddUserModal").find(".col-sm-6").find(".astric").addClass("d-none");

    $("#AddUserModal").find("."+$(this).val()).removeClass("d-none");
    $("#AddUserModal").find("."+$(this).val()).find(".astric").removeClass("d-none");

    $("#AddUserModal").find("."+$(this).val()).find("input").removeAttr("disabled");
    $("#AddUserModal").find("."+$(this).val()).find("input").prop("required","true");
    $("#AddUserModal").find("."+$(this).val()).find("select").removeAttr("disabled");
    $("#AddUserModal").find("."+$(this).val()).find("select").prop("required","true");


    }*/
});






});

$(".user_image").click(function(){
  $("#myModal").css("display","block");
  $("#img01").attr("src",$(this).attr("src"));
});

$(".close").click(function(){
  $("#myModal").css("display","none");
  t.clear().draw();

});
     
$("#account_name").focusout(function(){
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
if($.ajax({
    url: $("#user_existance").val()+"/"+$(this).val(),
    type: "GET",
    //request data
    async:false,
    success: function (result)  {
      if(result==0){
        $("#account_name").css("background-color","springgreen");
      }
      else{
        $("#account_name").css("background-color","red");

      }
    },
    error: function (data) {
        alert('Error on updating, please try again later!');
        return false;
    }
}));



});


$(".user_services").click(function() {
    
  var id=$(this).parent().parent().attr("data-id");

  var url=$("#GetUserServices").val();
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

              tr.find(".title").text(result[i].title);
              tr.find(".type").text(result[i].type);
              tr.find(".state").text(result[i].state);
              tr.find(".brand").text(result[i].brand);
              tr.find(".price").text(result[i].price);
              tr.find(".vendor").text(result[i].price);

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

</script>
 
  </body>
</html>