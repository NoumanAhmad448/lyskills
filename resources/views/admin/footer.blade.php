@section('footer')    
    <footer class="text-center bg-website p-3">
        Lyskills All rights are reserved. 
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" 
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

            $('#a_setting').click(()=>{
                let menu = $('.s_sub_menu');
                if(menu.hasClass('d-none')){
                    menu.removeClass('d-none');
                }else{
                    menu.addClass('d-none');
                }
            });

        });  
    </script>
@yield('page-js')
    </body>
</html>
@endsection