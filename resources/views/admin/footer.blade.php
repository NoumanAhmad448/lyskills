@section('footer')
    <footer class="text-center bg-website p-3">
        Lyskills All rights are reserved.
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{asset('js/main.js')}}"></script>
@yield('page-js')
    </body>
</html>
@endsection