@extends('layouts.guest1')
@section('page-css')
   <link rel="stylesheet" href="{{asset('css/credit_card_form.css')}}"> 
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
    <div class="container my-5">
        <h1> Course Information</h1>
        <div class="text-center"> 
          <h3 class="text-capitalize"> {{$course->course_title}} <h3>
        </div>
        <div class="text-center text-danger font-bold">
           Course Price ${{ $price }}
        </div>
        <div class="d-flex justify-content-end">
          <a href="{{route('user-course', ['slug' => $course->slug])}}" class="btn btn-website"> Visit Course </a>
        </div>
        {{-- <h1> Credit Card </h1> --}}
        @include('session_msg')       

          <form action="{{ route('credit_card_pay_post', ['slug' => $slug ] )}}" method="POST" class="my-3" id="paymentForm">
            @csrf
            <input type="hidden" name="payment_method" id="payment_method" value="" />
            {{-- <input type="submit" value="submit"> --}}
          </form>

          
            <div class="form-group">
                <label for="card_holder_name"> Card Holder Name</label>
                <input id="card-holder-name" type="text" name="card_holder_name" placeholder="Name On Your Card" class="form-control">
            </div>

            <!-- Stripe Elements Placeholder -->
            <div class="form-group">
              <div id="card-element" class="form-control"></div>
            </div>

            <button id="card-button" class="btn btn-website" >
                Pay Now
            </button>

    </div>
@endsection

@section('script')
  {{-- <script src="https://js.stripe.com/v3/"></script> --}}
  {{-- <script src="{{asset('js/credit_card_form.js')}}"></script> --}}
  <script src="https://js.stripe.com/v3/"></script>

  <script>
      const stripe = Stripe('pk_live_51HgB5sKqvwo7IBqOHR7UDYA4BTeqzl8rW7jNrTviy8ZQBQomKMmscf0AmAjcOzLQoAkrJebIuoAPl7qHQO2twwGH00TGvUjKte');

      const elements = stripe.elements();
      const cardElement = elements.create('card');

      cardElement.mount('#card-element');

      const cardHolderName = document.getElementById('card-holder-name');
      const cardButton = document.getElementById('card-button');
      // const clientSecret = cardButton.dataset.secret;

      cardButton.addEventListener('click', async (e) => {
          const { paymentMethod, error } = await stripe.createPaymentMethod(
              'card', cardElement,{                            
                      billing_details: { name: cardHolderName.value }
                  }              
          );

          if (error) {
              alert(error.message);
          } else if(paymentMethod){
              $('#payment_method').val(paymentMethod.id);
              // console.log(paymentMethod.id);
              $('#paymentForm').submit();
          }else{
            alert('Something is going wrong. please try again');
          }
      });
  </script>
@endsection