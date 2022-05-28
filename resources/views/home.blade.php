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
    <link href="fm.selectator.jquery.css" rel="stylesheet">
    <script src="fm.selectator.jquery.js"></script> 
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
      <select id="MonthlySales">
          @foreach($monthly_sales as $key=>$value)
          <option value="{{$value}}">{{$key}}</option>
          @endforeach
      </select>
      
      <select id="VendorSales">
        @foreach($vendors_sales as $key=>$value)
        <option value="{{$value}}">{{$key}}</option>
        @endforeach
      </select>
    @if(Auth::user() && Auth::user()->account_type=="Admin")
      <select id="MostCategories">
      @foreach($most_categories as $key=>$value)
      <option value="{{$value}}">{{$key}}</option>
      @endforeach
    </select>
    @endif

    <select id="MostServices">
      @foreach($most_services as $key=>$value)
      <option value="{{$value}}">{{$key}}</option>
      @endforeach
    </select>
    @if(Auth::user() && Auth::user()->account_type=="Vendor")
    <select id="MostBranches">
      @foreach($most_branches as $key=>$value)
      <option value="{{$value}}">{{$key}}</option>
      @endforeach
    </select>
    @endif
    
     @if($errors->any())
     <input id="error-box" value="{{$errors->first()}}" class="d-none">         
     @endif
    <i class="fa fa-angle-double-up temppromote promote" aria-hidden="true"></i>
    <i class="fa fa-angle-double-down tempunpromote unpromote" aria-hidden="true"></i>
    <i class="fa fa-check-square-o approve-icon approve" aria-hidden="true"></i>
    <i class="fa fa-times disapprove-icon approve" aria-hidden="true"></i>



    <input value="0" id="DataTableIntialized" class="d-none">

	

	<!---delete Form to fill it and submit --->
	<div class="d-none">
		<form id="DeleteForm" action="" method="post" data-link="">
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
            @if(Auth::user()->account_type=="Admin")
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Top 100 Vendors From<i class="mdi mdi-bookmark-check mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\User::where("account_type","Vendor")->count()}}</h2>
                    <h6 class="card-text"><a href="">Export To Excel</a> </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Vendors<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\User::where("account_type","vendor")->count()}}</h2>
                    <h6 class="card-text"><a href="">Export To Excel</a> </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Top 100 Categories From <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{App\Models\Category::count()}}</h2>
                    <h6 class="card-text"><a href="">Export To Excel</a> </h6>
                  </div>
                </div>
              </div>
            </div>
            @endif
            <div class="row">
              @if(Auth::user()->account_type=="Admin")
                <div class="col-lg-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Most Categories Usage</h4>
                      <canvas id="customersbarChart" style="height:230px"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Top 5 Vendors </h4>
                      <canvas id="barChart" style="height:230px"></canvas>
                    </div>
                  </div>
                </div>
                @endif
              </div>

              <div class="row">
                <div class="col-lg-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Most Services Usage</h4>
                      <canvas id="servicesbarchart" style="height:250px"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Last Five Months Sales</h4>
                      <canvas id="lineChart" style="height:250px"></canvas>
                    </div>
                  </div>
                </div>
                @if(Auth::user()->account_type=="Vendor")
                <div class="col-lg-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Highest Branches Sells</h4>
                      <canvas id="branchesbarChart" style="height:230px"></canvas>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>


          
          <!-- content-wrapper ends -->

          <table id="tempTable">
            <tr class="tr">
                <td class="full_name"></td>
                <td class="account_name"></td>
                <td class="phone"></td>
                <td class="email"></td>
                <td class="usage"></td>
                
                
            </tr> 
            </table>
           
      
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
    <script src="{{asset("assets/js/chart.js")}}"></script>

    <!-- End custom js for this page -->
    <script>
         var labels=[];
         var data=[];
        $("#MonthlySales option").each(function(i){
             labels.push($(this).text());
              data.push($(this).val());
        });
    
        var data = {
            labels: labels,
            datasets: [{
              label: '# of Votes',
              data: data,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
            }]
          };
        
          var options = {
            title: {
                display: true,
                text: 'Sales in EGP',
                position:"left"
            },
           
            
            
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            },
            legend: {
              display: false
            },
            elements: {
              point: {
                radius: 0
              }
            }
        
          };


  if ($("#lineChart").length) {
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: data,
      options:options
    });
  };

  
  var labels=[];
  var data=[];


  $("#VendorSales option").each(function(i){
       labels.push($(this).text());
       data.push($(this).val());
 });
 var data = {
    labels: labels,
    datasets: [{
      label: '# of Votes',
      data: data,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1,
      fill: false
    }]
  };

  var options = {
    title: {
        display: true,
        text: 'Sales in EGP',
        position:"left"
    },
   
    
    
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 0
      }
    }

  };

  if ($("#barChart").length) {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: data,
      options: options
    });
  }

  var labels=[];
  var data=[];

  $("#MostCategories option").each(function(i){
    labels.push($(this).text());
    data.push($(this).val());
  });
 var data = {
  labels: labels,
  datasets: [{
   label: '# of Votes',
   data: data,
   backgroundColor: [
     'rgba(255, 99, 132, 0.2)',
     'rgba(54, 162, 235, 0.2)',
     'rgba(255, 206, 86, 0.2)',
     'rgba(75, 192, 192, 0.2)',
     'rgba(153, 102, 255, 0.2)',
     'rgba(255, 159, 64, 0.2)'
   ],
   borderColor: [
     'rgba(255,99,132,1)',
     'rgba(54, 162, 235, 1)',
     'rgba(255, 206, 86, 1)',
     'rgba(75, 192, 192, 1)',
     'rgba(153, 102, 255, 1)',
     'rgba(255, 159, 64, 1)'
   ],
   borderWidth: 1,
   fill: false
 }]
};

var options = {
 title: {
     display: true,
     text: 'Most Categories Usage',
     position:"left"
 },

 
 
 scales: {
   yAxes: [{
     ticks: {
       beginAtZero: true
     }
   }]
 },
 legend: {
   display: false
 },
 elements: {
   point: {
     radius: 0
   }
 }

};

if ($("#customersbarChart").length) {
 var barChartCanvas = $("#customersbarChart").get(0).getContext("2d");
 // This will get the first returned node in the jQuery collection.
 var barChart = new Chart(barChartCanvas, {
   type: 'bar',
   data: data,
   options: options
 });
}


    var labels=[];
    var data=[];

    $("#MostServices option").each(function(i){
      labels.push($(this).text());
      data.push($(this).val());
    });
    var data = {
    labels: labels,
    datasets: [{
    label: '# of Votes',
    data: data,
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
      'rgba(255,99,132,1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1,
    fill: false
    }]
    };

    var options = {
    title: {
      display: true,
      text: 'Number Of Service Usage',
      position:"left"
    },



    scales: {
    yAxes: [{
      ticks: {
        beginAtZero: true
      }
    }]
    },
    legend: {
    display: false
    },
    elements: {
    point: {
      radius: 0
    }
    }

    };

    if ($("#servicesbarchart").length) {
    var barChartCanvas = $("#servicesbarchart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
    type: 'bar',
    data: data,
    options: options
    });
    }


    
  var labels=[];
  var data=[];

  $("#MostCategories option").each(function(i){
    labels.push($(this).text());
    data.push($(this).val());
  });
 var data = {
  labels: labels,
  datasets: [{
   label: '# of Votes',
   data: data,
   backgroundColor: [
     'rgba(255, 99, 132, 0.2)',
     'rgba(54, 162, 235, 0.2)',
     'rgba(255, 206, 86, 0.2)',
     'rgba(75, 192, 192, 0.2)',
     'rgba(153, 102, 255, 0.2)',
     'rgba(255, 159, 64, 0.2)'
   ],
   borderColor: [
     'rgba(255,99,132,1)',
     'rgba(54, 162, 235, 1)',
     'rgba(255, 206, 86, 1)',
     'rgba(75, 192, 192, 1)',
     'rgba(153, 102, 255, 1)',
     'rgba(255, 159, 64, 1)'
   ],
   borderWidth: 1,
   fill: false
 }]
};

var options = {
 title: {
     display: true,
     text: 'Higest Branches Sells',
     position:"left"
 },

 
 
 scales: {
   yAxes: [{
     ticks: {
       beginAtZero: true
     }
   }]
 },
 legend: {
   display: false
 },
 elements: {
   point: {
     radius: 0
   }
 }

};

if ($("#branchesbarChart").length) {
 var barChartCanvas = $("#branchesbarChart").get(0).getContext("2d");
 // This will get the first returned node in the jQuery collection.
 var barChart = new Chart(barChartCanvas, {
   type: 'bar',
   data: data,
   options: options
 });
}




    </script>
  
    
  </body>
</html>