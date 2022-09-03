@extends('admin.admin_main')


@section('page-css')
    
@endsection


@section('content')
    @include('session_msg')
    <div class="d-flex justify-content-end my-3">
        <a href="{{route('total-earning-detail', ['id' => $user->id])}}" class="btn btn-website btn-lg"> Total Earning Details</a>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{route('i_payment')}} " class="btn btn-primary"> Back </a>
    </div>
    <section class="d-flex justify-content-between align-items-center">
        <h1> {{ strtoupper($user->name ?? 'Instuctor Name') }} </h1>
        <div class="badge badge-success" style="font-size: 1rem"> Total Earning  ${{ $total_earning ?? 0 }} </div>
        <div class="badge badge-success" style="font-size: 1rem"> Current Month Earning  ${{ $current_month_earning ?? 0 }} </div>

    </section>
    <hr/>
    @if(isset($user) && $user->count())
        <x-monthly-detail :user="$user">
        </x-monthly-detail>
    @endif

    @if($payment_detail && $payment_detail->count())
        {{-- <x-payment-detail :payment_detail = "$payment_detail">
        </x-payment-detail> --}}

        <h2 class="text-uppercase"> Payment Detail </h2>
        @if($payment_detail->b_name)
            <h4 class="text-uppercase mt-4"> Bank Detail </h4>
            <div class="mt-2"> Bank Name : {{ $payment_detail->b_name }} </div>
            <div class="mt-2"> Bank Swift Code : {{ $payment_detail->b_swift_code }} </div>
            <div class="mt-2"> Bank Account Name : {{ $payment_detail->b_account_name }} </div>
            <div class="mt-2"> Bank Account Number : {{ $payment_detail->b_account_no }} </div>
            <div class="mt-2"> Bank Branch Name : {{ $payment_detail->b_branch_name }} </div>
            <div class="mt-2"> Bank Branch Address : {{ $payment_detail->b_branch_addr }} </div>
            <div class="mt-2"> Bank IBAN : {{ $payment_detail->b_iban }} </div>
        @endif
        @if($payment_detail->j_account)
            <h4 class="text-uppercase mt-4"> Jazzcash Account Detail </h4>
            <div class="mt-2"> Jazzcash Mobile Account : {{ $payment_detail->j_account }} </div>            
        @endif
        @if($payment_detail->e_account)
            <h4 class="text-uppercase mt-4"> Easypaisa Account Detail </h4>
            <div class="mt-2"> Easypaisa Mobile Account : {{ $payment_detail->e_account }} </div>            
        @endif
        @if($payment_detail->paypal_account)
            <h4 class="text-uppercase mt-4"> Paypal Account Detail </h4>
            <div class="mt-2"> Paypal Email : {{ $payment_detail->paypal_account }} </div>            
        @endif
        @if($payment_detail->payoneer_account)
            <h4 class="text-uppercase mt-4"> Payoneer Account Detail </h4>
            <div class="mt-2"> Payoneer Email Address : {{ $payment_detail->payoneer_account }} </div>            
        @endif
    @else

        <div class="text-uppercase text-danger text-center"> This Instructor did not provide his payment detail yet </div>
    @endif



    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table  table-hover">                       
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Current Month</th>
                            <th scope="col">Earning </th>                            
                          </tr>
                        </thead>


                        <tbody>
                            @foreach ($payment as $month => $earn)
                                <tr>
                                    <th scope="row"> {{ $month ?? '' }}</th>
                                    <td> ${{ $earn ?? '' }}</td>                            
                                </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                  </div>
            </div>

            <div class="col-md-4">
                <section class="d-flex justify-content-center align-items-center">
                    <form action="{{route('send-email-to-ins')}}" method="post">
                        @csrf 
                        <input type="hidden" name="user" value={{$user->id}}>
                        <button class="btn btn-website btn-lg">
                            Pay Now 
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </div>


    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="table-responsive">
                    <h3> Payment History </h3>
                    <table class="table  table-hover">                       
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Current Month</th>
                            <th scope="col">Payment </th>                            
                            <th scope="col">Paid/unpaid </th>                            
                          </tr>
                        </thead>


                        <tbody>
                            @foreach ($payment_history as $month => $earn)
                                <tr>
                                    <th scope="row"> {{ $month ?? '' }}</th>
                                    <td> ${{ $earn ?? 0 }}</td>                           
                                    @php $p_u = $earn === null; @endphp
                                    <td class="@if(!$p_u) {{ __('bg-success') }} @else {{ __('bg-danger') }} @endif"> {{  $p_u ? 'unpaid' : 'paid' }}</td>                            
                                </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                  </div>
            </div>           
        </div>
    </div>



@endsection