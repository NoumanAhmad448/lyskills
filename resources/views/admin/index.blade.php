@extends('admin.admin_main')


@section('content')

    <div class="container">
        <h1> Admin </h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card" >
                    <div class="card-body text-center">
                      <h5 class="card-title"> User </h5>
                      <p class="card-text"> {{ $users ?? ''}} </p>
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card" >
                    <div class="card-body text-center">
                      <h5 class="card-title"> Articles </h5>
                      <p class="card-text"> {{ $articles ?? ''}} </p>
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card" >
                    <div class="card-body text-center">
                         <h5 class="card-title"> Assignments </h5>
                      <p class="card-text"> {{ $assignments ?? ''}} </p>                      
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card" >                    
                    <div class="card-body text-center">
                         <h5 class="card-title"> Courses </h5>
                      <p class="card-text"> {{ $courses ?? ''}} </p>                      
                    </div>
                  </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3">
                <div class="card" >                    
                    <div class="card-body text-center">
                         <h5 class="card-title"> Students </h5>
                      <p class="card-text"> {{ $students ?? ''}} </p>                      
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card" >                    
                    <div class="card-body text-center">
                         <h5 class="card-title"> Instructors </h5>
                      <p class="card-text"> {{ $instructors ?? ''}} </p>                      
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card" >                    
                    <div class="card-body text-center">
                         <h5 class="card-title"> Resource Videos </h5>
                      <p class="card-text"> {{ $c_videos ?? ''}} </p>                      
                    </div>
                  </div>
            </div>
            <div class="col-md-3">
                <div class="card" >                    
                    <div class="card-body text-center">
                         <h5 class="card-title"> Lectures  </h5>
                      <p class="card-text"> {{ $lectures ?? ''}} </p>                      
                    </div>
                  </div>
            </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-3">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title"> Videos  </h5>
                  <p class="card-text"> {{ $media ?? ''}} </p>                      
                </div>
              </div>
        </div>
        
          <div class="col-md-3">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title">  Resources  </h5>
                  <p class="card-text"> {{ $o_files ?? ''}} </p>                      
                </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title"> Coupons  </h5>
                  <p class="card-text"> {{ $coupons ?? ''}} </p>                      
                </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title"> Quizzes  </h5>
                  <p class="card-text"> {{ $quizzes ?? 0}} </p>                      
                </div>
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title"> Bloggers  </h5>
                  <p class="card-text"> {{ $bloggers ?? 0}} </p>                      
                </div>
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title"> Earning  </h5>
                  <p class="card-text"> ${{ $earning ?? 0}} </p>                      
                </div>
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title"> Admins  </h5>
                  <p class="card-text"> {{ $admins ?? 0}} </p>                      
                </div>
            </div>
          </div>
          <div class="col-md-3 mt-2">
            <div class="card" >                    
                <div class="card-body text-center">
                     <h5 class="card-title"> Enrollements  </h5>
                  <p class="card-text"> {{ $enrollments ?? 0}} </p>                      
                </div>
            </div>
          </div>
        </div>  
      </div>
      
      <div id="chart_div" class="mt-5"></div>
    </div>
    
@endsection



@section('page-js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  google.charts.load('current', {'packages':['corechart','bar']});

  
  google.charts.setOnLoadCallback(drawChart);


  function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    // data.addColumn('number', 'Dates');
    // data.addColumn('number', 'Earning');
    
    
 

    // data.addRows([
    //       [1, 3],
    //       [2, 3],
    //       [3, 3],
    //       [4, 30],
    //       [5, 30]          
    //     ]);

    
    var options = {'title':'Monthly Earning',
    
    var chart = new google.charts.Bar(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
@endsection