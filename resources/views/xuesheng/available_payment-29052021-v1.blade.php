@extends('layouts.guest')


@section('content')
<div class="container my-4">
    <h1>
        Available Payment Methods
    </h1>
</div>

<div class="container my-5">
    @include('session_msg')
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-light border">
                <section class="d-flex">
                    @if($setting->paypal_is_enable) <a href="" class="btn btn-lg btn-website"> Pay with Paypal </a>
                    @endif
                    @if($setting->s_is_enable) <a href="{{route('credit_card_payment',['slug' => $slug])}}"
                        class="btn btn-lg btn-website ml-4"> Pay with Credit Card </a> @endif
                    @if($setting->j_is_enable) <a href="" class="btn btn-lg btn-website ml-4"> Pay with Jazzcash </a>
                    @endif
                    @if($setting->e_is_enable) <a href="" class="btn btn-lg btn-website ml-4"> Pay with EasyPaisa </a>
                    @endif
                </section>
            </div>
        </div>

    </div>
</div>

<div class="container border mb-3 mt-2 jumbotron bg-light">
    <div class="row my-5">
        <div class="col-12">
            @if(isset($of_p_methods) && $of_p_methods && $of_p_methods->count())
            <h2>
                Offline Methods
            </h2>
            <div class="text-danger mt-3">
                You can choose any available method. First you need to pay by choosing any available method. After that,
                you will click offline payment button and contact us
                with your name and email address that you are using on our website. We will confirm your identify
                against your course Name
                and will enroll you in this course. You can contact us from any method that are available on this page
            </div>
            <div class="mt-5">
                <div class="accordion" id="accordionExample">
                    @if($of_p_methods->b_is_enable)

                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Bank
                                </button>
                            </h2>
                        </div>

                        {{-- @if($of_p_methods->b_is_enable) --}}
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="border p-4">
                                    <div class=" bg-website text-white w-100 text-center p-3 mb-3"
                                        style="font-size: 1.2rem">Bank</div>
                                    <section class="row">
                                        <div class="col-6">
                                            <div> Bank Name </div>
                                        </div>
                                        <div class="col-6">
                                            <b> {{$of_p_methods->b_bank_name}} </b>
                                        </div>
                                        <div class="col-6">
                                            <div> Account Name </div>
                                        </div>
                                        <div class="col-6">
                                            <b> {{$of_p_methods->b_account_name}} </b>
                                        </div>

                                        <div class="col-6">
                                            <div> Bank Swift Code </div>
                                        </div>
                                        <div class="col-6">
                                            <b> {{$of_p_methods->b_swift_code}} </b>
                                        </div>

                                        <div class="col-6">
                                            <div> Bank Account Number </div>
                                        </div>
                                        <div class="col-6">
                                            <b> {{$of_p_methods->b_account_number}} </b>
                                        </div>

                                        <div class="col-6">
                                            <div> Bank Branch Name </div>
                                        </div>
                                        <div class="col-6">
                                            <b> {{$of_p_methods->b_branch_name}} </b>
                                        </div>

                                        <div class="col-6">
                                            <div> IBAN </div>
                                        </div>
                                        <div class="col-6">
                                            <b> {{$of_p_methods->iban}} </b>
                                        </div>
                                        <div class="col-6">
                                            <div> Note </div>
                                        </div>
                                        <div class="col-6">
                                            @php $note = $of_p_methods->b_note @endphp
                                            <b class="text-danger"> {{$note}} </b>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($of_p_methods->j_is_enable)
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Jazzcash
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="border p-4">
                                    <div class=" mb-3  bg-website text-white w-100 text-center p-3"
                                        style="font-size: 1.2rem">Jazzcash
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div> Jazzcash Mobile Number </div>
                                        </div>
                                        <div class="col-6">
                                            <div><b> {{$of_p_methods->j_mobile_number}} </b> </div>
                                        </div>
                                        <div class="col-6">
                                            <div> Jazzcash Account Name </div>
                                        </div>
                                        <div class="col-6">
                                           <div> <b> {{$of_p_methods->j_account_name}} </b> </div>
                                        </div>
                                    @php $note = $of_p_methods->j_note @endphp
                                    @if($note)
                                
                                    <div class="col-6">
                                        <div> Note</div>
                                    </div>
                                    <div class="col-6">
                                        <b class="text-danger"> {{$note}} </b>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($of_p_methods->e_is_enable)

        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Easypaisa
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="border p-4">
                        <div class=" mb-3  bg-website text-white w-100 text-center p-3 " style="font-size: 1.2rem">
                            EasyPaisa
                        </div>
<div class="row">
    <div class="col-6">
        <div> Easypaisa Mobile Number </div>
    </div>
                      <div class="col-6">
                        <b class="ml-5"> {{$of_p_methods->e_mobile_number}} </b> 
                      </div>
<div class="col-6">
    <div> Easypaisa Account Name </div>

</div>
                       <div class="col-6">
                        <b class="ml-5"> {{$of_p_methods->e_account_name}} </b>
                       </div>

                        @php $note = $of_p_methods->e_note @endphp
                        @if($note)
                            <div class="col-6">
                                <div> Note </div>
                            </div>
                            <div class="col-6">
                                <b class="text-danger ml-5"> {{$note}} </b>
                            </div>
                         @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($of_p_methods->o_is_enable)

        <div class="card">
            <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" aria-controls="collapseFour" type="button" data-toggle="collapse"
                        data-target="#collapseFour" aria-expanded="false" >
                        Other
                    </button>
                </h2>
            </div>
            <div id="collapseFour" class="collapse"  data-parent="#accordionExample" aria-labelledby="headingFour">
                <div class="card-body">
                    <div class="border p-4">
                        <div class=" mb-3 bg-website text-white w-100 text-center p-3" style="font-size: 1.2rem">other
                        </div>
                        <div>
                            <div> Mobile Number <b> {{$of_p_methods->o_mobile_number}} </b> </div>
                            @php $note = $of_p_methods->o_note @endphp
                            @if($note) <div> Note <b class="text-danger"> {{$note}} </b> </div>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
</div>


</div>
@if(isset($of_p_methods) && $of_p_methods && $of_p_methods->count())
<div class="d-flex justify-content-between my-3">
    <form action="{{route('offline-payment')}}" method="POST">
        @csrf
        <input type="hidden" name="slug" value="{{$slug}}">
        <button type="submit" class="btn btn-website"> Offline Payment </button>
    </form>
    <a href="{{route('contact-us')}}" class="btn btn-website">Contact Us</a>
</div>
@endif
</div>



@endsection

@section('script')
<script>
    $(function({
            $('#payment-options a').on('click', function (e) {
            e.preventDefault()
            $(this).tab('show')
            });
        }));
</script>
@endsection