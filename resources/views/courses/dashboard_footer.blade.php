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

@yield('page-js')
<script src="{{asset('js/main.js')}}"></script>
</body>
</html>