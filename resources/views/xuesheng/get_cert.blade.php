@php 
use Carbon\Carbon;

@endphp
<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }
    </style>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Norican&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Norican&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
    
    <section class="col-md-8 offset-md-2"  style="display: flex;justify-content: center;align-items: center;margin-top: 1rem; margin-bottom: 1rem; ">
   
        <div style="padding:2px; text-align:center; background-color: #FFFFFF;border: 0.2rem solid #000066;background-image: url('{{asset("img/bg-cert.jpg")}}')">
            
            <div style="width:750px; padding:20px; >
                <div class="float-right">    </div>
                    <br/>
                <div style="font-size:50px; font-weight:bold;font-family: 'Norican', cursive; color: #000">Certificate of Completion</div>
                
                
                <div style="font-size:25px;"><i>This is to certify that</i></div>
                
                <div style="font-size:30px;font-family: 'Anton', sans-serif;color: #fff"><b>  {{$name ?? ""}} </b></div>
                <span style="font-size:25px;"><i>has completed the course</i></span> <br/><br/>
                <div style="font-size:30px;color: #000;">  {{$title }} </div> 
                <!--<div style="font-size:25px">on  </div> <br/><br/>-->
                <!--<div style="font-size:30px"> Lyskills.com </div><br>-->
                <div style="display: flex;justify-content: center;">
                    <img src="{{asset('img/logo.jpg')}}" alt="company logo" style="width: 150px;"  />
                </div>
                <div style="font-size:25px;"><i>Dated</i></div>
                <div style="font-size:30px;color: #000">  @php echo Carbon::now()->toDateString(); @endphp </div>
                <div style="display: flex;justify-content: between !important; margin-left: 1rem">
                <div> Ref no @php echo rand();  @endphp  </div>
                    <img src="{{asset('img/sign.JPG')}}" alt="signature" style="width: 150px; margin-left: auto"  />
                </div>
                
            </div>
         </div>
</section>