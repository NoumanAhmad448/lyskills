<style>
.main{
    height: 650px !important;
    width: 1050px !important;
    background-repeat: no-repeat;    
    position: relative;
    background-image: '12';
    /*width: 100% !important;*/
}


.name{
    position: absolute;
    top: 200;
    left: 420;
    font-size: 1.4rem;
    text-transform: uppercase;
    
}
.course_name{
    position: absolute;
    top: 270;
    left: 420;
    font-size: 1.4rem;
    text-transform: uppercase;
    
}
.cert_no{
    position: absolute;
    bottom: 80;
    left: 20;
    font-size: 1.3rem;
    text-transform: uppercase;
    text-align: center;
}
.date{
    position: absolute;
    bottom: 100;
    left: 370;
    font-size: 1.1rem;
    text-transform: uppercase;
    
}
.img{
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;

}

</style>


<div class="main">
    <img src="{{$img}}" alt="certificate"  class="img" style="width: 100% !important" />
    <div class="name">
        {{$name}} 
    </div>
    <div class="course_name">
        {{$course}} 
    </div>
    <div class="cert_no">
        Certificate  <br/> {{$cert_no}} 
    </div>
    <div class="date">
        {{$date}} 
    </div>
</div>