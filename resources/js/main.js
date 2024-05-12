$(".option").click(function(){
    $('.next').attr('disabled',false);
})

$(function(){
    $('.loading-section').fadeOut().removeClass("loader")
    $('#loading').fadeOut()

    $(".show-dropdown, .categories_menu").mouseenter(function(){
        $(".categories_menu").show()
      });

     $(".show-dropdown, .categories_menu").mouseleave(function(){
       $(".categories_menu").hide()
     });
})
$(function() {
    var search = $( "#search_course" );
      search.autocomplete({
          source: function( request, response ) {
              $.ajax({
                  url: "{{route('get-search')}}",
                  type: "post",
                  dataType: "json",
                  headers: {
                      'X-CSRF-TOKEN': "{{csrf_token()}}"
                  },
                  data: {
                      q: request.term,
                  },
                  success: function( data ) {
                      response( data );
                  }
              });
          },
          minLength: 2,
        select: function(event, ui) {
            search.val(ui.item.label);
            search.parents('form').submit();
          }
      });
})

$(function(){
    window.fbAsyncInit = function() {
           FB.init({
             xfbml            : true,
             version          : 'v9.0'
           });
         };

         (function(d, s, id) {
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) return;
         js = d.createElement(s); js.id = id;
         js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
});

$(function(){
    $("#close_user_notification").click(function(){
      localStorage.setItem("closed_user_notification", true)
    })
  })
  if(localStorage.getItem("closed_user_notification")){
    $("#close_user_notification").click()
  }


$(function(){

    $('#hamburger').click(function(){
        let side_menu = $('#side_menu');
        if(side_menu.hasClass('d-none')){
            side_menu.removeClass('d-none');
        }else{
            side_menu.addClass('d-none');
        }
    });

    $('#a_setting').click(()=>{
        let menu = $('.s_sub_menu');
        if(menu.hasClass('d-none')){
            menu.removeClass('d-none');
        }else{
            menu.addClass('d-none');
        }
    });
    $('.loading-section').fadeOut().removeClass("loader")
    $('#loading').fadeOut()



$('#sub_course').click(function(){
    let url = $(this).attr('link')
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
      })
    }
})
});

