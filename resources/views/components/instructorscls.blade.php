<div>
    <h1>
        {{ $title ?? 'Monthly Payment' }} 
    </h1>
    @include('session_msg')
    <div class="table-responsive mt-4">

    <table class="table" id="instructor">
        <thead>
          <tr>
            <th scope="col"> name </th>
            <th scope="col"> Email </th>
            <th scope="col"> More </th>            
          </tr>
        </thead>
        <tbody>
    @foreach ($users as $user)
        <tr>
            <td scope="row"> {{ $user->name ?? '' }} </td>
            <td> {{ $user->email ?? '' }} </td>
            <td> <a href="{{ route('v_i_detail', ['user' => $user->id]) }}" > Detail </a> </td>        
            
      </tr>
    @endforeach

        </tbody>
    </table>
</div>

  
</div>