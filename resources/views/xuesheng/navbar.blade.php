<div class="d-flex justify-content-between my-2">
    <h1 class="text-capitalize my-3"> {{ $course->course_title ?? '' }} </h1>
    <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
        <span class="fa fa-2x fa-star rating" no="1"></span>
        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="2"></span>
        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="3"></span>
        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="4"></span>
        <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="5"></span>
    </section>
</div>
