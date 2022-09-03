<div>
    <h1>
        Bloggers
    </h1>
    <hr />
    <div class="d-flex justify-content-end">
        <a href="{{route('create_blogger___')}}" class="btn btn-info btn-lg">
            Create Blogger
        </a>
    </div>
    @include('session_msg')
    @if(isset($users) && $users->count())
    <div class="table-responsive mt-4
    ">
        <table class="table">
            <thead class="bg-info  text-white">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                   @if(isSuperAdmin()) <th scope="col">edit</th> @endif
                   @if(isSuperAdmin()) <th scope="col">delete</th> @endif
                </tr>
            </thead>
            <tbody>


                @foreach ($users as $user)
                <tr>
                    <th scope="row"> {{ $user->id ?? '' }} </th>
                    <td> {{ $user->name ?? '' }} </td>
                    <td> {{ $user->email ?? '' }} </td>
                    @if(isSuperAdmin()) <td> <a href="{{route('edit_blogger___',compact('user'))}}" > Edit </a> </td> @endif
                    @if(isSuperAdmin()) <td> <div class="cursor_pointer text-danger del-blogger" link="{{route('delete_blogger___',compact('user'))}}" > Delete </div> </td> @endif
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>

    <div class="modal" tabindex="-1" id="blogger-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header text-white bg-danger">
              <h5 class="modal-title"> Delete Blogger Account </h5>
              <button type="button" class="text-white close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <section class="py-3">
                    <div> You are about to delete the blogger accout. This operation is irreversible which means 
                        you will not be able to login to our site using this profile. 
                    </div>
                    <div> 
                        Are you certain to getrid from this profile ?
                    </div>
                </section>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              <form action="" method="POST" id="delete-form"> 
                  @csrf 
                  @method('delete')                  
                    <button type="submit" class="btn btn-danger"> Delete Profile </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endif

    @section('page-js')      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>  
    <script>
        $(function(){
            $('#show_blogger').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);

            $('.del-blogger').click(function(){
                const url = $(this).attr('link');                
                if(url){                    
                    $('#blogger-modal').find('#delete-form').attr('action',url);
                    $('#blogger-modal').modal('show');
                }
            });
        });

    </script>
    @endsection
</div>