<div class="container-fluid">
  <footer class="footer-bg mt-auto">
    <div class="container-fluid">
      <div class="row pt-2 pt-md-5">
        <div class="col-md-3 mt-3 mt-md-0">
          <h3 class="mb-3"> About US </h3>
          <div class="text-justify">
            Lyskills is a LMS platform that connect Teachers with Students globally. Teachers create high quality course
            and present them in super easy way
          </div>

        </div>

        <div class="col-md-3 mt-3 mt-md-0">
          <h3 class="mb-3"> Links </h3>
          <ul class="list-unstyled">
            <li class="mt-2"><a class="text-white" href="{{route('login')}}"> Login </a></li>
            <li class="mt-2"><a class="text-white" href="{{route('register')}}"> Register </a></li>
            <li class="mt-2"><a class="text-white" href="{{url('forgot-password')}}"> Forget Password </a></li>
            <li class="mt-2"><a class="text-white" href="{{route('index')}}"> Home </a></li>
            <li class="mt-2"><a class="text-white" href="{{route('public_faq')}}">FAQs</a></li>
            <li class="mt-2"><a class="text-white" href="{{route('all_public_posts')}}">Posts</a></li>
            <li class="mt-2"><a class="text-white" href="{{route('dashboard')}}">Instructor Dashboard </a></li>
            <li class="mt-2"><a class="text-white" href="{{route('contact-us')}}">Contact Us </a></li>
          </ul>

        </div>

        <div class="col-md-3 mt-3 mt-md-0">
          <ul class="list-unstyled">
            <li class="mt-2"><a class="text-white" href="https://lyskills.com/page/about-us"> About Us </a></li>
            <li class="mt-2"><a class="text-white" href="https://lyskills.com/page/privacy-policy"> Privacy Policy </a>
            </li>
            <li class="mt-2"><a class="text-white" href="https://lyskills.com/page/terms-and-conditions"> Terms &
                Conditions
              </a></li>
          </ul>
        </div>

        <div class="col-md-3 mt-3 mt-md-0">
          <h3 class="mb-3">Our Office </h3>
          <div>
            Ground floor Akram Plaza, Muslim Town, Ferozepur Road, near Baba Qulfi wala, Lahore
          </div>

          <h3 class="my-3">Follow Us</h3>
          <div class="d-inline text-white">
            <a class="text-white mr-2" href="https://www.facebook.com/Lyskills-113826713695283">
              <i class="fa fa-facebook-official" aria-hidden="true"></i>
            </a>

            <a class="text-white mr-2" href="https://www.instagram.com/lyskills/">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
            <a class="text-white mr-2" href="https://www.youtube.com/channel/UCa-M0ECvodmuNP8wlzm_YIQ">
              <i class="fa fa-youtube-play" aria-hidden="true"></i>
            </a>
            <a class="text-white mr-2" href="https://wa.me/923349376619"> <i class="fa fa-whatsapp"
                aria-hidden="true"></i>
            </a>
            <a class="text-white mr-2" href="https://www.linkedin.com/company/lyskills"> <i class="fa fa-linkedin"
                aria-hidden="true"></i>
            </a>
            <a class="text-white" href="https://twitter.com/lyskills1"> <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
          </div>
        </div>

      </div>
      <div class="row mt-3 pb-3">
        <div class="col">
          <p class="text-center">&copy; Copyright {{date('Y')}}- Lyskills. All Rights Are Reserved.</p>
        </div>
      </div>
    </div>
  </footer>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script>
  $(function(){
          $('.loading-section').css('height',0);
          $('#loading', '.loading-section').fadeOut();
      });
</script>
<script>
  $(function(){
    $(".show-dropdown, .categories_menu").mouseenter(function(){
           $(".categories_menu").show(); 
         });
  
        $(".show-dropdown, .categories_menu").mouseleave(function(){
          $(".categories_menu").hide(); 
        });
  });  
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
 crossorigin="anonymous"></script>
<script>
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
                              q: request.term
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
          });     
</script>
<!--load whatsapp-->
<a href="https://wa.me/923349376619" class="whatsapp mr-3 mb-4" style="position: fixed; left: 5;bottom:0"> <img
    src="https://img.icons8.com/color/48/000000/whatsapp--v4.png" style="width: 4.5rem" alt="whatsapp" /> </a>
<!--messenger-->

<script async defer crossorigin="anonymous"
  src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0&appId=444177396566651&autoLogAppEvents=1"
  nonce="XPw3MZUm"></script>
<!-- Load Facebook SDK for JavaScript -->

<script>
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
</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat" style="bottom: 10px" attribution=setup_tool page_id="113826713695283"
  greeting_dialog_display="hide">
</div>

@yield('script')