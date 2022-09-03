<div class="container-fluid footer mt-auto">
    <div class="row bg-white border p-4">
      <div class="col-md-8 d-md-flex text-center align-items-center">
          <img src="{{asset('img/logo.jpg')}}" alt="lyskills" class="img-fluid" width="60"/>
          <div class="ml-md-4"> copyright © {{ date('Y')}} </div>
      </div>
      <div class="col-md-4 d-flex align-items-center">
        <a href="https://lyskills.com/page/terms-and-conditions" class="text-info mr-4"> Terms </a>
        <a href="https://lyskills.com/page/privacy-policy" class="text-info">  Privacy Policy </a>
      </div>
      
    </div>
</div>

<div class="modal fade" tabindex="-1" id="submitCourseModal" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-static-website">
        <h5 class="modal-title "> Course Status </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>

@yield('page-js')

<script>
  $(function(){
    $('#hamburger').click(function(){    
      let side_menu = $('#side_menu');    
      if(side_menu.hasClass('d-none')){
        side_menu.removeClass('d-none');
      }else{
        side_menu.addClass('d-none');
      }
    });    
    
  });


  $('#sub_course').click(function(){      
      let url = $(this).attr('link');    
      if(url){
        $.ajax({
        type: "POST",
        url: url,                
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result) {
            let res = result;             
            if(res['status'] == 'success'){
              let body = $('#submitCourseModal').find('.modal-body');
              if(body.find('.msg').length === 0){
                body.html(`<h4 class="text-center my-3 msg"> Congtratulation </h4><p class="text-justify"> Your course has been submitted for review to lyskills. Now, Please wait for the
                  approval and once it finishes, you course will be available online and other students will be able to enroll </p>
                  <p class="text-justify text-danger"> Due to huge number of daily requests, we take 24-72 hours to process your course so please wait for 
                  our response </p>`);
                  
                }                
              }else{
                let body = $('#submitCourseModal').find('.modal-body');
                if(body.find('.error').length === 0){
                body.html(`<h4 class="text-center mt-3 error p-2 text-danger"> Failed </h4><p> 
                  we are sorry to inform you that, your course cannot be submitted because you did not provide us the following information.
                  Please complete all the remaining section and come back to this option again. Thanks
                  </p><ul class="list-group list-group-flush">`);
                    var errs = "";
                    for (index in res) {                      
                      errs += `<li class="list-group-item"> ${res[index]} </li>`;
                    }
                    errs += '</ul>';
                    body.append(errs);
                }
              }
              $('#submitCourseModal').modal('show'); 
        }      
        });
      }
    });

</script>
</body>
</html>