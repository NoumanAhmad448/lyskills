@extends('courses.dashboard_main')
@section('page-css')
    {{-- <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@php
$course_id  = $course->id;    
use App\Models\Lecture;
use App\Models\Description;
use App\Models\ResVideo;


@endphp
@section('content')
    <div class="bg-white col-md-9 mt-3">
        <div class="row border-bottom">
            <div class="col-md-6 p-2 p-md-4">
                <h1> 
                    Course Curriculum
                </h1>
            </div>
            <div class="col-md-6 p-0 pr-1 p-md-4">                
                {{-- <button type="button" class="btn website-outline float-right" data-toggle="modal" data-target="#bulk" >
                        Bulk Uploader
                </button> --}}
            </div>
        </div>
        <div class="p-3">
            {{-- If you’re intending to offer your course for free, the total length of video content must be less than 2 hours. --}}
        </div>
        <div class="alert alert-success success font-weight-bold d-none text-center"></div>
        <div class="text-center">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <section class="container p-2 sec-container">
            @if ($section->count())
                @foreach ($section as $sec)
                    <div class="bg-light font-weight-bold p-3 mt-3 mt-md-5 section border">
                        <section>
                            <div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="sec1">
                                            @php $sec_no = $sec->section_no @endphp
                                            Section <span class="sec_no d-none"> {{ $sec_no ?? ''}} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="sec_title ml-md-2">
                                            {{$sec->section_title ?? ''}}
                                             <span class="sec_title_edit ml-2">
                                                 <i class="las la-pen"></i>
                                             </span>
                                        </div>
                                    </div>
                                    @if($sec_no != "1")
                                     <section class="del_sec_container col-md-2 ">
                                        <div del_sec_url="{{route('section_delete',['course_id' => $course_id, 'section_id' => $sec_no ])}}"> </div>
                                        <div class="del_sec btn text-danger d-flex align-items-center float-right icon-sm p-0">
                                            <i class="las la-trash-alt"></i>
                                        </div>
                                    </section>
                                    @endif
                                </div>    
                            </div> 

                            @php 

                            $lecs = Lecture::where('course_id', $course_id)->where('sec_no', $sec->section_no)->get();                             
                             

                            @endphp                            
                            @if($lecs->count())
                                @foreach ($lecs as $lec) 
                                    @php $lec_id = $lec->id; 
                                        $media = $lec->media;   
                                        $desc = Description::where('lecture_id', $lec_id)->first();  
                                        $res = $lec->res_vid;
                                        $article = $lec->article;
                                        $ex_res = $lec->ex_res;
                                        $other_file = $lec->other_file;
                                        $should_show_res = $res || $article || $ex_res || $other_file;
                                        
                                        $assigns = $lec->assign;
                                        $quizzs = $lec->quizzs;
                                        
                                       
                                    @endphp  
                                    <div class="mt-3 container lecture_container bg-white p-3 border">  
                                        
                                        <div class="row">
                                            <div class="col-md-6 d-md-flex align-items-md-center">
                                                <div class="d-none"> Lecture <span class="lec_no"> {{$lec->lec_no ?? ''}} </span> </div>
                                                <section class="lec_small_container d-md-flex align-items-md-center">
                                                    <div class="ml-md-3 font-weight-normal"> {{$lec->lec_name}} </div>
                                                    <div class="lec_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                                                    <form action="{{route('lecture_delete',['course_id' => $course_id, 'lecture_id' => $lec_id])}}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <div class="lec_delete ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                                                    </form>
                                                </section>
                                            </div>
                                            <div class="col-md-6 d-md-flex align-items-md-center mt-3 mt-md-0">                                                
                                                @if($media)
                                                    <div class="v_c_vid  btn website-outline" >
                                                        <i class="las la-caret-down"></i> Video    
                                                     </div>
                                                @else
                                                <div class="lec_content btn website-outline" video_url="{{route('upload_video',['course_id' => $course_id, 'lecture_id' => $lec_id])}}">
                                                    <i class="las la-plus"></i>  Video  
                                                </div>
                                                @endif
                                                @if($desc)
                                                <div class="lec_desc_update_php btn website-outline ml-2" >
                                                    <i class="las la-caret-down"></i>  Description
                                                </div>
                                                @else
                                                <div class="lec_desc btn website-outline ml-2" desc_url="{{route('add_desc',['course_id' => $course_id, 'lec_id' => $lec_id ])}}">
                                                    <i class="las la-plus"></i>  Description
                                                </div>
                                                @endif
                                                @if($should_show_res)
                                                    <div class="added_res btn website-outline ml-md-2 mt-2 mt-md-0 " 
                                                    ex_res_url="{{route('ex_res',['lec_id' => $lec_id])}}"
                                                    article_url="{{route('article',['lec_id' => $lec_id])}}"
                                                    other_files_url="{{route('other_files',['lec_id' => $lec_id])}}"
                                                    >
                                                        
                                                        <i class="las la-caret-down"></i>  Resource
                                                    </div>
                                                @else
                                                    <div class="lec_more btn website-outline ml-md-2 mt-2 mt-md-0 " res_vid="{{route('upload_vid_res',['lec_id' => $lec_id])}}"
                                                        article_url="{{route('article',['lec_id' => $lec_id])}}"
                                                         ex_res_url="{{route('ex_res',['lec_id' => $lec_id])}}"
                                                         other_files_url="{{route('other_files',['lec_id' => $lec_id])}}"
                                                        
                                                        >
                                                        <i class="las la-plus"></i>  Resource
                                                    </div>
                                                @endif
                                            </div>                                   
                                        </div>
                                    </div> 
                                    @if($media)
                                        <section class="lecture_vid row p-3 d-none">
                                            <div class="col-md-12">
                                                <div class="d-flex">
                                                    <video width="500" height="240" controls preload="auto" oncontextmenu="return false;">
                                                        <source src="{{'https://lyskills-by-nouman.s3.ap-southeast-1.amazonaws.com/'}}{{$media->lec_name}} " type="{{$media->f_mimetype ?? ''}}">
                                                    </video>
                                                    
                                                </div>   
                                                <section class="mt-2">
                                                    <h3 class="d-none d-md-block ml-3"> {{$media->f_name ?? ''}} </h3>  
                                                    <section class="d-flex upload_video_con">
                                                        <form url="{{route('delete_video',['course_id' => $course_id, 'media_id' => $media->id])}}" >                                                          
                                                            <button type="button" class="btn btn-danger del_media"> Delete lecture </button>
                                                        </form>
                                                        <form url="{{route('e_video',['course_id' => $course_id, 'media_id' => $media->id])}}" class="ml-2 edit_form" >                                                          
                                                            <input type="file" name="edit_video" class="custom-file-input edit_video d-none" id="edit_video" >
                                                            <label for="edit_video"  class="btn btn-website"> Edit lecture </label>
                                                        </form>
                                                    </section>
                                                </section>                                      
                                            </div>
                                           
                                        </section>
                                    @endif
                                    @if($desc)
                                        <div class="lec_desc_con bg-white border p-2 p-md-5 d-none">
                                            <form desc_form_url="{{route('add_desc',['course_id' => $course_id, 'lec_id' => $lec_id])}}">
                                                <h3 class="text-center"> Description of Lecture </h3>
                                                <p class="font-weight-normal text-center"> This description will be shown in the end of provided video. From this, students
                                                    will be able to get an idea about the lecture </p>
                                                <div class="form-group">
                                                    <textarea class="form-control desc_detail" name="lec_desc" id="lec_desc" rows="5" cols="50" placeholder="Put all possible detail of related video">{{$desc->description}}</textarea>
            
                                                </div>
                                                <div class="alert alert-danger d-none text-center desc_err_msg"></div>
                                                
                                                <button type="button" class="btn bg-static-website add_desc_btn">Save Description</button>
                                                
                                            </form>
                                        </div>
                                    @endif
                                    @if($should_show_res)
                                        <div class="container resources bg-white  justify-content-md-between py-2 p-md-4 border d-none">    
                                            @if($res)
                                                <div class="pt-3 text-center res_hover_view py-md-2 font-weight-normal btn show_uploaded_vid website-outline" > <i class="las la-caret-down"></i> Uploaded Video </div>
                                            @else
                                                <div class="video_res pt-3 text-center res_hover_view py-md-2 font-weight-normal" upload_video_url="{{route('upload_vid_res',['lec_id' => $lec_id])}}"> Upload Video </div>
                                            @endif
                                            @if($article)
                                                 <div class="btn article_res_show pt-3 text-center res_hover_view py-md-2 font-weight-normal website-outline"> <i class="las la-caret-down"></i> Article </div>
                                            @else
                                                 <div class="article_res pt-3 text-center res_hover_view py-md-2 font-weight-normal"> Article </div>
                                            @endif

                                            @if($ex_res)
                                                <div class="external_res_show website-outline pt-3 text-center py-md-2 btn font-weight-normal">  <i class="las la-caret-down"></i> External Resource </div>
                                            @else
                                                <div class="external_res pt-3 text-center res_hover_view py-md-2 font-weight-normal"> External Resource </div>
                                            @endif
                                            @if($other_file)
                                            <div class="other_res_show website-outline btn pt-3 text-center res_hover_view py-md-2 font-weight-normal"><i class="las la-caret-down"></i>  Other Files </div>   
                                            @else
                                            <div class="other_res pt-3 text-center res_hover_view py-md-2 font-weight-normal"> Other Files </div>   
                                            @endif
                                        </div>
                                    @endif

                                    @if($res)
                                        <section class="uploaded_video row p-3 d-none">
                                            <div class="col-md-9">
                                                <div class="d-flex">
                                                    <video width="500" height="240" controls oncontextmenu="return false;">                                                        
                                                        @php $vid_path= $res->lec_path; @endphp
                                                        <source src="{{'https://lyskills-by-nouman.s3.ap-southeast-1.amazonaws.com/'}}{{$vid_path}}" type="{{$res->f_mimetype}}">
                                                    </video>                                                    
                                                </div>
                                                <section class="mt-2">
                                                    <h3 class="d-none d-md-block ml-3"> {{$res->f_name}} </h3>  
                                                    <form url="{{route('delete_uploaded_video',$res->id)}}">                                                          
                                                        <button type="button" class="btn btn-danger del_uploaded_vid"> Delete lecture </button>
                                                    </form>
                                                </section>                                         
                                            </div>
                                          
                                        </section>
                                    @endif
                                    @if($article )
                                        <section class="up_article_res bg-white p-2 p-md-4 border d-none">
                                            <h3 class="text-center"> Add Extra Article </h3>
                                            <p class="text-white bg-info px-2 py-1"> This provided article may help your students to enhance their capibilities and might help to understand your lecture in a better and organized way </p>
                                            <form article_url="{{route('article',['lec_id' => $lec_id])}}" class="article_form">
                                                
                                                <div class="form-group">
                                                    <textarea class="form-control article_text" name="article_text" id="article_text" rows="10" placeholder="Please type the article that might help students to learn more">{{$article->article_txt }}</textarea>
                                                </div>
                                                <span class="float-right font-weight-normal"> upto 1500 words</span>
                                                <button type="submit" class="btn btn-info"> <i class="las la-save"></i> Save Article </button>                            
                                            </form>
                                        </section>
                                    @endif

                                    @if($ex_res)
                                    <section class="ex_res_con bg-white p-2 p-md-4 border d-none">
                                        <h3 class="text-center"> Add YouTube Link </h3>
                                        <p class="text-white bg-info px-2 py-1"> Provide the link that you think might help your students to understand the lecture more clearly </p>
                                        <form ex_res_url="{{route('ex_res',['lec_id' => $lec_id])}}" class="ex_url_form">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="ex_res_title" name="ex_res_title" placeholder="Title" value="{{$ex_res->title ?? ''}}">                                
                                                <span class="font-weight-normal"> Title must have max 60 words</span>
                                            </div>
                                            <div class="form-group">
                                                <input type="url" class="form-control" id="ex_res_link" name="ex_res_link" placeholder="YouTube link" value="{{$ex_res->link??''}}">                                
                                                <span class="font-weight-normal"> The above provided link must be youtube link otherwise your video will not be shown to others</span>

                                            </div>
                                            <button type="submit" class="btn btn-info"> <i class="las la-save"></i> Save Link </button>                            
                                        </form>
                                    </section>
                                    @endif 

                                    @if($other_file)
                                        <section class="other_files_con bg-white p-2 p-md-4 border d-none">
                                            <h3 class="text-center"> Upload Extra Documents </h3>
                                            <p class="text-info px-2 py-1"> Upload any pdf file that you might think help your students to understand your lecture more clearly.
                                            Please note that you can only upload one document. </p>
                                            <form class="delete_other_file d-flex align-items-center" delete_o_f_url ="{{route('delete_file',['lec_id' => $lec_id])}}">
                                                <div prev_url="{{route('prev_file',['file_id' => $other_file->id])}}" class="cursor_pointer file_preview"> {{$other_file->f_name??''}}</div>
                                                <button type="submit" class="btn btn-danger ml-3"> <i class="las la-trash-alt"></i> </button>
                                            </form>
                                        </section>
                                    @endif

                                    @if($assigns->count())
                                       @foreach($assigns as $assign )
                                            @php  $ass_desc = $assign->ass_desc; @endphp
                                            <div class="my-3 container assign_con bg-white p-3 border">  
                                                <div class="row">
                                                    <div class="col-md-6 d-md-flex align-items-md-center">
                                                        <div> Assignment <span class="ass_no"> {{ $assign->ass_no ?? '' }} </span> </div>
                                                        <section class="lec_small_container d-md-flex align-items-md-center">
                                                            @php $ass_title = $assign->title ?? '';
                                                                if(!$ass_title){
                                                                    $ass_title = reduceCharIfAv($ass_title,30);
                                                                }
                                                                
                                                            @endphp
                                                            <div class="ass_title ml-md-3 font-weight-normal"> {{ $ass_title }}</div>
                                                            <div title_edit="{{route('update_assign',['assign' => $assign ])}}" class=" assign_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                                                            <form action="{{route('delete_assign',['assign' => $assign ])}}" method="post" >                                                                
                                                            @csrf
                                                            @method('delete')
                                                            <div class="assign_del ml-md-3 text-danger d-inline d-md-block cursor_pointer" > <i class="las la-trash-alt"></i> </div>
                                                            </form>
                                                        </section>
                                                    </div>
                                                    <div class="col-md-6 d-md-flex align-items-md-center mt-3 mt-md-0">
                                                        <div class="@if($ass_desc) show_desc_update @else add_desc @endif btn website-outline " desc_url="{{route('add_assign_desc',['assign' => $assign ])}}">
                                                            @if($ass_desc) <i class="las la-caret-down"></i> @else <i class="las la-plus"></i> @endif   Description  
                                                        </div>
                                                        <div class="btn website-outline @if($assign->ass_f_name) add_assign_show @else add_assign @endif  ml-2" assign_url="{{route('add_ass',['assign' => $assign ])}}">
                                                            @if($assign->ass_f_name)  {!! __('<i class="las la-caret-down"></i>') !!} @else {!! __('<i class="las la-plus"></i>') !!}  @endif   Assignment
                                                        </div>
                                                        <div class=" @if($assign->ass_ans_f_name) add_sol_show @else add_sol @endif btn website-outline ml-md-2 mt-2 mt-md-0 " sol_url="{{route('add_sol',['assign' => $assign ])}}">
                                                            @if($assign->ass_ans_f_name)  {!! __('<i class="las la-caret-down"></i>') !!} @else {!! __('<i class="las la-plus"></i>') !!}  @endif   Solution
                                                        </div>
                                                    </div>                                   
                                                </div>
                                            </div>
                                            @if($ass_desc)
                                        <div class="ass_desc_con bg-white border p-2 p-md-5 d-none">
                                            <form desc_form_url="{{route('add_assign_desc',compact('assign'))}}">
                                                <h3> Description of Assignment </h3>
                                                <p class="font-weight-normal"> The provided description will help your students 
                                                to understand the assignment more clearly. please try your best to convince your students by providing them
                                                more details about the assignment to better understand it </p>
                                                <div class="form-group">
                                                    <textarea class="form-control ass_desc_detail" name="ass_desc_detail" id="ass_desc_detail" rows="10" cols="50" placeholder="Description of Assignment">{{$ass_desc->description??''}}</textarea>
            
                                                </div>
                                                <div class="alert alert-danger d-none text-center ass_err_msg"></div>
                                                
                                                <button type="button" class="btn bg-static-website add_ass_desc">Save Description</button>
                                                
                                            </form>
                                        </div>
                                        @endif

                                        @if($assign->ass_f_name)
                                        <section class="ass_container bg-white p-2 p-md-4 border d-none">
                                            <h3 class="text-center"> Upload Assignment Document </h3>
                                            <p class="text-info font-weight-normal px-2 py-1"> Please make a comprehensive PDF file that contains all possible guide for the student to solve your assignment. Please refer to the 
                                                        lecture if you feel so. 
                                            
                                             </p>
                                            <form class="delete_ass_file d-flex align-items-center" del_ass_url="{{route('delete_ass_file',compact('assign'))}}">
                                                <div prev_url="{{route('prev_ass_file',['file_id' => $assign])}}" class="cursor_pointer as_f_pre"> {{reduceCharIfAv($assign->ass_f_name,30)}} </div>
                                                <button type="submit" class="btn btn-danger ml-3"> <i class="las la-trash-alt"></i> </button>
                                            </form>
                                            </section>
                                        @endif
                                        @if($assign->ass_ans_f_name)
                                        <section class="sol_container bg-white p-2 p-md-4 border d-none">
                                            <h3 class="text-center"> Upload Assignment Document </h3>
                                            <p class="text-info font-weight-normal px-2 py-1"> Please make a comprehensive PDF file that contains all possible guide for the student to solve your assignment. Please refer to the 
                                                        lecture if you feel so. 
                                            
                                             </p>
                                            <form class="delete_ass_file d-flex align-items-center" del_ass_url="{{route('delete_sol_file',compact('assign'))}}">
                                                <div prev_url="{{route('prev_sola_file',['file_id' => $assign])}}" class="cursor_pointer as_f_pre"> {{reduceCharIfAv($assign->ass_ans_f_name,30)}} </div>
                                                <button type="submit" class="btn btn-danger ml-3"> <i class="las la-trash-alt"></i> </button>
                                            </form>
                                            </section>
                                        @endif
                                        @endforeach

                                    @endif
                                   


                                    @if($quizzs->count())
                                        @foreach ($quizzs as $quiz) 
                                            <div class="my-3 container quiz_con bg-white p-3 border">  
                                                <div class="row">
                                                    <div class="col-md-6 d-md-flex align-items-md-center">
                                                        <div> Quiz <span class="quiz_no"> {{$quiz->quiz_no}} </span> </div>
                                                        <section class="lec_small_container d-md-flex align-items-md-center">
                                                            <div class="quiz_title ml-md-3 font-weight-normal"> {{ reduceCharIfAv($quiz->title,30) }} </div>
                                                            <div title_edit="{{route('update_quiz',compact('quiz'))}}" class="quiz_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                                                            <form action="{{route('delete_quiz', compact('quiz'))}}" method="post">
                                                                @method('delete')
                                                                @csrf
                                                            <div class="quiz_del ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                                                            </form>
                                                        </section>
                                                    </div>
                                                    <div class="col-md-6 d-md-flex align-items-md-center mt-3 mt-md-0">
                                                        @php $quiz_desc = $quiz->quiz_desc; 
                                                            $quizzes = $quiz->quizzes @endphp
                                                        <div class="@if($quiz_desc) quiz_s_op  @else quiz_desc @endif btn website-outline " desc_url="{{route('add_quiz_desc',compact('quiz'))}}">
                                                            @if($quiz_desc) <i class="las la-caret-down"></i> @else <i class="las la-plus"></i> @endif  Description  
                                                        </div>
                                                        <div class="btn website-outline @if($quizzes) quiz_q_show  @else quiz_q @endif   ml-2" quiz_url="{{route('add_quizzs', compact('quiz'))}}">
                                                            @if($quizzes) <i class="las la-caret-down"></i>  @else <i class="las la-plus"></i>  @endif Quiz
                                                        </div>
                                                    </div>                                   
                                                </div>
                                            </div>
                                            
                                            @if($quiz_desc)
                                                <div class="quiz_desc_con bg-white border p-2 p-md-5 d-none">
                                                    <form desc_form_url="{{route('add_quiz_desc',compact('quiz'))}}">
                                                        <h3 class="text-center"> Description of Quiz </h3>
                                                        <p class="text-center font-weight-normal"> The provided description will help your students 
                                                        to understand the quiz more clearly. please try your best to convince your students by providing them
                                                        more details about the quiz to better understand it </p>
                                                        <div class="form-group">
                                                            <textarea class="form-control quiz_desc_detail" name="quiz_desc_detail" id="quiz_desc_detail" rows="10" cols="50" placeholder="Description of Quiz">{{$quiz_desc}}</textarea>
                    
                                                        </div>                                                        
                                                        <button type="button" class="btn bg-static-website add_quiz_desc">Save Description</button>
                                                        
                                                    </form>
                                                </div>
                                            @endif
                                            
                                            @if($quizzes->count())
                                               
                                                    <div class="quiz_q_con border bg-white container p-3 d-none">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h3 class="text-center"> Multiple choice Quiz </h3> 
                                                                <p class="text-center font-weight-normal text-info"> Create a multiple choice quiz by adding question and choosing it's answer. More, you can also provide the reason of your selected answer for students to
                                                                    understand the question. 
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row q_b_con">
                                                            <div class="col-12">
                                                                <div class="alert alert-danger d-none err_msg text-center"> </div>
                                                                <div class="btn btn-lg btn-info float-right create_quiz" 
                                                                quiz_url="{{route('add_quizzs', compact('quiz'))}}"> <i class="las la-pencil-alt"></i> Create Quiz </div>                            
                                                            </div>
                                                        </div>
                                                        @foreach($quizzes as $q)
                                                            <div class="border bg-white container p-3 quiz-q-list mt-3">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-2">
                                                                                <div class="q-no">  {{$q->count_quizzes}}  </div>
                                                                            </div>
                                                                            <div class="col-10">
                                                                                <div class="q-name"> {{  reduceCharIfAv($q->question,30) }} </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                        
                                                                    
                                                                    <div class="col-md-6 d-flex">
                                                                        <div class="cursor_pointer edit_quiz text-info" quiz_edit_url="{{route('edit_quizzes',['quizzes' => $q])}}" > <i class="las la-pencil-alt"></i> </div>
                                                                        <div class="cursor_pointer del_quiz ml-3 text-danger" quiz_del_url="{{route('del_quizzes',['quizzes' => $q])}}" > <i class="las la-trash-alt"></i> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                            @endif

                                        @endforeach        
                                    @endif

                                @endforeach
                            @endif
                            <span class="mt-3 ml-2 website-color add_material" >
                                <i class="las la-plus-circle icon-sm"></i>
                            </span>          
                                    
                        </section>
                    
                    </div>
                @endforeach
            @else
            <div class="bg-light font-weight-bold p-3 section">
                <section>
                    <div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="sec1">
                                    section <span class="sec_no"> 1 </span>:
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="btn website add_title">
                                    <i class="las la-plus"></i>
                                    Add Title
                                </div>
                                
                            </div>
                        </div>    
                    </div>  
                    <span class="mt-3 ml-2 website-color add_material"
                        data-toggle="tooltip" data-placement="right" title="Add Lecture,Assignment,Quiz"
                    >
                        <i class="las la-plus-circle icon-sm"></i>
                    </span>          
                              
                </section>
               
            </div>
            
            @endif

            <span class="mt-2 ml-2 website-color" id="add_sec"
            data-toggle="tooltip" data-placement="right" title="Add Section"
            >
                <i class="las la-plus-circle icon-sm"></i>
            </span>

        </section>

    </div>
    
    <div class="modal fade" id="bulk" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" 
            aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header  bg-static-website">
              <h5 class="modal-title" id="staticBackdropLabel">Upload Multiple Files</h5>
              {{-- data-dismiss="modal" aria-label="Close" --}}
              <button type="button" class="close text-white" id="close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body p-3">
                <h3 class="text-center"> Upload Multiple Files </h3>
              <p> You can upload multiple video files at the same time but the total size of all videos must be less than 
                  4GB. After uploading, you may choose your video from the video uploading section of your lecture.
              </p>
              <hr/>
              <form url="{{route('bulk_loader',['course' => $course_id])}}" enctype="multipart/form-data" id="bulk-form">
                <div class="d-flex justify-content-center mt-5">
                    <input type="file" class="d-none" id="upload_bulk_videos" multiple name="upload_b_vid[]">
                    <label class="btn btn-lg btn-info" for="upload_bulk_videos">Upload Videos</label>
                </div>
                <div class="progress d-none my-3">
                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 25%;" id="show_progress"
                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%
                    </div>
                </div>
                <p class="text-danger p-1"> Max all videos size 4GB </p>
              </form>
            </div>
            
          </div>
        </div>
      </div>


@endsection 


@section('page-js')
    <script>
        $(function() {
            $('#courses_curriculum').removeClass('text-info').addClass('bg-website text-white');

            $( "#add_sec" ).click(function() {
                let sec = $( "#add_sec" );

                if (typeof sec !== 'undefined') {
                    let sec_title_next_val = parseInt($( ".sec1 span" ).last().text()) + 1;                   

                    sec.before(`<div class="bg-light font-weight-bold p-3 section mt-3 mt-md-5 border">
                        <section>
                            <div>
                                <div class="row">
                                    <div class="col-md-2 lecture_name">
                                        <div class="sec1">
                                            section <span class="sec_no d-none"> ${sec_title_next_val} </span>:
                                        </div>
                                    </div>
                                    <div class="col-md-9 title_sec_container">
                                        <div class="btn website add_title">
                                            <i class="las la-plus"></i>
                                            Add Title
                                        </div>
                                    </div>    
                                    <div class="col-md-1">
                                        <div class="text-danger cursor_pointer close_sec icon-sm float-right">
                                            <i class="las la-trash-alt"></i>                                           
                                        </div>
                                    </div>                                  
                                </div>    
                            </div>  
                            <span class="mt-2 ml-2 website-color add_material" >
                                <i class="las la-plus-circle icon-sm"></i>
                            </span>          
                                    
                        </section>
               
                         </div>`
                    );
                }else{
                    console.error('Element with class name section does not exist');
                }
                
            });

            
            $(".sec-container").on("click", '.close_sec',function(){
                if(confirm('Do you want to close this section?')){
                    $(this).parents('.section').first().remove();
                }
            });


            $(".sec-container").on("click", '.sec_title_edit',function(){
                let current_elem = $( this );
                let parent = current_elem.parent();
                let parent_text = parent.text().trim();
                parent.replaceWith( `<form class="section_title_form">
                     <input type="text" class="form-control d-inline-block"
                     maxlength="70"
                     required placeholder="Section Title" value="${parent_text}" >
                     <div class="alert alert-danger d-none mt-1 err_msg">  </div>
                     <div class="d-flex justify-content-end mt-1">
                        <div class="btn website-outline mr-2 cancel"  onclick="cancel(event)" prev_val="${parent_text}" > cancel </div>
                        <button type="submit" class="btn website add_sec_title" > {{ __('Save') }} </button>
                    <div>
                     </form>` );
            });

             
            $('.sec-container').on('click', '.lec_edit', function() {
                let c_elem = $(this);
                let c_parent = c_elem.parents('.col-md-7');
                c_parent.removeClass('col-md-7').addClass('col-md-12');
                let c_lec_small_container = c_elem.parents('.lec_small_container');
                let lec_name = c_elem.prev();

                if(lec_name.length){  
                    let get_title_val = lec_name.text().trim();
                    c_lec_small_container.replaceWith( `<form class="c_lec_small_form w-100 mt-md-5">
                        <input type="text" class="form-control"  placeholder="Section Title" value="${get_title_val}" >
                        <div class="alert alert-danger d-none mt-1 err_msg">  </div>
                        <div class="d-flex justify-content-end mt-1">
                            <div class="btn website-outline mr-2 cancel" get_input_val="${get_title_val}" > cancel </div>
                            <button type="submit" class="btn website add_sec_title" > Save </button>
                        <div>
                        </form>` );                   
                }
            });
            $('.sec-container').on('click', '.assign_edit', function() {
                let c_elem = $(this);
                let assign_title = c_elem.prevAll('.ass_title').first();                
                let assign_con = c_elem.parents('.lec_small_container').first();
                let del_url = c_elem.next().attr('action');

                if(assign_title){  
                    let get_title_val = assign_title.text().trim();
                    assign_con.replaceWith( `<form class="ass_update_form w-100 mt-md-5" url="${c_elem.attr('title_edit')}" del_url="${del_url}">
                        <input type="text" class="form-control ass_title" placeholder="Assignment title" name="ass_title" value="${get_title_val}" value="${assign_title}">
                        <div class="d-flex justify-content-end mt-1">
                            <div class="btn website-outline mr-2 can_ass"  ><i class="las la-times"></i> cancel </div>
                            <button type="submit" class="btn website" > <i class="las la-save"></i> Save </button>
                        <div>
                        </form>` );                   
                }
            });

            $('.sec-container').on('click', '.can_ass', function() {
                
                let pa = $(this).parents('form').first();
                let url = pa.attr('url');
                let del_url = pa.attr('del_url');
                let title = $(this).parent().prevAll('.ass_title').first().attr('value');
                

                $(this).parents('.ass_form').first().replaceWith(`
                <section class="lec_small_container d-md-flex align-items-md-center">
                    <div class="ass_title ml-md-3 font-weight-normal"> ${title}</div>
                    <div title_edit="${url}" class=" assign_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                    <form action="${del_url}" method="post">
                        @csrf
                        @method('delete')
                        <div class="assign_del ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                    </form>
                </section>
                `);

            });

            $('.sec-container').on('click', '.cancel', function() {
                let new_title = $(this).attr('get_input_val');
                let title_form = $(this).parents('.c_lec_small_form');
                let main_parent = $(this).parents('.col-md-12').removeClass('col-md-12').addClass('col-md-7');
                title_form.replaceWith(`
                <section class="lec_small_container d-md-flex align-items-md-center">
                    <div class="ml-md-3 font-weight-normal"> ${new_title} </div>
                    <div class="lec_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                </section>
                `);
                    // <div class="lec_delete ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>

            });

            $( ".sec-container" ).on( "submit",'.section_title_form' , function(e) {                
                e.preventDefault();
                let add_btn = $(this);
                let sec_title = add_btn.find('input').val();                
                let sec_no = parseInt(add_btn.parent().prev().children('.sec1').find('.sec_no').text().trim());
                
                $.ajax({
                    url: "{{route('courses_curriculum_post',compact('course_id'))}}",                  
                    type: "post",
                    data:  {'sec_title': sec_title, 'sec_no': sec_no},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json'
                })
                
                .done(function(d) {
                    // console.log(d);
                    if(d.hasOwnProperty('status')){
                        let response = d['status'];
                        $('.success').removeClass('d-none').addClass('d-block').text(response);                                              
                        if(d.hasOwnProperty('sec_title')){  
                            let returned_title = d['sec_title'];  
                            returned_title = returned_title;
                            let title_sec_container = add_btn.parents('.title_sec_container').first();
                            // title_sec_container.removeClass('col-md-10').addClass('col-md-8');
                            add_btn.replaceWith(`
                            <div class="sec_title ml-md-2">
                                    ${returned_title}  
                                        <span class="sec_title_edit ml-2">
                                            <i class="las la-pen"></i>
                                        </span>                                 
                            </div>                                                                                          
                                `);

                        //     if(d['del_sec_url']){
                        //     title_sec_container.after(`<section class="del_sec_container col-md-2 ">
                        //         <div del_sec_url="${d['del_sec_url']}"> </div>
                        //         <div class="del_sec btn text-danger d-flex align-items-center float-right icon-sm p-0">
                        //             <i class="las la-trash-alt"></i>
                        //         </div>
                        //     </section> `);       
                        //     }          
                        }else{
                            // console.log('not availble');
                        }
                        setTimeout(function(){
                            $('.success').removeClass('d-block').addClass('d-none');                        
                        }, 5000);
                    }
                })
                .fail(function(res) {
                    let response = JSON.parse(res.responseText);
                    let err_msg = add_btn.find('.err_msg');
                    let input_field = add_btn.find('input').first();
                    
                    if(response.hasOwnProperty('sec_title')){
                        input_field.addClass('is-invalid');
                        err_msg.removeClass('d-none').addClass('d-block');

                        let errs = response['sec_title'];
                        for (e of errs) {
                            err_msg.text(e);
                       }

                       setTimeout(function(){
                        err_msg.removeClass('d-block').addClass('d-none');
                        input_field.removeClass('is-invalid');
                    }, 5000);
                    }else{
                        input_field.addClass('is-invalid');
                        err_msg.removeClass('d-none').addClass('d-block');
                        let errs = response['error'];
                        
                        err_msg.text(errs);
                       setTimeout(function(){
                        err_msg.removeClass('d-block').addClass('d-none');
                        input_field.removeClass('is-invalid');
                    }, 5000);

                    }
 

                })

            });

            $('.sec-container').on('click', '.add_material', function() {                
                $(this).before(`<div class="lecture_layer mt-3"> 
                        <section class="row"> <div class="col-md-2 p-2">
                            <div class="close_icon text-center cursor_pointer red_cross"> <i class="las la-times-circle la-2x"></i> </div>
                                </div>
                            <div class="col-md-10 custom_border">
                                <div class="main_layer d-md-flex align-items-md-center mt-2">
                                    <div class="my-1 my-md-0 lec ml-3 ml-md-0 cursor_pointer change_color">
                                    <i class="las la-file-video"></i> lecture
                                    </div>
                                    <div class="my-1 my-md-0 assignment ml-3 cursor_pointer change_color">
                                        <i class="las la-graduation-cap"></i> Assignment 
                                    </div>
                                    <div class="my-1 my-md-0 quiz ml-3 cursor_pointer change_color" >
                                        <i class="las la-book-open"></i> Quiz
                                    </div>
                                    
                                </div>
                            
                            </div>
                            </div>
                 </div>`)
            });
            
            $('.sec-container').on('click', '.close_icon', function() {
                $(this).parents('.lecture_layer').first().remove();
            });


            $('.sec-container').on('click', '.lec', function() {
                $(this).parents('.main_layer').first().replaceWith(`
                    <div class="lecture_form p-1">
                        <form class="lec_form">
                            <div class="form-group">
                                <label for="lec_name">Enter Lecture Title</label>
                                <input type="text" class="form-control lec_name"  placeholder="Enter a title">
                                <div class="alert alert-danger d-none lec_err mt-2"></div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="cancel_lec cursor_pointer mr-2 btn btn-danger"> Cancel </button>
                                <button type="submit" class="btn bg-website lec_submit"> Add Lecture </button>
                            </div>
                        </form>
                    </div>
                `);
            });

            $('.sec-container').on('click', '.cancel_lec', function() {
                $(this).parents('.lec_form, .ass_form, .quiz_form').replaceWith(`
                    <div class="main_layer d-md-flex align-md-items-center">
                    <div class="my-1 my-md-0 lec ml-3 ml-md-0 cursor_pointer change_color">
                    <i class="las la-file-video"></i> lecture
                    </div>
                    <div class="my-1 my-md-0 assignment ml-3 cursor_pointer change_color">
                        <i class="las la-graduation-cap"></i> Assignment 
                    </div>
                    <div class="my-1 my-md-0 quiz ml-3 cursor_pointer change_color" >
                        <i class="las la-book-open"></i> Quiz
                    </div>
                    
                </div>
                `);
            });
            
            $('.sec-container').on('click', '.video_res_can', function() {
                let parent = $(this).parents('.resources').first();
                if(parent.length > 0){
                    parent.nextAll('.up_vid_res').first().remove();                    
                    $(this).removeClass('video_res_can btn-danger').addClass('video_res').text('Upload Video');

                   
                }
            });
            
            $('.sec-container').on('submit', '.lec_form', function(event) {
                event.preventDefault();
                let lec_name = $(this).find('.lec_name');
                let sec_no = $(this).parents('.section').find('.sec1').find('.sec_no').text().trim();
                
                if(lec_name.length > 0){
                    let lec_val = lec_name.val();

                    $.ajax({
                    url: "{{route('lec_name_post',compact('course_id'))}}",
                    type: "POST",
                    data: {"lec_name" : lec_val, "sec_no": sec_no},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json"
                    }).
                    done(function(msg) {
                        let show_msg = $('.success');
                        show_msg.removeClass('d-none').addClass('d-block').text(msg['status_code']);  
                        let parent_elem = lec_name.parents('.lecture_layer').first();
                        let current_lec_name = msg['lec_name'];
                        let current_lec_no = msg['lec_no'];

                        parent_elem.replaceWith(`
                            <div class="my-3 container lecture_container bg-white p-3 border">  
                                <div class="row">
                                    <div class="col-md-6 d-md-flex align-items-md-center">
                                        <div class='d-none'> Lecture <span class="lec_no"> ${current_lec_no} </span> </div>
                                        <section class="lec_small_container d-md-flex align-items-md-center">
                                            <div class="ml-md-3 font-weight-normal"> ${current_lec_name} </div>
                                            <div class="lec_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                                            
                                            <form action="${msg['url']}" method="post">
                                                        @method('delete')
                                                        @csrf
                                            <div class="lec_delete ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                                            </form>
                                        </section>
                                    </div>
                                    <div class="col-md-6 d-md-flex align-items-md-center mt-3 mt-md-0">
                                        <div class="lec_content btn website-outline " video_url="${msg['video_url']}">
                                            <i class="las la-plus"></i>  Video  
                                        </div>
                                        <div class="btn website-outline lec_desc  ml-2" desc_url="${msg['add_desc']}">
                                            <i class="las la-plus"></i>  Description
                                        </div>
                                        <div class="lec_more btn website-outline ml-md-2 mt-2 mt-md-0 " res_vid="${msg['res_video']}"
                                            article_url="${msg['article_url']}" ex_res_url ="${msg['ex_res_url']}"
                                            other_files_url ="${msg['other_files_url']}" >
                                            <i class="las la-plus"></i>  Resource
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                                        
                        `);
                       
                        
                        setTimeout(function() { 
                                show_msg.removeClass('d-block').addClass('d-none').text('');
                            }, 5000);
                        
                    }).
                    fail(function(err) {
                        let errs = JSON.parse(err.responseText).errors;
                        lec_name.addClass('is-invalid');
                        let lec_err_msg = lec_name.next('.lec_err');
                        lec_err_msg.removeClass('d-none d-block');

                        if (errs.hasOwnProperty('lec_name')){
                            let es = errs['lec_name'];
                            for(e of es){
                                lec_err_msg.text(e);
                            }                          
                            
                        }else{                            
                            lec_err_msg.text(errs);
                        }
                        setTimeout(function() { 
                        lec_name.removeClass('is-invalid');
                                lec_err_msg.removeClass('d-block').addClass('d-none');
                            }, 5000);
                    });

                }
            });

            
            $('.sec-container').on('click', '.add_title', function() {
                let current_elem = $( this );
                
                current_elem.replaceWith( `<form class="section_title_form">
                     <input type="text" class="form-control d-inline-block" required maxlength="70" placeholder="Section Title" value="" >
                     <div class="alert alert-danger d-none mt-1 err_msg">  </div>
                     <div class="d-flex justify-content-end mt-1">
                        <div class="btn website-outline mr-2 cancel_title"  onclick="cancel_title(event)" prev_val="Section Title" > cancel </div>
                        <button type="submit" class="btn website add_sec_title" > Add </button>
                    <div>
                     </form>` );
            });
            
            $('.sec-container').on('submit', '.c_lec_small_form', function(e) {
                e.preventDefault();
                let title_form = $(this);
                let select_new_title = $(this).children('input.form-control');
                let get_new_title = select_new_title.val().trim();
                let show_err = $(this).children('.err_msg');                
                let current_lecture_no = $(this).prev('div').children('.lec_no').text().trim();                
               
                $.ajax({
                
                    url: "{{route('lec_name_edit_post',compact('course_id'))}}",
                    type: 'POST',                
                    data: {updated_title: get_new_title, lecture_no: current_lecture_no},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',                
                    success: function (data) { 
                        $('.success').removeClass('d-none').addClass('d-block').text(data['status']);
                        let course_title = data['course_title'];
                        title_form.replaceWith(`
                        <section class="lec_small_container d-md-flex align-items-md-center">
                            <div class="ml-md-3 font-weight-normal"> ${data['course_title']} </div>
                            <div class="lec_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                        </section>
                        `);
                            // <div class="lec_delete ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                    
                        $('.lec_small_container').parents('.col-md-12').removeClass('col-md-12').addClass('col-md-7');
                        setInterval(function(){
                            $('.success').removeClass('d-block').addClass('d-none').text('');

                            },10000);

                    },
                    error: function(returned_data, upcomingStatus){
                        let errors = JSON.parse(returned_data.responseText)['errors'];
                        show_err.removeClass('d-none').addClass('d-block');
                        select_new_title.addClass('is-invalid');
                        if(typeof(errors) == 'string'){
                            show_err.text(errors);
                        }
                        else if('updated_title' in errors)
                        {
                            let erros = errors['updated_title']
                            for (const e of erros) {
                                show_err.text(e);
                            }
                        
                        }
                        setInterval(function(){
                                show_err.addClass('d-none').removeClass('d-block');
                                select_new_title.removeClass('is-invalid');
                                },10000);

                            
                    }

                }); 


            });

            
            $('.sec-container').on('click', '.lec_delete', function() {
                if(confirm('Are you sure to delete this lecture?')){
                    $(this).parents('form').first().submit();
                }
            });

            $('.sec-container').on( 'click', '.del_sec', function(){
                if(confirm('Do you really want to delete this section?')){
                    let lec_elem = $(this).parents('.section');
                    let del_url = $(this).prev().attr('del_sec_url');
                    $.ajax({                    
                        url: del_url,
                        type: 'POST',                                            
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'JSON',
                        success: function (data) { 
                            $('.success').removeClass('d-none').addClass('d-block').text(data['status']);
                            lec_elem.remove();
                            setInterval(function(){ 
                                $('.success').removeClass('d-block').addClass('d-none').text();
                            }, 5000);

                        }                        
                    }); 
                }
            } );
 
            $('.sec-container').on( 'click', '.lec_content', function(){
                let lecture_container = $(this).parents('.lecture_container').first();
                let video_section = lecture_container.nextAll('.upload_video_con').first();
                if(video_section.length < 1){
                    $(this).removeClass('website-outline lec_content').addClass('btn-danger v_c_p_can').
                        html('<i class="las la-times"></i>Video');
                                // <a class="nav-link vid_upload_op" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Add from Library</a>
                    lecture_container.after(`
                    <section class="upload_video_con bg-white p-2 p-md-4 border">                        
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active vid_upload" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Upload video</a>
                            </li>
                            <li class="nav-item" role="presentation">
                            </li>                           
                        </ul>
                            <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form class="upload_video_form">
                                    <div class="d-none alert alert-danger video_err text-center"> </div>
                                    <div class="custom-file mt-3">
                                        <input type="file" name="upload_video" class="custom-file-input upload_video" id="custom_file" video_url ="${$(this).attr('video_url')}">
                                        <label class="custom-file-label" for="custom_file"> Upload Video </label>
                                        <div class="d-none invalid-feedback file_err"></div>                            
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                
                            </div>                            
                            </div>
                    </section>
                    `);
                }


                let lec_desc_update_cancel   = lecture_container.find('.lec_desc_update_cancel ');
                if(lec_desc_update_cancel ){
                    lec_desc_update_cancel.click();
                }

                let lec_more_close = lecture_container.find('.lec_more_close');
                if(lec_more_close){
                    lec_more_close.click();
                }

                let added_res_cancel = lecture_container.find('.added_res_cancel');
                if(added_res_cancel){
                    added_res_cancel.click();
                }

                let lec_desc_cancel = lecture_container.find('.lec_desc_cancel');
                if(lec_desc_cancel){
                    lec_desc_cancel.click();
                }

                let lec_desc_p_cancel = lecture_container.find('.lec_desc_p_cancel');
                if(lec_desc_p_cancel){
                    lec_desc_p_cancel.click();
                }


            } );

            
            $('.sec-container').on( 'change', '.upload_video', function(){
                let current_file = $(this);
                let c_f_form  = current_file.parents('.upload_video_form');                
                var form_data = new FormData(c_f_form[0]);
                let file = this.files[0];
                if(file){                    
                    let file_err = current_file.parent().find('.file_err');                    
                    var f_type = file.type;
                    if( f_type !== "video/mp4" && f_type !== "video/ogg" && f_type !=="video/webm"){
                        file_err.addClass('d-block').text('Only MP4, OGG, WEBM formats are allowed');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.removeClass('d-block').addClass('d-none').text();
                            current_file.removeClass('is-invalid');
                        },10000);
                    }
                    else if(parseInt(file.size/1024/1024/1024) > 4.2){
                        file_err.addClass('d-block').text('File size cannot exceed from 4GB');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.removeClass('d-block').addClass('d-none').text();
                            current_file.removeClass('is-invalid');
                        },10000);

                    }
                    else{
                        current_file.attr('disabled',true);
                        let video_url = current_file.attr('video_url');
                        let main_parent = current_file.parents('.upload_video_con').first();
                        main_parent.append(`
                        <div class="progress mt-3">
                            <div class="p_bar progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 0%"
                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        `);
                        let progress_bar =  main_parent.find('.p_bar');                        
                        if(video_url){
                            $.ajax({                        
                                url: video_url,
                                type: 'POST', 
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },                       
                                data: form_data,                            
                                contentType: false,
                                processData: false,                       
                                dataType: 'JSON',

                                xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {                                    
                                        var percentComplete = evt.loaded / evt.total; 
                                        let c_progress = Math.round(percentComplete * 100); 
                                        progress_bar.attr('aria-valuenow',c_progress);
                                        progress_bar.css('width',c_progress+'%');

                                        progress_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                    }
                                }, false);
                                return xhr;
                                },
                                success: function(data){
                                    current_file.attr('disabled',false);  
                                    let path = data['path'];  
                                    let upload_vid = current_file.parents('.upload_video_con').first();
                                    let media = data['media']; 
                                    let video_btn = current_file.parents('.upload_video_con').prev('.lecture_container').find('.lec_content').first();                                    
                                    video_btn.removeClass('lec_content').addClass('v_c_vid');

                                    upload_vid.replaceWith(`<section class="lecture_vid row p-3">
                                            <div class="col-md-9">
                                                <div class="d-flex">
                                                    <video width="500" height="240" controls oncontextmenu="return false;">
                                                         <source src="${path}" type="${media['f_mimetype']}">
                                                    </video>                                                    
                                                </div>
                                                <section class="mt-2">
                                                    <h3 class="d-none d-md-block ml-3"> ${data['f_name']} </h3>  
                                                    <form url="${data['delete']}">                                                          
                                                        <button type="button" class="btn btn-danger del_media"> Delete lecture </button>
                                                    </form>
                                                </section>                                         
                                            </div>                                            
                                        </section>
                                    `);
                                   
                                },
                                error: function(data){
                                    progress_bar.parent().remove();
                                    current_file.attr('disabled',false);
                                    let show_err = c_f_form.children('.video_err');       
                                    data = JSON.parse(data['responseText'])['errors'];                
                                    show_err.removeClass('d-none').addClass('d-block').text(data['upload_video']);
                                    setTimeout(function() {
                                        show_err.addClass('d-none').removeClass('d-block');                                        
                                    }, 15000);
                                }
                        });
                    }
                    }    
                }              
            });

            $('.sec-container').on( 'change', '.edit_video', function(){
                let current_file = $(this);
                let c_f_form  = current_file.parents('.edit_form');   
                
                let form  = current_file.parents('form').first();                               
                var form_data = new FormData(c_f_form[0]);
                let file = this.files[0];
                if(file){      
                    var f_type = file.type;
                    if( f_type !== "video/mp4" && f_type !== "video/ogg" && f_type !=="video/webm"){
                        alert('Only MP4, OGG, WEBM formats are allowed');                        
                    }
                    else if(parseInt(file.size/1024/1024/1024) > 4){    
                        alert("File size cannot exceed from 4GB")  ;   
                    }
                    else{
                        current_file.attr('disabled',true);
                        let video_url = form.attr('url');
                        let main_parent = current_file.parents('.upload_video_con').first();
                        main_parent.append(`
                        <div class="progress mt-3 ml-2" style="width: 70%">
                            <div class="p_bar progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 0%"
                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        `);
                        let progress_bar =  main_parent.find('.p_bar');                        
                        if(video_url){
                            $.ajax({                        
                                url: video_url,
                                type: 'POST', 
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },                       
                                data: form_data,                            
                                contentType: false,
                                processData: false,                       
                                dataType: 'JSON',

                                xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {                                    
                                        var percentComplete = evt.loaded / evt.total; 
                                        let c_progress = Math.round(percentComplete * 100); 
                                        progress_bar.attr('aria-valuenow',c_progress);
                                        progress_bar.css('width',c_progress+'%');

                                        progress_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                    }
                                }, false);
                                return xhr;
                                },
                                success: function(data){
                                    current_file.attr('disabled',false);  
                                    // console.error(data[path]);
                                    let path = data['path'];  
                                    let upload_vid = current_file.parents('.lecture_vid').first().find('source').first();
                                    upload_vid.attr('src', path);
                                    let media = data['media']; 
                                    
                                    progress_bar.parent().remove();                                  
                                },
                                error: function(data){
                                   alert('somethingw went wrong');
                                   progress_bar.parent().remove();    
                                   current_file.attr('disabled',false);  
                              

                                }
                        });
                    }
                    }    
                }              
            });


            $('.sec-container').on( 'change', '.upload_video_res', function(){
                let current_file = $(this);
                let c_f_form  = current_file.parents('.up_video_form');                
                var form_data = new FormData(c_f_form[0]);
                let file = this.files[0];
                if(file){                    
                    let file_err = current_file.parent().find('.file_err');                    
                    var f_type = file.type;
                    if( f_type !== "video/mp4" && f_type !== "video/ogg" && f_type !=="video/webm"){
                        file_err.addClass('d-block').text('Only MP4, OGG, WEBM formats are allowed');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.removeClass('d-block').addClass('d-none').text();
                            current_file.removeClass('is-invalid');
                        },10000);
                    }
                    else if(parseInt(file.size/1024/1024) > 4096){                               
                        file_err.addClass('d-block').text('File size cannot exceed from 4GB');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.removeClass('d-block').addClass('d-none').text();
                            current_file.removeClass('is-invalid');
                        },10000);

                    }
                    else{
                        current_file.attr('disabled',true);
                        let video_url = current_file.attr('video_url');
                        let main_parent = current_file.parents('.up_vid_res').first();
                        main_parent.append(`
                        <div class="progress mt-3">
                            <div class="p_bar progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 0%"
                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        `);
                        let progress_bar =  main_parent.find('.p_bar');
                        if(video_url){
                            $.ajax({                        
                                url: video_url,
                                type: 'POST', 
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },                       
                                data: form_data,                            
                                contentType: false,
                                processData: false,                       
                                dataType: 'JSON',

                                xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {                                    
                                        var percentComplete = evt.loaded / evt.total; 
                                        let c_progress = Math.round(percentComplete * 100); 
                                        progress_bar.attr('aria-valuenow',c_progress);
                                        progress_bar.css('width',c_progress+'%');

                                        progress_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                    }
                                }, false);
                                return xhr;
                                },
                                success: function(data){
                                    current_file.attr('disabled',false);  
                                    let path = data['path'];  
                                    let upload_vid = current_file.parents('.up_vid_res').first();
                                    let media = data['media']; 
                                    let res = current_file.parents('.up_vid_res').prev('.resources');
                                    let video_btn = res.find('.video_res_can').first();                                    
                                    video_btn.removeClass('video_res_can').addClass('uploaded_res_video_close').html('<i class="las la-times"></i>Uploaded Video');
                                    res.prev('.lecture_container').find('.lec_more_close').removeClass('lec_more_close').addClass('added_res_cancel');
                                    upload_vid.replaceWith(`<section class="uploaded_video row p-3">
                                            <div class="col-md-9">
                                                <div class="d-flex">
                                                    <video width="500" height="240" controls oncontextmenu="return false;">
                                                         <source src="${path}" type="${media['f_mimetype']}">
                                                    </video>                                                    
                                                </div>
                                                <section class="mt-2">
                                                    <h3 class="d-none d-md-block ml-3"> ${data['f_name']} </h3>  
                                                    <form url="${data['delete']}">                                                          
                                                        <button type="button" class="btn btn-danger del_uploaded_vid"> Delete lecture </button>
                                                    </form>
                                                </section>                                         
                                            </div>
                                            
                                        </section>
                                    `);
                                   
                                },
                                error: function(data){
                                    progress_bar.parent().remove();
                                    current_file.attr('disabled',false);
                                    let show_err = c_f_form.children('.video_err');       
                                    data = JSON.parse(data['responseText'])['errors'];                
                                    show_err.removeClass('d-none').addClass('d-block').text(data['upload_video']);
                                    setTimeout(function() {
                                        show_err.addClass('d-none').removeClass('d-block');                                        
                                    }, 10000);
                                }
                        });
                    }
                    }    
                }              
            });

            
            $('.sec-container').on( 'click', '.v_c_vid', function(){
                let lec_container = $(this).parents('.lecture_container').first();
                let lec_vid = lec_container.nextAll('.lecture_vid, .upload_video_con').first();
              
                $(this).html('<i class="las las la-times"></i> Video').removeClass('website-outline v_c_vid').
                    addClass('btn-danger v_c_can');
                
                let desc = lec_container.find('.lec_desc_update_cancel');
                if(desc){
                    desc.click();
                }

                let lec_more_close  = lec_container.find('.lec_more_close');
                if(lec_more_close){
                    lec_more_close.click();
                }

                let lec_desc_p_cancel  = lec_container.find('.lec_desc_p_cancel');
                if(lec_desc_p_cancel){
                    lec_desc_p_cancel.click();
                }

                let lec_desc_cancel  = lec_container.find('.lec_desc_cancel');
                if(lec_desc_cancel){
                    lec_desc_cancel.click();
                }
                
                let added_res_cancel  = lec_container.find('.added_res_cancel');
                if(added_res_cancel){
                    added_res_cancel.click();
                }
                
                lec_vid.removeClass('d-none');

            } );
            $('.sec-container').on( 'click', '.lec_content_show', function(){
                let lec_container = $(this).parents('.lecture_container').first();
                let lec_vid = lec_container.nextAll('.lecture_vid, .upload_video_con').first();
              
                $(this).html('<i class="las las la-times"></i> Video').removeClass('website-outline lec_content_show').
                    addClass('btn-danger v_c_p_can');
                
                let desc = lec_container.find('.lec_desc_update_cancel');
                if(desc){
                    desc.click();
                }

                let lec_more_close  = lec_container.find('.lec_more_close');
                if(lec_more_close){
                    lec_more_close.click();
                }

                let lec_desc_cancel  = lec_container.find('.lec_desc_cancel');
                if(lec_desc_cancel){
                    lec_desc_cancel.click();
                }
                
                let added_res_cancel  = lec_container.find('.added_res_cancel');
                if(added_res_cancel){
                    added_res_cancel.click();
                }
                let lec_desc_p_cancel  = lec_container.find('.lec_desc_p_cancel');
                if(lec_desc_p_cancel){
                    lec_desc_p_cancel.click();
                }
                
                lec_vid.removeClass('d-none');

            } );

            $('.sec-container').on( 'click', '.v_c_can', function(){
                let lec_container = $(this).parents('.lecture_container').first();
                let lec_vid = lec_container.nextAll('.lecture_vid, .upload_video_con').first();
              
                $(this).html('<i class="las la-caret-down"></i> Video').addClass('website-outline v_c_vid').
                    removeClass('btn-danger v_c_can');
                
                lec_vid.addClass('d-none');

            });              

            $('.sec-container').on( 'click', '.v_c_p_can', function(){
                let lec_container = $(this).parents('.lecture_container').first();
                let lec_vid = lec_container.nextAll('.lecture_vid, .upload_video_con').first();
              
                $(this).html('<i class="las la-plus"></i> Video').addClass('website-outline lec_content_show').
                    removeClass('btn-danger v_c_p_can');
                
                lec_vid.addClass('d-none');
            });  

            
            $('.sec-container').on( 'click', '.del_media', function(){
                if(confirm("Do you want to delete this lecture?")){
                    form = $(this).parent('form');
                    if(form.length){
                        let form_url = form.attr('url');
                        if(form_url){
                            $.ajax({
                            url: form_url,  
                            type: "delete",                                  
                            dataType : 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }                        
                            }).done(function(d){
                                let success_msg = d['status'];
                                let video_url = d['video_url'];
                                if(video_url){                            

                                    let lec_con = form.parents('.lecture_vid');
                                    if(lec_con){                                        
                                        let lecture_container = lec_con.prevAll('.lecture_container').first();
                                        if(lecture_container){
                                            let v_c_can = lecture_container.find('.v_c_can');
                                            if(v_c_can){
                                                v_c_can.html('<i class="las la-plus"></i> Video').removeClass('btn-danger v_c_can').addClass('lec_content website-outline').attr('video_url',video_url);
                                            }else{
                                                let v_c_p_can = lecture_container.find('.v_c_p_can');                                                
                                                if(v_c_p_can){
                                                    v_c_p_can.html('<i class="las la-plus"></i> Video').removeClass('btn-danger v_c_p_can')
                                                    .addClass('lec_content_show website-outline').attr('video_url',video_url);
                                                }
                                            }
                                            form.parents('.lecture_vid').first().remove();                                
                                        }
                                    }                                        
                                } 
                                alert(success_msg);
                                location.reload();


                            }).fail(function(){
                                console.log(d.responseText);
                            });
                        }
                    }
                }

            });
            
            $('.sec-container').on( 'click', '.lec_desc', function(){
                let lec_con = $(this).parents('.lecture_container').first();   
                let desc_url = $(this).attr('desc_url');
                if(desc_url){                    
                    if(lec_con.next('.lec_desc_con').length === 0){
                    lec_con.after(`
                            <div class="lec_desc_con bg-white border p-2 p-md-5">
                                <form desc_form_url="${desc_url}">
                                    <h3 class="text-center"> Description of Lecture </h3>
                                    <p class="font-weight-normal text-center"> This description will be shown in the end of provided video. From this, students
                                        will be able to get an idea about the lecture </p>
                                    <div class="form-group">
                                        <textarea class="form-control desc_detail" 
                                         name="lec_desc" id="lec_desc" rows="5" cols="50" placeholder="Put all possible detail of related video"></textarea>

                                    </div>
                                    <div class="alert alert-danger d-none text-center desc_err_msg"></div>
                                    
                                    <button type="button" class="btn bg-static-website add_desc_btn">
                                        Add Description 
                                    </button>
                                </form>
                            </div>
                    `);

                    $(this).removeClass('lec_desc  website-outline').addClass('btn-danger lec_desc_p_cancel').
                            html('<i class="las la-times"></i> Description');
                    
                    let v_c_can  = lec_con.find('.v_c_can');
                    if(v_c_can){
                        v_c_can.click();
                    }   
                    let v_c_p_can  = lec_con.find('.v_c_p_can');
                    if(v_c_p_can){
                        v_c_p_can.click();
                    }   
                    let lec_more_close  = lec_con.find('.lec_more_close');
                    if(lec_more_close){
                        lec_more_close.click();
                    }   
                    let added_res_cancel  = lec_con.find('.added_res_cancel');
                    if(added_res_cancel){
                        added_res_cancel.click();
                    }   
                }
                    

                }
            });

            
            $('.sec-container').on( 'click', '.lec_desc_cancel', function(){
                $(this).parents('.lecture_container').first().nextAll('.lec_desc_con').first().addClass('d-none'); 
                $(this).removeClass('btn-danger lec_desc_cancel').addClass('lec_desc_show  website-outline').
                            html('<i class="las la-caret-down"></i> Description')
            });

            $('.sec-container').on( 'click', '.lec_desc_p_cancel', function(){
                $(this).parents('.lecture_container').first().nextAll('.lec_desc_con').first().addClass('d-none'); 
                $(this).removeClass('btn-danger lec_desc_p_cancel').addClass('lec_desc_p_show  website-outline').
                            html('<i class="las la-plus"></i> Description')
            });

            $('.sec-container').on( 'click', '.lec_desc_show', function(){
                let con = $(this).parents('.lecture_container').first();
                con.nextAll('.lec_desc_con').first().removeClass('d-none'); 
                $(this).removeClass('website-outline lec_desc_show').addClass('lec_desc_cancel btn-danger').
                            html('<i class="las la-times"></i> Description');
                let v_c_can  = con.find('.v_c_can');
                if(v_c_can){
                    v_c_can.click();
                }
                let lec_more_close  = con.find('.lec_more_close');
                if(lec_more_close){
                    lec_more_close.click();
                }
                let added_res_cancel  = con.find('.added_res_cancel');
                if(added_res_cancel){
                    added_res_cancel.click();
                }
            });
            $('.sec-container').on( 'click', '.lec_desc_p_show', function(){
                let con = $(this).parents('.lecture_container').first();
                con.nextAll('.lec_desc_con').first().removeClass('d-none'); 
                $(this).removeClass('website-outline lec_desc_p_show').addClass('lec_desc_p_cancel btn-danger').
                            html('<i class="las la-times"></i> Description');

                let v_c_can  = con.find('.v_c_can');
                if(v_c_can){
                    v_c_can.click();
                }

                let v_c_p_can  = con.find('.v_c_p_can');
                if(v_c_p_can){
                    v_c_p_can.click();
                }
                
                let lec_more_close  = con.find('.lec_more_close');
                if(lec_more_close){
                    lec_more_close.click();
                }
                let added_res_cancel  = con.find('.added_res_cancel');
                if(added_res_cancel){
                    added_res_cancel.click();
                }

            });
            
            $('.sec-container').on( 'click', '.lec_desc_update_cancel', function(){
                $(this).parents('.lecture_container').first().nextAll('.lec_desc_con').addClass('d-none').removeClass('d-block'); 
                $(this).removeClass('btn-danger lec_desc_update_cancel').addClass('lec_desc_update_php website-outline').
                            html('<i class="las la-caret-down"></i> Description');
                
                
            });
            
            $('.sec-container').on( 'click', '.add_desc_btn', function(){
                let desc_btn = $(this);
                let form = desc_btn.parent('form');   
                let lec_desc = form.serialize();
               
                if(form.length>0){                                      
                    $.ajax({                    
                    url: form.attr('desc_form_url'),
                    type: 'POST',                    
                    data: lec_desc,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',                    
                    success: function (data) { 
                        let status = data['status'];

                        form.find('.desc_detail').val(data['lec_desc']);
                        if(!desc_btn.text().startsWith('saved')){
                            desc_btn.text('Save Description');
                        }

                        let lec_con = form.parents('.lec_desc_con');

                        let desc_btn_ = lec_con.prev('.lecture_container').find('.lec_desc_cancel');
                        if(desc_btn_.length > 0){
                            desc_btn_.removeClass('lec_desc_cancel').addClass('lec_desc_update_cancel').html('<i class="las la-caret-down"></i> Description');
                        }
                        if(status){
                            alert(status);
                        }

                    },
                    error: function(data){
                        let desc_err = JSON.parse(data.responseText)['errors'];
                        let err_msg_show = desc_btn.prev('.desc_err_msg');
                        let msg = desc_err['lec_desc'];                        
                        
                        err_msg_show.text(msg); 
                        err_msg_show.removeClass("d-none").addClass('d-block');
                        setInterval(function(){
                            err_msg_show.removeClass('d-block').addClass('d-none');
                        },10000);
                    }
                }); 

                }
            }); 

            
            $('.sec-container').on( 'click', '.lec_desc_update', function(){
                
                $(this).parents('.sec-container').first().nextAll('.lec_desc_con').removeClass('d-none').addClass('d-block');
                $(this).removeClass('lec_desc_update website-outline').addClass('lec_desc_update_cancel btn-danger').html('<i class="las las la-times"></i>Description');
            });
            
            $('.sec-container').on( 'click', '.lec_desc_update_php', function(){
                let desc_con = $(this).parents('.lecture_container').first();
                desc_con.nextAll('.lec_desc_con').first().removeClass('d-none').addClass('d-block');
                $(this).removeClass('lec_desc_update_php website-outline').addClass('lec_desc_update_cancel btn-danger').html('<i class="las las la-times"></i>Description');
            
                let vid_btn = desc_con.find('.v_c_can');
                if(vid_btn){
                    vid_btn.click();
                }
                let vid_btn_p = desc_con.find('.v_c_p_can');
                if(vid_btn_p){
                    vid_btn_p.click();
                }

                let lec_more_close  = desc_con.find('.lec_more_close');
                if(lec_more_close){
                    lec_more_close.click();
                }
                
                let added_res_cancel  = desc_con.find('.added_res_cancel');
                if(added_res_cancel){
                    added_res_cancel.click();
                }
                
                
            });

            
            $('.sec-container').on( 'click', '.lec_more', function(){
                let parent = $(this).parents('.lecture_container').first();
                let vid_url = $(this).attr('res_vid');
                if(parent && vid_url){
                            // <div class="video_res pt-3 text-center res_hover_view py-md-2 font-weight-normal " upload_video_url ="${vid_url}"> Upload Video </div>
                    parent.after(`                        
                        <div class="container resources bg-white d-md-flex justify-content-md-between py-2 p-md-4 border">    
                            <div class="article_res pt-3 text-center res_hover_view py-md-2 font-weight-normal"  > Article </div>
                            <div class="external_res pt-3 text-center res_hover_view py-md-2 font-weight-normal"  > External Resource </div>
                            <div class="other_res pt-3 text-center res_hover_view py-md-2 font-weight-normal"  > Other Files </div>   
                        </div>
                    `);
                    $(this).removeClass('lec_more website-outline').addClass('lec_more_close btn-danger').html('<i class="las la-times"></i>Resources');
                    let vid_btn = parent.find('.v_c_can');
                    if(vid_btn){
                        vid_btn.click();
                    }
                    let v_c_p_can = parent.find('.v_c_p_can');
                    if(v_c_p_can){
                        v_c_p_can.click();
                    }

                    let lec_desc_update_cancel   = parent.find('.lec_desc_update_cancel ');
                    if(lec_desc_update_cancel ){
                        lec_desc_update_cancel.click();
                    }
                    let lec_desc_cancel   = parent.find('.lec_desc_cancel');
                    if(lec_desc_cancel){
                        lec_desc_cancel.click();
                    }
                    let lec_desc_p_cancel   = parent.find('.lec_desc_p_cancel');
                    if(lec_desc_p_cancel){
                        lec_desc_p_cancel.click();
                    }

                }
            });

            $('.sec-container').on( 'click', '.lec_more_close', function(){
                let parent = $(this).parents('.lecture_container').first();
                if(parent.length > 0){
                    var $resource = parent.nextAll('.resources').first();
                    let video_res_can = $resource.find('.video_res_can');
                    if(video_res_can.length){
                        video_res_can.click();
                    }
                    let article_res_can = $resource.find('.article_res_can');
                    if(article_res_can.length){
                        article_res_can.click();
                    }
                    
                    
                    let external_res_can = $resource.find('.external_res_can');
                    if(external_res_can.length){
                        external_res_can.click();
                    }

                    let other_res_can = $resource.find('.other_res_can');
                    if(other_res_can.length){
                        other_res_can.click();
                    }                
                    $resource.remove();    
                                        
                    $(this).removeClass('lec_more_close btn-danger').addClass('lec_more website-outline').html('<i class="las la-plus"></i>Resources');
                
            }
            });

           
            $('.sec-container').on( 'click', '.video_res', function(){
                let res_con = $(this).parents('.resources').first();
                let video_section = res_con.nextAll('.up_vid_res').first();
                let video_url = $(this).attr('upload_video_url');
                if(video_section.length < 1 && video_url){
                    $(this).removeClass('video_res website-outline').addClass('video_res_can btn btn-danger').
                        html('<i class="las la-times"></i>Upload Video');
                                // <a class="nav-link vid_upload_op" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Add from Library</a>
                    res_con.after(`
                    <section class="up_vid_res bg-white p-2 p-md-4 border">                       
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active vid_upload" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Upload video</a>
                            </li>
                            <li class="nav-item" role="presentation">
                            </li>                           
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form class="up_video_form" >
                                    <div class="d-none alert alert-danger video_err text-center"> </div>
                                    <div class="custom-file mt-3">
                                        <input type="file" name="upload_video" class="custom-file-input upload_video_res" 
                                        id="custom_file" video_url ="${video_url}">
                                        <label class="custom-file-label" for="custom_file"> Upload Video </label>
                                        <div class="d-none invalid-feedback file_err"></div>                            
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                abcdef
                            </div>                            
                        </div>
                    </section>
                    `);
                    let article_res_can = res_con.find('.article_res_can');
                    if(article_res_can){
                        article_res_can.click();
                    }
                    let external_res_can = res_con.find('.external_res_can');
                    if(external_res_can){
                        external_res_can.click();
                    }
                    let other_res_can = res_con.find('.other_res_can');
                    if(other_res_can){
                        other_res_can.click();
                    }
                }
            });
            
            $('.sec-container').on( 'click', '.uploaded_res_video_close', function(){
                let parent = $(this).parents('.resources').first();
                if(parent.length > 0){
                    parent.nextAll('.uploaded_video').first().addClass('d-none');                    
                    $(this).removeClass('uploaded_res_video_close btn-danger').addClass('show_uploaded_vid website-outline').html('<i class="las la-caret-down"></i>Uploaded Video');
                }
            });

            $('.sec-container').on( 'click', '.show_uploaded_vid', function(){
                let parent = $(this).parents('.resources').first();
                if(parent.length > 0){
                    parent.nextAll('.uploaded_video').first().removeClass('d-none');                    
                    $(this).removeClass('show_uploaded_vid website-outline').addClass('uploaded_res_video_close btn-danger').html('<i class="las la-times"></i>Uploaded Video');
                    let article_res_can = parent.find('.article_res_can');
                    if(article_res_can){
                        article_res_can.click();
                    }
                    let external_res_can = parent.find('.external_res_can');
                    if(external_res_can){
                        external_res_can.click();
                    }
                    let other_res_can = parent.find('.other_res_can');
                    if(other_res_can){
                        other_res_can.click();
                    }
                }
            });


            $('.sec-container').on( 'click', '.del_uploaded_vid', function(){
                if(confirm("Do you want to delete this lecture?")){
                    form = $(this).parent('form');
                    if(form.length){
                        let form_url = form.attr('url');
                        if(form_url){
                            $.ajax({
                            url: form_url,  
                            type: "delete",                                  
                            dataType : 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }                        
                            }).done(function(d){
                                let success_msg = d['status'];
                                let video_url = d['upload_video_url'];
                                if(video_url){                                    
                                    form.parents('.uploaded_video').prev('.resources').first().find('.uploaded_res_video_close').                                    
                                        html('Upload Video').removeClass('btn-danger uploaded_res_video_close').addClass('video_res website-outline').attr('video_url',video_url);
                                    form.parents('.uploaded_video').first().remove();                                
                                } 
                                alert(success_msg);
                                
                            }).fail(function(d){
                                alert('Your video was not deleted because of technical problem. Please try again.');
                                console.log(d.responseText);
                            });
                        }
                    }
                }

            });

            
            $('.sec-container').on( 'click', '.added_res', function(){
                let parent = $(this).parents('.lecture_container').first();
                if(parent){
                    parent.nextAll('.resources').first().removeClass('d-none').addClass('d-md-flex');
                }
                $(this).removeClass('added_res website-outline').addClass('added_res_cancel btn-danger').html('<i class="las la-times"></i>Resource');
                
                let v_c_can  = parent.find('.v_c_can');
                if(v_c_can){
                    v_c_can.click();
                }

                let v_c_p_can  = parent.find('.v_c_p_can');
                if(v_c_p_can){
                    v_c_p_can.click();
                }

                let lec_desc_update_cancel  = parent.find('.lec_desc_update_cancel');
                if(lec_desc_update_cancel){
                    lec_desc_update_cancel.click();
                }

                let lec_desc_cancel  = parent.find('.lec_desc_cancel');
                if(lec_desc_cancel){
                    lec_desc_cancel.click();
                }

                let lec_desc_p_cancel  = parent.find('.lec_desc_p_cancel');
                if(lec_desc_p_cancel){
                    lec_desc_p_cancel.click();
                }

            });

            $('.sec-container').on( 'click', '.added_res_cancel', function(){
                let parent = $(this).parents('.lecture_container').first();
                if(parent){
                    let res = parent.nextAll('.resources').first();
                    res.removeClass('d-md-flex').addClass('d-none');                    
                    $(this).removeClass('added_res_cancel btn-danger').addClass('added_res website-outline').html('<i class="las la-caret-down"></i>Resource');
                     
                    let video_res_can= res.find('.video_res_can');
                    if(video_res_can){
                        video_res_can.click();
                    }
                    let article_res_can= res.find('.article_res_can');
                    if(article_res_can){
                        article_res_can.click();
                    }
                    let external_res_can= res.find('.external_res_can');
                    if(external_res_can){
                        external_res_can.click();
                    }
                    let other_res_can= res.find('.other_res_can');
                    if(other_res_can){
                        other_res_can.click();
                    }
                    let uploaded_res_video_close= res.find('.uploaded_res_video_close');
                    if(uploaded_res_video_close){
                        uploaded_res_video_close.click();
                    }
                }
            });

             
            $('.sec-container').on( 'click', '.article_res', function(){
                let res_con = $(this).parents('.resources').first();
                let resource = res_con.prevAll('.lecture_container').first().find('.lec_more_close , .added_res_cancel');
                let article_url = resource.attr('article_url');
                let up_article_res = res_con.nextAll('.up_article_res').first();
                
                if(up_article_res  && article_url){
                    $(this).removeClass('article_res').addClass('article_res_can btn btn-danger').
                        html('<i class="las la-times"></i>Article');
                    res_con.after(`
                    <section class="up_article_res bg-white p-2 p-md-4 border">
                        <h3 class="text-center"> Add Extra Article </h3>
                        <p class="text-white bg-info p-3 font-weight-normal"> This provided article may help your students to enhance their capibilities and might help to understand your lecture in a better and organized way </p>
                        <form article_url="${article_url}" class="article_form">
                            <div class="input-group mb-3">
                                <textarea maxlength="1485" required class="form-control article_text" name="article_text" id="article_text" rows="10" placeholder="Please type the article that might help students to learn more"></textarea>
                                <div class="input-group-append">
                                    <span class="input-group-text char-counter">1500</span>
                                </div>
                            </div>
                            <span class="float-right font-weight-normal"> allowed 1500 characters</span>
                            <button type="submit" class="btn btn-info"> <i class="las la-save"></i> Save Article </button>                            
                        </form>
                    </section>
                    `);
                    let video_res_can= res_con.find('.video_res_can');
                    if(video_res_can){
                        video_res_can.click();
                    }
                   
                    let external_res_can= res_con.find('.external_res_can');
                    if(external_res_can){
                        external_res_can.click();
                    }
                    let other_res_can= res_con.find('.other_res_can');
                    if(other_res_can){
                        other_res_can.click();
                    }
                    let uploaded_res_video_close= res_con.find('.uploaded_res_video_close');
                    if(uploaded_res_video_close){
                        uploaded_res_video_close.click();
                    }

                }
            });

            
            $('.sec-container').on('submit', '.article_form', function(event){
                event.preventDefault();
                let form = $(this);
                let url = $(this).attr('article_url');                
                if(url){
                    var formData = $(this).serialize();
                    var request = $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });

                    request.done(function(msg) {
                        alert(msg['status']); 
                    });

                    request.fail(function(err) {
                        var err_ob =  err.responseText;
                        err_ob = JSON.parse(err_ob);
                        if(err_ob){
                            let errs = err_ob['errors'];
                            let article_text = errs.article_text;                            
                            if(article_text){
                                alert(article_text[0]);
                            }else{
                                alert(errs);
                            }
                        }
                    });
                }
            });
            
            $('.sec-container').on('click', '.article_res_can', function(){
                let res = $(this).parents('.resources').first().nextAll('.up_article_res').first();
                if(res){
                    res.addClass('d-none');
                    $(this).removeClass('article_res_can btn-danger').addClass('article_res_show website-outline').html('<i class="las la-caret-down"></i>Article');
                }

            });
            
            $('.sec-container').on('click', '.article_res_show', function(){
                let res_con = $(this).parents('.resources').first();
                let res = res_con.nextAll('.up_article_res').first();
                if(res){
                    res.removeClass('d-none');
                    $(this).removeClass('article_res_show website-outline').addClass('article_res_can btn-danger').html('<i class="las la-times"></i>Article');
                    let video_res_can= res_con.find('.video_res_can');
                    if(video_res_can){
                        video_res_can.click();
                    }
                   
                    let external_res_can= res_con.find('.external_res_can');
                    if(external_res_can){
                        external_res_can.click();
                    }
                    let other_res_can= res_con.find('.other_res_can');
                    if(other_res_can){
                        other_res_can.click();
                    }
                    let uploaded_res_video_close= res_con.find('.uploaded_res_video_close');
                    if(uploaded_res_video_close){
                        uploaded_res_video_close.click();
                    }
                }

            });

            $('.sec-container').on( 'click', '.external_res', function(){
                let res_con = $(this).parents('.resources').first();
                let resource = res_con.prevAll('.lecture_container').first().find('.lec_more_close , .added_res_cancel');
                let ex_res_url = resource.attr('ex_res_url');
                let ex_res_con = res_con.nextAll('.ex_res_con').first();
                
                if(ex_res_con  && ex_res_url){
                    $(this).removeClass('external_res').addClass('external_res_can btn btn-danger').
                        html('<i class="las la-times"></i>ExternalResource');
                    res_con.after(`
                    <section class="ex_res_con bg-white p-2 p-md-4 border">
                        <h3 class="text-center"> Add YouTube Link </h3>
                        <p class="text-white bg-info px-2 py-1"> Provide the link that you think might help your students to understand the lecture more clearly </p>
                        <form ex_res_url="${ex_res_url}" class="ex_url_form">
                            <div class="form-group">
                                <input type="text" class="form-control" id="ex_res_title" name="ex_res_title" placeholder="Title">                                
                                <span class="font-weight-normal"> Title must have max 60 words</span>
                            </div>
                            <div class="form-group">
                                <input type="url" class="form-control" id="ex_res_link" name="ex_res_link" placeholder="YouTube link">  
                                <span class="font-weight-normal"> The above provided link must be youtube link otherwise your video will not be shown to others</span>                              
                            </div>
                            <button type="submit" class="btn btn-info"> <i class="las la-save"></i> Save Link </button>                            
                        </form>
                    </section>
                    `);
                    let video_res_can= res_con.find('.video_res_can');
                    if(video_res_can){
                        video_res_can.click();
                    }
                   
                    let article_res_can= res_con.find('.article_res_can');
                    if(article_res_can){
                        article_res_can.click();
                    }
                    let other_res_can= res_con.find('.other_res_can');
                    if(other_res_can){
                        other_res_can.click();
                    }
                    let uploaded_res_video_close= res_con.find('.uploaded_res_video_close');
                    if(uploaded_res_video_close){
                        uploaded_res_video_close.click();
                    }
                }
            });

            $('.sec-container').on('submit', '.ex_url_form', function(event){
                event.preventDefault();
                let form = $(this);
                let url = $(this).attr('ex_res_url');                
                if(url){
                    var formData = $(this).serialize();
                    var request = $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });

                    request.done(function(msg) {
                        alert(msg['status']); 
                    });

                    request.fail(function(err) {
                        var err_ob =  err.responseText;
                        err_ob = JSON.parse(err_ob);
                        if(err_ob){
                            let errs = err_ob['errors'];
                            let ex_res_title = errs.ex_res_title;                            
                            let ex_res_link = errs.ex_res_link;                            
                            if(ex_res_title){
                                alert(ex_res_title[0]);
                            }else if(ex_res_link){
                                alert(ex_res_link[0]);
                            }
                            else{
                                alert(errs);
                            }
                        }
                    });
                }
            });
            
            $('.sec-container').on('click', '.external_res_can', function(){
                let res = $(this).parents('.resources').first().nextAll('.ex_res_con').first();
                if(res){
                    res.addClass('d-none');
                    $(this).removeClass('external_res_can btn-danger').addClass('external_res_show website-outline').html('<i class="las la-caret-down"></i>External Resource');
                }

            });
            
            $('.sec-container').on('click', '.external_res_show', function(){
                let res_con = $(this).parents('.resources').first();
                let res = res_con.nextAll('.ex_res_con').first();
                if(res){
                    res.removeClass('d-none');
                    $(this).removeClass('external_res_show website-outline').addClass('external_res_can btn-danger').html('<i class="las la-times"></i>External Resource');
                    let video_res_can= res_con.find('.video_res_can');
                    if(video_res_can){
                        video_res_can.click();
                    }
                   
                    let article_res_can= res_con.find('.article_res_can');
                    if(article_res_can){
                        article_res_can.click();
                    }
                    let other_res_can= res_con.find('.other_res_can');
                    if(other_res_can){
                        other_res_can.click();
                    }
                    let uploaded_res_video_close= res_con.find('.uploaded_res_video_close');
                    if(uploaded_res_video_close){
                        uploaded_res_video_close.click();
                    }
                }

            });

            $('.sec-container').on( 'click', '.other_res', function(){
                let res_con = $(this).parents('.resources').first();
                let resource = res_con.prevAll('.lecture_container').first().find('.lec_more_close , .added_res_cancel');
                let other_files_url = resource.attr('other_files_url');
                let other_files_con = res_con.nextAll('.other_files_con').first();
                
                if(other_files_con  && other_files_url){
                    $(this).removeClass('other_res').addClass('other_res_can btn btn-danger').
                        html('<i class="las la-times"></i>Other Files');
                    res_con.after(`
                    <section class="other_files_con bg-white p-2 p-md-4 border">
                        <h3 class="text-center"> Upload Extra Documents </h3>
                        <p class="text-info px-2 py-1"> Upload any pdf format file that you might think help your students to understand your lecture more clearly.
                        Please note that you can only upload one document. </p>
                        <form  class="other_files_form">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" other_files_url="${other_files_url}" class="custom-file-input upload_ot_file" id="upload_ot_file" name="upload_ot_file">
                                    <label class="custom-file-label" for="upload_ot_file">Upload file</label>
                                </div>            
                            </div>  
                            <div class="d-none text-danger file_err"></div>
                            <div class="font-weight-normal text-danger"> *Pdf and ZIP files are allowed</div>                            
                        </form>
                    </section>
                    `);
                    let video_res_can= res_con.find('.video_res_can');
                    if(video_res_can){
                        video_res_can.click();
                    }
                   
                    let article_res_can= res_con.find('.article_res_can');
                    if(article_res_can){
                        article_res_can.click();
                    }
                    let external_res_can = res_con.find('.external_res_can')
                    if(external_res_can) {
                        external_res_can.click();
                    }
                    let uploaded_res_video_close= res_con.find('.uploaded_res_video_close');
                    if(uploaded_res_video_close){
                        uploaded_res_video_close.click();
                    }
                }
            });

            $('.sec-container').on( 'change', '.upload_ot_file', function(){
                let current_file = $(this);
                let c_f_form  = current_file.parents('.other_files_form');                
                var form_data = new FormData(c_f_form[0]);
                let file = this.files[0];
                let file_err = c_f_form.find('.file_err').first();
                if(file){  
                    // console.log(file.name);
                    let ex = file.name.split('.').pop();                    
                    if(ex !== "pdf" && ex !== "zip" ){
                        file_err.removeClass('d-none').text('Only pdf or zip file is allowed');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.addClass('d-none').text();
                            current_file.removeClass('is-invalid');
                        },10000);
                    }
                    else if(parseInt(file.size/1024/1024) > 1024){                               
                        file_err.removeClass('d-none').text('File size cannot exceed from 1GB');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.removeClass('d-none');
                            current_file.removeClass('is-invalid');
                        },10000);
                    }
                    else{
                        current_file.attr('disabled',true);
                        let file_url = current_file.attr('other_files_url');
                        let main_parent = current_file.parents('.other_files_con').first();
                        main_parent.append(`
                        <div class="progress mt-3">
                            <div class="p_bar progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 0%"
                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        `);
                        let progress_bar =  main_parent.find('.p_bar');
                        if(file_url){
                            $.ajax({                        
                                url: file_url,
                                type: 'POST', 
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },                       
                                data: form_data,                            
                                contentType: false,
                                processData: false,                       
                                dataType: 'JSON',

                                xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {                                    
                                        var percentComplete = evt.loaded / evt.total; 
                                        let c_progress = Math.round(percentComplete * 100); 
                                        progress_bar.attr('aria-valuenow',c_progress);
                                        progress_bar.css('width',c_progress+'%');
                                        progress_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                    }
                                }, false);
                                return xhr;
                                },
                                success: function(data){
                                    current_file.attr('disabled',false);  
                                    let path = data['path'];  
                                    let upload_vid = current_file.parents('.other_files_con').first();
                                    let media = data['media']; 
                                    let other_files_con  = c_f_form.parents('.other_files_con').first();
                                    c_f_form.remove();
                                    progress_bar.parent().remove();
                                    other_files_con.append(`
                                        <form class="delete_other_file d-flex align-items-center" delete_o_f_url ="${data['delete_url']}">
                                            <div prev_url="${data['preview_file']}" class="cursor_pointer file_preview"> ${media['f_name']} </div>
                                            <button type="submit" class="btn btn-danger ml-3"> <i class="las la-trash-alt"></i> </button>
                                        </form>
                                    `);
                                },
                                error: function(data){
                                    current_file.attr('disabled',false);
                                    data = JSON.parse(data['responseText']);                
                                    let err_msg = data['message'];
                                    if(err_msg){
                                        alert(err_msg);                                    
                                    }
                                }
                        });
                    }
                    }    
                }              
            });
            
            $('.sec-container').on('click', '.other_res_can', function(){
                let res = $(this).parents('.resources').first().nextAll('.other_files_con').first();
                if(res){
                    res.addClass('d-none');
                    $(this).removeClass('other_res_can btn-danger').addClass('other_res_show website-outline').html('<i class="las la-caret-down"></i>Other Files');
                }

            });
            
            $('.sec-container').on('click', '.other_res_show', function(){
                let res_con = $(this).parents('.resources').first();
                let res = res_con.nextAll('.other_files_con').first();
                if(res){
                    res.removeClass('d-none');
                    $(this).removeClass('other_res_show website-outline').addClass('other_res_can btn-danger').html('<i class="las la-times"></i>Other Files');
                    let video_res_can= res_con.find('.video_res_can');
                    if(video_res_can){
                        video_res_can.click();
                    }
                   
                    let article_res_can= res_con.find('.article_res_can');
                    if(article_res_can){
                        article_res_can.click();
                    }
                    let external_res_can = res_con.find('.external_res_can')
                    if(external_res_can) {
                        external_res_can.click();
                    }
                    let uploaded_res_video_close= res_con.find('.uploaded_res_video_close');
                    if(uploaded_res_video_close){
                        uploaded_res_video_close.click();
                    }
                }

            });

            
            $('.sec-container').on('click', '.file_preview', function(){
                let url = $(this).attr('prev_url');
                if(url){                
                    $.ajax({
                        url: url,
                        type: "POST",
                         headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }                     
                        
                    });
                }
            });

            
            $('.sec-container').on('submit', '.delete_other_file', function(e){
                e.preventDefault();
                if(confirm('Do you want to delete the file?')){
                    let form = $(this);
                    let del_url = $(this).attr('delete_o_f_url');
                    if(del_url){
                        $.ajax({
                        type: "delete",
                        url: del_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType : 'json'
                        
                    }).done(function( data ) {
                        let other_files_con = form.parents('.other_files_con').first();
                        if(other_files_con){
                            form.remove();
                            other_files_con.append(`
                            <form class="other_files_form" >
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" other_files_url="${data['other_files_url']}" class="custom-file-input upload_ot_file" id="upload_ot_file" name="upload_ot_file">
                                        <label class="custom-file-label" for="upload_ot_file">Upload file</label>
                                    </div>            
                                </div>  
                                <div class="d-none text-danger file_err"></div>
                                <div class="font-weight-normal text-danger"> *Pdf,docx,ppt files are allowed</div>                            
                            </form> 

                            `);
                            alert(data['status']);

                        }
                    });                    }

                }
            });

            
            $('.sec-container').on('click', '.assignment', function(e){
                $(this).parents('.main_layer').first().replaceWith(`
                    <div class="ass_con p-1">
                        <form class="ass_form">
                            <div class="form-group">
                                <label for="lec_name">Enter Assignment Title</label>
                                <input type="text" class="form-control ass_title"  name="ass_title" placeholder="Enter a title">
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="cancel_lec cursor_pointer mr-2 btn btn-danger"> Cancel </button>
                                <button type="submit" class="btn bg-website"> <i class="las la-plus"></i> Add </button>
                            </div>
                        </form>
                    </div>
                `);
            });

            $('.sec-container').on('submit', '.ass_form', function(event) {
                event.preventDefault();                
                let data = $(this).serializeArray()
                let parent_elem = $(this).parents('.lecture_layer').first();
                let lec_no = $(this).parents('.lecture_layer').first().prevAll('.lecture_container').first().find('.lec_no').text().trim();
                
                if(lec_no){

                    data.push({ 'name': 'lec_no', 'value': lec_no});
                    
                    $.ajax({
                    url: "{{route('assign',['course' => $course_id])}}",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    }).
                    done(function(msg) {                        
                        
                        let assign_no = msg['ass_no'];
                        let title_edit_url = msg['title_edit'];
                        let delete_assign_url = msg['delete_assign'];
                        let ass_title = msg['ass_title'];
                        parent_elem.replaceWith(`
                            <div class="my-3 container assign_con bg-white p-3 border">  
                                <div class="row">
                                    <div class="col-md-6 d-md-flex align-items-md-center">
                                        <div> Assignment <span class="ass_no"> ${assign_no} </span> </div>
                                        <section class="lec_small_container d-md-flex align-items-md-center">
                                            <div class="ass_title ml-md-3 font-weight-normal"> ${ ass_title.length > 30 ? ass_title.substr(0,30)+'...' : ass_title }</div>
                                            <div title_edit="${title_edit_url}" class="assign_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                                            <form action="${delete_assign_url}" method="post" >
                                                   @csrf 
                                                   @method('delete')    
                                            <div class="assign_del ml-md-3 text-danger d-inline d-md-block cursor_pointer" /> <i class="las la-trash-alt"></i> </div>
                                            </form>
                                        </section>
                                    </div>
                                    <div class="col-md-6 d-md-flex align-items-md-center mt-3 mt-md-0">
                                        <div class="add_desc btn website-outline " desc_url="${msg['add_assign_desc']}">
                                            <i class="las la-plus"></i>  Description  
                                        </div>
                                        <div class="btn website-outline add_assign  ml-2" assign_url="${msg['add_ass']}">
                                            <i class="las la-plus"></i>  Assignment
                                        </div>
                                        <div class="add_sol btn website-outline ml-md-2 mt-2 mt-md-0 " sol_url="${msg['add_sol']}">
                                            <i class="las la-plus"></i>  Solution
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                                        
                        `);
                        
                        alert(msg['status']);
                        
                    }).
                    fail(function(err) {
                        let errs = JSON.parse(err.responseText).errors;
                        let title_err = errs.ass_title;
                        if(title_err){
                            alert(title_err[0]);
                        }
                        });

                }
            });

            $('.sec-container').on('submit', '.ass_update_form', function(e) {
                e.preventDefault();
                let title_form = $(this);
                let select_new_title = $(this).find('.ass_title');
                let get_new_title = select_new_title.val().trim();
                let del_url = title_form.attr('del_url');
                let url = $(this).attr('url');
               
                $.ajax({
                
                    url: url,
                    type: 'POST',                
                    data: {updated_title: get_new_title },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',                
                    success: function (data) { 
                        let ass_title = data['ass_title'];
                        title_form.replaceWith(`
                        <section class="lec_small_container d-md-flex align-items-md-center">
                            <div class="ass_title ml-md-3 font-weight-normal"> ${reduceTextLen(ass_title)} </div>
                            <div title_edit="${url}" class=" assign_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                            <form action="${del_url}" method="post" >    
                                @csrf
                                @method('delete')                            
                                <div class="assign_del ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                            </form>
                        </section>
                        `);

                        alert(data['status']);
                    
                       
                    },
                    error: function(returned_data, upcomingStatus){
                        let errors = JSON.parse(returned_data.responseText)['errors'];
                        alert(errors['updated_title'][0]);                        
                            
                    }

                }); 


            });

           
            $('.sec-container').on('click', '.assign_del', function() {
                if(confirm('Are you sure to delete this Assignment?')){
                    $(this).parents('form').first().submit();
                }
            });


            $('.sec-container').on( 'click', '.add_desc', function(){
                let ass_con = $(this).parents('.assign_con').first();   
                let desc_url = $(this).attr('desc_url');
                if(desc_url){                    
                    if(ass_con.next('.ass_desc_con').length === 0){
                    ass_con.after(`
                            <div class="ass_desc_con bg-white border p-2 p-md-5">
                                <form desc_form_url="${desc_url}">
                                    <h3> Description of Assignment </h3>
                                    <p class="font-weight-normal"> The provided description will help your students 
                                    to understand the assignment more clearly. please try your best to convince your students by providing them
                                    more details about the assignment to better understand it </p>
                                    <div class="form-group">
                                        <textarea class="form-control ass_desc_detail" 
                                         name="ass_desc_detail" id="ass_desc_detail" rows="3" cols="50" placeholder="Description of Assignment"></textarea>

                                    </div>
                                    <div class="alert alert-danger d-none text-center ass_err_msg"></div>
                                    
                                    <button type="button" class="btn bg-static-website add_ass_desc">
                                        <i class="las la-plus"></i> Add Description 
                                    </button>
                                    
                                </form>
                            </div>
                    `);

                    $(this).removeClass('add_desc  website-outline').addClass('btn-danger add_desc_cancel').
                            html('<i class="las la-times"></i> Description');
                    }
                }
                let add_assign_can = ass_con.find('.add_assign_can');
                if(add_assign_can ){
                    add_assign_can.click();
                }

                let add_sol_can  = ass_con.find('.add_sol_can');
                if(add_sol_can){
                    add_sol_can.click();
                }
            });

            $('.sec-container').on( 'click', '.add_desc_cancel', function(){
                $(this).parents('.assign_con').first().nextAll('.ass_desc_con').first().remove(); 
                $(this).removeClass('btn-danger add_desc_cancel').addClass('add_desc  website-outline').
                            html('<i class="las la-plus"></i> Description')
            });

            $('.sec-container').on( 'click', '.add_ass_desc', function(){
                let desc_btn = $(this);
                let form = desc_btn.parent('form');   
                let lec_desc = form.serialize();
                let desc__btn = $(this).parents('.ass_desc_con').first().prevAll('.assign_con').first().find('.add_desc_cancel');
                if(form.length>0){                                      
                    $.ajax({                    
                    url: form.attr('desc_form_url'),
                    type: 'POST',                    
                    data: lec_desc,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',                    
                    success: function (data) { 
                        let status = data['status'];
                        if(status){
                            alert(status);
                        }

                        form.find('.ass_desc_detail').val(data['ass_desc_detail']);
                        if(!desc_btn.text().startsWith('save')){
                            desc_btn.text('Save Description');
                        }

                        if(desc__btn.length>0){
                            desc__btn.removeClass('add_desc_cancel').addClass('add_desc_update');
                        }

                    },
                    error: function(data){
                        let desc_err = JSON.parse(data.responseText)['errors'];
                        let err_msg_show = desc_btn.prev('.ass_err_msg');
                        let msg = desc_err['ass_desc_detail'];                        
                        
                        err_msg_show.text(msg); 
                        err_msg_show.removeClass("d-none").addClass('d-block');
                        setInterval(function(){
                            err_msg_show.removeClass('d-block').addClass('d-none');
                        },10000);
                    }
                }); 

                }
            }); 

            
            $('.sec-container').on( 'click', '.add_desc_update', function(){
                $(this).parents('.assign_con').first().nextAll('.ass_desc_con').addClass('d-none');
                $(this).removeClass('btn-danger add_desc_update').addClass('show_desc_update website-outline').
                            html('<i class="las la-caret-down"></i> Description')
            });

            $('.sec-container').on( 'click', '.show_desc_update', function(){
                let con = $(this).parents('.assign_con').first();
                
                con.nextAll('.ass_desc_con').first().removeClass('d-none');
                $(this).removeClass('show_desc_update website-outline').addClass('add_desc_update btn-danger').html('<i class="las las la-times"></i>Description');
                
                let add_ass_can = con.find('.add_assign_can');
                if(add_ass_can){
                    add_ass_can.click();
                }

                let add_sol_can  = con.find('.add_sol_can');
                if(add_sol_can ){
                    add_sol_can .click();
                }
                
            });

              
            $('.sec-container').on( 'click', '.add_assign', function(){

                let res_con = $(this).parents('.assign_con').first();
                    
                    let other_files_url = $(this).attr('assign_url');
                    let ass_container = res_con.nextAll('.ass_container').first();
                    
                    if(ass_container  && other_files_url){
                        $(this).removeClass('add_assign website-outline').addClass('add_assign_can  btn-danger').
                            html('<i class="las la-times"></i>Assignment');
                        res_con.after(`
                        <section class="ass_container bg-white p-2 p-md-4 border">
                            <h3 class="text-center"> Upload Assignment Document </h3>
                            <p class="text-info px-2 py-1 font-weight-normal"> Please make a comprehensive PDF file that contains all possible guide for the student to solve your assignment. Please refer to the 
                            lecture if you feel so. 
                            
                             </p>
                            <form>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" other_files_url="${other_files_url}" class="custom-file-input ass_file" id="ass_file" name="ass_file">
                                        <label class="custom-file-label" for="upload_ot_file">Upload file</label>
                                    </div>            
                                </div>  
                                <div class="d-none text-danger file_err"></div>
                                <div class="font-weight-normal text-danger"> *Only Pdf files are allowed</div>                            
                            </form>
                        </section>
                        `);
                    }
            });

            $('.sec-container').on('click', '.add_assign_can', function(){
                let res = $(this).parents('.assign_con').first().nextAll('.ass_container').first();
                if(res){
                    res.addClass('d-none');
                    $(this).removeClass('add_assign_can btn-danger').addClass('add_assign_show website-outline').html('<i class="las la-caret-down"></i>Assignment');
                }

            });

            $('.sec-container').on('click', '.add_assign_show', function(){
                let p =  $(this).parents('.assign_con').first();
                let res = p.nextAll('.ass_container').first();
                if(res){
                    res.removeClass('d-none');
                    $(this).removeClass('add_assign_show website-outline').addClass('add_assign_can btn-danger').html('<i class="las la-times"></i>Assignment');
                }

                let add_desc_cancel= p.find('.add_desc_cancel');
                if(add_desc_cancel){
                    add_desc_cancel.click();
                }

                let add_sol_can = p.find('.add_sol_can');
                if(add_sol_can){
                    add_sol_can.click();
                }
                let add_desc_update = p.find('.add_desc_update');
                if(add_desc_update){
                    add_desc_update.click();
                }


            });


            $('.sec-container').on( 'change', '.ass_file', function(){
                let current_file = $(this);
                let c_f_form  = current_file.parents('form').first();                
                var form_data = new FormData(c_f_form[0]);
                let file = this.files[0];
                let file_err = c_f_form.find('.file_err').first();
                if(file){  
                    let ex = file.name.split('.').pop();
                    if(ex !== "pdf" ){
                        file_err.removeClass('d-none').text('Only pdf files are allowed');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.addClass('d-none').text();
                            current_file.removeClass('is-invalid');
                        },10000);
                    }
                    else if(parseInt(file.size/1024/1024) > 1024){                               
                        file_err.removeClass('d-none').text('File size cannot exceed from 1GB');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.removeClass('d-none');
                            current_file.removeClass('is-invalid');
                        },10000);
                    }
                    else{
                        current_file.attr('disabled',true);
                        let file_url = current_file.attr('other_files_url');
                        let main_parent = current_file.parents('.other_files_con').first();
                        main_parent.append(`
                        <div class="progress mt-3">
                            <div class="p_bar progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 0%"
                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        `);
                        let progress_bar =  main_parent.find('.p_bar');
                        if(file_url){
                            $.ajax({                        
                                url: file_url,
                                type: 'POST', 
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },                       
                                data: form_data,                            
                                contentType: false,
                                processData: false,                       
                                dataType: 'JSON',

                                xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {                                    
                                        var percentComplete = evt.loaded / evt.total; 
                                        let c_progress = Math.round(percentComplete * 100); 
                                        progress_bar.attr('aria-valuenow',c_progress);
                                        progress_bar.css('width',c_progress+'%');
                                        progress_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                    }
                                }, false);
                                return xhr;
                                },
                                success: function(data){
                                    current_file.attr('disabled',false);  
                                    let media = data['assign']; 
                                    let other_files_con  = c_f_form.parents('.ass_container').first();
                                    c_f_form.remove();
                                    progress_bar.parent().remove();
                                    other_files_con.append(`
                                        <form class="delete_ass_file d-flex align-items-center" del_ass_url ="${data['delete_url']}">
                                            <div prev_url="${data['preview_file']}" class="cursor_pointer as_f_pre"> ${media['ass_f_name']} </div>
                                            <button type="submit" class="btn btn-danger ml-3"> <i class="las la-trash-alt"></i> </button>
                                        </form>
                                    `);
                                },
                                error: function(data){
                                    current_file.attr('disabled',false);
                                    data = JSON.parse(data['responseText']);                
                                    let err_msg = data['ass_file'];
                                    if(err_msg){
                                        alert(err_msg[0]);                                    
                                    }
                                }
                        });
                    }
                    }    
                }              
            });


            
            $('.sec-container').on('submit', '.delete_ass_file', function(e){
                e.preventDefault();
                if(confirm('Do you want to delete the file?')){
                    let form = $(this);
                    let del_url = $(this).attr('del_ass_url');
                    if(del_url){

                       let ass_con = form.parents('.ass_container').first();
                       ass_con.prevAll('.assign_con').first().find('.add_assign_can').removeClass('add_assign_can btn-danger').addClass('add_assign website-outline').html('<i class="las la-plus"></i>Assignment');
                        ass_con.remove();
                        
                        $.ajax({
                        type: "delete",
                        url: del_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType : 'json',

                        success: function(msg){
                            alert(msg['status']);
                        }
                        
                    });

                                   
                }
                
                }
            });


            $('.sec-container').on( 'click', '.add_sol', function(){

                let res_con = $(this).parents('.assign_con').first();
                    
                    let other_files_url = $(this).attr('sol_url');
                    let sol_container = res_con.nextAll('.sol_container').first();
                    
                    if(sol_container  && other_files_url){
                        $(this).removeClass('add_sol website-outline').addClass('add_sol_can  btn-danger').
                            html('<i class="las la-times"></i>Solution');
                        res_con.after(`
                        <section class="sol_container bg-white p-2 p-md-4 border">
                            <h3 class="text-center"> Upload Solution Document </h3>
                            <p class="text-info px-2 py-1 font-weight-normal"> Please make a comprehensive PDF file that contains all answer and related guide for the student to understand the solution. Please refer to the 
                            lecture if you feel so. 
                            
                             </p>
                            <form>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" other_files_url="${other_files_url}" class="custom-file-input sol_file" id="sol_file" name="sol_file">
                                        <label class="custom-file-label" for="sol_file">Upload file</label>
                                    </div>            
                                </div>  
                                <div class="d-none text-danger file_err"></div>
                                <div class="font-weight-normal text-danger"> *Only Pdf files are allowed</div>                            
                            </form>
                        </section>
                        `);
                    }

                    let add_desc_update =  res_con.find('.add_desc_update');
                    if(add_desc_update){
                        add_desc_update.click();
                    }

                    let add_assign_update =  res_con.find('.add_assign_update');
                    if(add_assign_update){
                        add_assign_update.click();
                    }
            });

            $('.sec-container').on('click', '.add_sol_can', function(){
                let res = $(this).parents('.assign_con').first().nextAll('.sol_container').first();
                if(res){
                    res.addClass('d-none');
                    $(this).removeClass('add_sol_can btn-danger').addClass('add_sol_show website-outline').html('<i class="las la-caret-down"></i>Solution');
                }

            });

            $('.sec-container').on('click', '.add_sol_show', function(){
                let p = $(this).parents('.assign_con').first();
                let res = p.nextAll('.sol_container').first();
                if(res){
                    res.removeClass('d-none');
                    $(this).removeClass('add_sol_show website-outline').addClass('add_sol_can btn-danger').html('<i class="las la-times"></i>Solution');
                }

                let add_desc_cancel= p.find('.add_desc_cancel');
                if(add_desc_cancel){
                    add_desc_cancel.click();
                }

                let add_assign_can= p.find('.add_assign_can');
                if(add_assign_can){
                    add_assign_can.click();
                }



            });


            $('.sec-container').on( 'change', '.sol_file', function(){
                let current_file = $(this);
                let c_f_form  = current_file.parents('form').first();                
                var form_data = new FormData(c_f_form[0]);
                let file = this.files[0];
                let file_err = c_f_form.find('.file_err').first();
                if(file){  
                    let ex = file.name.split('.').pop();
                    if(ex !== "pdf" ){
                        current_file.addClass('is-invalid');
                        
                    }
                    else if(parseInt(file.size/1024/1024) > 1024){                               
                        file_err.removeClass('d-none').text('File size cannot exceed from 1GB');
                        current_file.addClass('is-invalid');
                        setInterval(function(){
                            file_err.removeClass('d-none');
                            current_file.removeClass('is-invalid');
                        },10000);
                    }
                    else{
                        current_file.attr('disabled',true);
                        let file_url = current_file.attr('other_files_url');
                        let main_parent = current_file.parents('.other_files_con').first();
                        main_parent.append(`
                        <div class="progress mt-3">
                            <div class="p_bar progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 0%"
                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        `);
                        let progress_bar =  main_parent.find('.p_bar');
                        if(file_url){
                            $.ajax({                        
                                url: file_url,
                                type: 'POST', 
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },                       
                                data: form_data,                            
                                contentType: false,
                                processData: false,                       
                                dataType: 'JSON',

                                xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {                                    
                                        var percentComplete = evt.loaded / evt.total; 
                                        let c_progress = Math.round(percentComplete * 100); 
                                        progress_bar.attr('aria-valuenow',c_progress);
                                        progress_bar.css('width',c_progress+'%');
                                        progress_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                    }
                                }, false);
                                return xhr;
                                },
                                success: function(data){
                                    current_file.attr('disabled',false);  
                                    let media = data['assign']; 
                                    let other_files_con  = c_f_form.parents('.sol_container').first();
                                    c_f_form.remove();
                                    progress_bar.parent().remove();
                                    other_files_con.append(`
                                        <form class="del_sol_f d-flex align-items-center" del_ass_url ="${data['delete_url']}">
                                            <div prev_url="${data['preview_file']}" class="cursor_pointer as_f_pre"> ${media['ass_ans_f_name']} </div>
                                            <button type="submit" class="btn btn-danger ml-3"> <i class="las la-trash-alt"></i> </button>
                                        </form>
                                    `);
                                },
                                error: function(data){
                                    current_file.attr('disabled',false);
                                    data = JSON.parse(data['responseText']);                
                                    let err_msg = data['ass_file'];
                                    if(err_msg){
                                        alert(err_msg[0]);                                    
                                    }
                                }
                        });
                    }
                    }    
                }              
            });


            
            $('.sec-container').on('submit', '.del_sol_f', function(e){
                e.preventDefault();
                if(confirm('Do you want to delete the file?')){
                    let form = $(this);
                    let del_url = $(this).attr('del_ass_url');
                    if(del_url){

                       let ass_con = form.parents('.sol_container').first();
                       ass_con.prevAll('.assign_con').first().find('.add_sol_can').removeClass('add_sol_can btn-danger').addClass('add_sol website-outline').html('<i class="las la-plus"></i>Solution');
                        ass_con.remove();
                        
                        $.ajax({
                        type: "delete",
                        url: del_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType : 'json',

                        success: function(msg){
                            alert(msg['status']);
                        }
                        
                    });

                                   
                }
                
                }
            });

            
            $('.sec-container').on('click', '.quiz', function(e){
                $(this).parents('.main_layer').first().replaceWith(`
                    <div class="quiz_con p-1">
                        <form class="quiz_form">
                            <div class="form-group">
                                <label for="quiz_name">Enter Quiz Title</label>
                                <input type="text" class="form-control quiz_title"  name="quiz_title" placeholder="Enter a title">
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="cancel_lec cursor_pointer mr-2 btn btn-danger"> Cancel </button>
                                <button type="submit" class="btn bg-website"> <i class="las la-plus"></i> Add </button>
                            </div>
                        </form>
                    </div>
                `);
            });


            $('.sec-container').on('submit', '.quiz_form', function(event) {
                event.preventDefault();                
                let data = $(this).serializeArray()
                let parent_elem = $(this).parents('.lecture_layer').first();
                let lec_no = parent_elem.prevAll('.lecture_container').first().find('.lec_no').text().trim();
                
                if(lec_no){

                    data.push({ 'name': 'lec_no', 'value': lec_no});
                    
                    $.ajax({
                    url: "{{route('quiz',['course' => $course_id])}}",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    }).
                    done(function(msg) {                        
                        
                        parent_elem.replaceWith(`
                            <div class="my-3 container quiz_con bg-white p-3 border">  
                                <div class="row">
                                    <div class="col-md-6 d-md-flex align-items-md-center">
                                        <div> Quiz <span class="quiz_no"> ${msg['quiz_no']} </span> </div>
                                        <section class="lec_small_container d-md-flex align-items-md-center">
                                            <div class="quiz_title ml-md-3 font-weight-normal"> ${ msg['quiz_title']}</div>
                                            <div title_edit="${msg['title_edit']}" class="quiz_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                                            <form action="${msg['delete_quiz']}" method="post" >
                                                   @csrf 
                                                   @method('delete')    
                                            <div class="quiz_del ml-md-3 text-danger d-inline d-md-block cursor_pointer" /> <i class="las la-trash-alt"></i> </div>
                                            </form>
                                        </section>
                                    </div>
                                    <div class="col-md-6 d-md-flex align-items-md-center mt-3 mt-md-0">
                                        <div class="quiz_desc btn website-outline " desc_url="${msg['add_quiz_desc']}">
                                            <i class="las la-plus"></i>  Description  
                                        </div>
                                        <div class="btn website-outline quiz_q  ml-2" quiz_url="${msg['add_quizzs']}">
                                            <i class="las la-plus"></i>  Quiz
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                                        
                        `);
                        
                        
                        
                    }).
                    fail(function(err) {
                        let errs = JSON.parse(err.responseText).errors;
                        let title_err = errs.quiz_title;
                        if(title_err){
                            alert(title_err[0]);
                        }
                        });

                }
            });

            $('.sec-container').on('click', '.quiz_edit', function() {
                let c_elem = $(this);
                let quiz_title = c_elem.prevAll('.quiz_title').first();                
                let quiz_con = c_elem.parents('.lec_small_container').first();
                let del_url = c_elem.next().attr('action');

                if(quiz_title){  
                    let get_title_val = quiz_title.text().trim();
                    quiz_con.replaceWith( `<form class="quiz_update_form w-100 mt-md-5" url="${c_elem.attr('title_edit')}" del_url="${del_url}">
                        <input type="text" class="form-control quiz_title" placeholder="Quiz title" name="quiz_title" 
                        value="${get_title_val}">
                        <div class="d-flex justify-content-end mt-1">
                            <div class="btn website-outline mr-2 can_quiz"  ><i class="las la-times"></i> cancel </div>
                            <button type="submit" class="btn website" > <i class="las la-save"></i> Save </button>
                        <div>
                        </form>` );                   
                }
            });

            $('.sec-container').on('click', '.can_quiz', function() {
                
                let pa = $(this).parents('form').first();
                let url = pa.attr('url');
                let del_url = pa.attr('del_url');
                let title = $(this).parent().prevAll('.quiz_title').first().attr('value');
                

                pa.replaceWith(`
                <section class="lec_small_container d-md-flex align-items-md-center">
                    <div class="quiz_title ml-md-3 font-weight-normal"> ${title}</div>
                    <div title_edit="${url}" class=" quiz_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                    <form action="${del_url}" method="post">
                        @csrf
                        @method('delete')
                        <div class="quiz_del ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                    </form>
                </section>
                `);

            });
             
            $('.sec-container').on('submit', '.quiz_update_form', function(e) {
                e.preventDefault();
                let title_form = $(this);
                let select_new_title = $(this).find('.quiz_title');
                let get_new_title = select_new_title.val().trim();
                let del_url = title_form.attr('del_url');
                let url = $(this).attr('url');
               
                $.ajax({
                
                    url: url,
                    type: 'POST',                
                    data: {quiz_title: get_new_title},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',                
                    success: function (data) { 
                        let quiz_title = data['quiz_title'];
                        title_form.replaceWith(`
                        <section class="lec_small_container d-md-flex align-items-md-center">
                            <div class="quiz_title ml-md-3 font-weight-normal"> ${quiz_title} </div>
                            <div title_edit="${url}" class=" quiz_edit ml-md-3 d-inline d-md-block icon-color cursor_pointer"> <i class="las la-pencil-alt"></i> </div>
                            <form action="${del_url}" method="post" >    
                                @csrf
                                @method('delete')                            
                                <div class="quiz_del ml-md-3 text-danger d-inline d-md-block cursor_pointer"> <i class="las la-trash-alt"></i> </div>
                            </form>
                        </section>
                        `);

                        alert(data['status']);
                       
                    },
                    error: function(returned_data, upcomingStatus){
                        let errors = JSON.parse(returned_data.responseText)['errors'];
                        alert(errors['quiz_title'][0]);                        
                            
                    }

                }); 


            });

             
            $('.sec-container').on('click', '.quiz_del', function() {
                if(confirm('Are you sure to delete this Quiz?')){
                    $(this).parents('form').first().submit();
                }
            });

            $('.sec-container').on( 'click', '.quiz_desc', function(){
                let quiz_con = $(this).parents('.quiz_con').first();   
                let desc_url = $(this).attr('desc_url');
                if(desc_url){                    
                    if(quiz_con.next('.quiz_desc_con').length === 0){
                    quiz_con.after(`
                            <div class="quiz_desc_con bg-white border p-2 p-md-5">
                                <form desc_form_url="${desc_url}">
                                    <h3 class="text-center"> Description of Quiz </h3>
                                    <p class="text-center font-weight-normal"> The provided description will help your students 
                                    to understand the quiz more clearly. please try your best to convince your students by providing them
                                    more details about the quiz to better understand it </p>
                                    <div class="form-group">
                                        <textarea class="form-control quiz_desc_detail" 
                                         name="quiz_desc_detail" id="quiz_desc_detail" rows="10" cols="50" placeholder="Description of Quiz"></textarea>

                                    </div>
                                    <div class="alert alert-danger d-none text-center err_msg"></div>
                                    
                                    <button type="button" class="btn bg-static-website add_quiz_desc">
                                        <i class="las la-plus"></i> Add Description 
                                    </button>
                                    
                                </form>
                            </div>
                    `);

                    $(this).removeClass('quiz_desc  website-outline').addClass('btn-danger quiz_c_op').
                            html('<i class="las la-times"></i> Description');
                    }
                }
            });

            $('.sec-container').on( 'click', '.quiz_c_op', function(){
                $(this).parents('.quiz_con').first().nextAll('.quiz_desc_con').first().addClass('d-none'); 
                $(this).removeClass('btn-danger quiz_c_op').addClass('quiz_s_op  website-outline').
                            html('<i class="las la-plus"></i> Description')
            });

            
            $('.sec-container').on( 'click', '.quiz_s_op', function(){
                let p = $(this).parents('.quiz_con').first();
                p.nextAll('.quiz_desc_con').first().removeClass('d-none'); 
                $(this).addClass('btn-danger quiz_c_op').removeClass('quiz_s_op website-outline').
                            html('<i class="las la-times"></i> Description');
                let quiz_q_cancel = p.find('.quiz_q_cancel');
                if(quiz_q_cancel){
                    quiz_q_cancel.click();
                }
            });


            $('.sec-container').on( 'click', '.add_quiz_desc', function(){
                let desc_btn = $(this);
                let form = desc_btn.parent('form');   
                let lec_desc = form.serialize();
                let desc__btn = $(this).parents('.quiz_desc_con').first().prevAll('.quiz_con').first().find('.quiz_c_op');
                if(form.length>0){                                      
                    $.ajax({                    
                    url: form.attr('desc_form_url'),
                    type: 'POST',                    
                    data: lec_desc,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',                    
                    success: function (data) { 
                        let status = data['status'];
                        

                        form.find('.ass_desc_detail').val(data['ass_desc_detail']);
                        if(!desc_btn.text().startsWith('save')){
                            desc_btn.text('Save Description');
                        }


                        if(status){
                            alert(status);
                        }

                    },
                    error: function(data){
                        let desc_err = JSON.parse(data.responseText)['errors'];
                        alert(desc_err['quiz_desc_detail']);
                        
                      
                    }
                }); 

                }
            }); 

        
            $('.sec-container').on( 'click', '.quiz_q', function(){
                let quiz_btn = $(this);
                let quiz_con = quiz_btn.parents('.quiz_con').first();
                let quiz_q_con = quiz_con.nextAll('.quiz_q_con').first();
                let quiz_url = quiz_btn.attr('quiz_url');
                if(quiz_q_con !== true){
                
                    quiz_con.after(
                        `
                        <div class="quiz_q_con border bg-white container p-3">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="text-center"> Multiple choice Quiz </h3> 
                                    <p class="text-center font-weight-normal text-info"> Create a multiple choice quiz by adding question and choosing it's answer. More, you can also provide the reason of your selected answer for students to
                                        understand the question. 
                                    </p>
                                </div>
                            </div>
                            <div class="row q_b_con">
                                <div class="col-12">
                                    <div class="alert alert-danger d-none err_msg text-center"> </div>
                                    <div class="btn btn-lg btn-info float-right create_quiz" quiz_url="${quiz_url}"> <i class="las la-pencil-alt"></i> Create Quiz </div>                            
                                </div>
                            </div>
                        </div>
                         `
                    );

                    quiz_btn.removeClass('website-outline quiz_q').addClass('btn-danger quiz_q_cancel').html('<i class="las la-times"></i>Quiz');
                }
                    
            });

            $('.sec-container').on( 'click', '.quiz_q_cancel', function(){
                let quiz_btn = $(this);
                let quiz_con = quiz_btn.parents('.quiz_con').first();
                let quiz_q_con = quiz_con.nextAll('.quiz_q_con').first();
                quiz_q_con.addClass('d-none');
                quiz_btn.addClass('website-outline quiz_q_show').removeClass('btn-danger quiz_q_cancel').html('<i class="las la-caret-down"></i>Quiz');


            });

            $('.sec-container').on( 'click', '.quiz_q_show', function(){
                let quiz_btn = $(this);
                let quiz_con = quiz_btn.parents('.quiz_con').first();
                let quiz_q_con = quiz_con.nextAll('.quiz_q_con').first();
                quiz_q_con.removeClass('d-none');
                quiz_btn.removeClass('website-outline quiz_q_show').addClass('btn-danger quiz_q_cancel').html('<i class="las la-times"></i>Quiz');

                let quiz_c_op= quiz_con.find('.quiz_c_op');
                if(quiz_c_op){
                    quiz_c_op.click();
                }

            });


            $('.sec-container').on( 'click', '.create_quiz', function(){
                let c_q_btn = $(this);
                let btn_con = c_q_btn.parents('.q_b_con').first();
                let quiz_form_available = btn_con.nextAll('.quiz_form').first();
                
                let quiz_url = c_q_btn.attr('quiz_url');
                if(quiz_url && quiz_form_available.length === 0){
                    btn_con.after(`
                    <form quiz_url="${quiz_url}" class="quiz_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="close_q_form text-danger cursor_pointer float-right icon-sm" > <i class="las la-trash-alt"></i> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" id="question" name="question" placeholder="Question">
                        </div>
                        <label>Answers</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ans" id="a1" value="a1">
                                <input type="text" class="form-control" id="ans1" name="ans1" placeholder="Answer">
                            </div>


                            <div class="form-check mt-3">
                                <input class="form-check-input" type="radio" name="ans" id="a2" value="a2">
                                <input type="text" class="form-control" id="ans2" name="ans2" placeholder="Answer">
                            </div>
                                

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="radio" name="ans" id="a3" value="a3">
                                <input type="text" class="form-control" id="ans3" name="ans3" placeholder="Answer">
                            </div>
                                
                            <div class="form-check  mt-3">
                                <input class="form-check-input" type="radio" name="ans" id="a4" value="a4">
                                <input type="text" class="form-control" id="ans4" name="ans4" placeholder="Answer">
                            </div>




                        <div class="form-group mt-3">
                            <label for="reason_ans">Reason for the answer</label>
                            <input type="text" class="form-control" id="reason_ans" name="reason_ans" placeholder="Reason for choosing the right answer">
                        </div>

                        <button type="submit" class="btn btn-info"> <i class="las la-plus"></i> Add </button>

                    </form>
                `);
                }
            });

            
            $('.sec-container').on( 'submit', '.quiz_form', function(e){
                    e.preventDefault();
                    let quiz_f = $(this);
                    let url = quiz_f.attr('quiz_url');
                    let form_data = quiz_f.serializeArray();
                    let quiz_con = quiz_f.parents('.quiz_q_con').first();
                    let err = quiz_con.find('.err_msg');
                    if(url){
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: form_data,
                            dataType: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) { 
                                let quiz = data['quiz'];
                                quiz_con.append(`
                                    <div class="border bg-white container p-3 quiz-q-list mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="q-no">  ${quiz.count_quizzes}  </div>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="q-name"> ${reduceTextLen(quiz.question)} </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="col-md-6 d-flex">
                                                <div class="edit_quiz text-info" quiz_edit_url="${data['edit_url']}" > <i class="las la-pencil-alt"></i> </div>
                                                <div class="del_quiz ml-3 text-danger" quiz_del_url="${data['delete_url']}" > <i class="las la-trash-alt"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                                quiz_f.remove();
                                alert(data['status']);

                            },
                            error: function(data){
                                let errs = JSON.parse(data.responseText).errors;
                                err.removeClass('d-none');
                               let ques = errs['question'];
                               let ans1 = errs['ans1'];
                               let ans2 = errs['ans2'];
                               let ans3 = errs['ans3'];
                               let ans4 = errs['ans4'];
                               let ans = errs['ans'];
                               let reason_ans = errs['reason_ans'];

                               if(ques){
                                   err.html(ques[0]);
                               }else
                               if(ans1){
                                   err.html(ans1[0]);
                               }else 
                               if(ans2){
                                   err.html(ans2[0]);
                               }else 
                               if(ans3){
                                   err.html(ans3[0]);
                               }else 
                               if(ans4){
                                   err.html(ans4[0]);
                               }else 
                               if(ans){
                                   err.html(ans[0]);
                               }
                               else if(reason_ans){
                                   err.html(reason_ans[0]);
                               }
                                setInterval(function(){
                                    err.addClass('d-none');
                                    err.text();
                                },10000);


                                
                            }
                        }); 
                    
                    }

            });

            
            $('.sec-container').on( 'click', '.edit_quiz', function(e){
                let cu_el = $(this);
                let url = cu_el.attr('quiz_edit_url');
                if(url){
                    $.ajax({
                            url: url,
                            type: 'post',
                            dataType: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) { 
                                let quizzes = data['quizzes'];
                                let q_b_con = cu_el.parents('.quiz-q-list').first().prevAll('.q_b_con').first();
                                let update_quizzes = q_b_con.nextAll('.quiz_edit_form').first();
                                if(update_quizzes.length > 0){
                                    update_quizzes.remove();
                                }
                                q_b_con.after(`
                                    <form quiz_url="${data['update_quizzes']}" class="quiz_edit_form">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="close_q_form text-danger cursor_pointer float-right icon-sm" > <i class="las la-trash-alt"></i> </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="question">Question</label>
                                            <input type="text" class="form-control" value="${quizzes['question']}" id="question" name="question"
                                            placeholder="Question">
                                        </div>
                                        <label>Answers</label>

                                            <div class="form-check">
                                                
                                                <input class="form-check-input" type="radio" name="ans" id="a1" value="a1" >
                                                <input type="text" class="form-control" value="${quizzes['ans1']}" id="ans1" name="ans1" placeholder="Answer">
                                            </div>

                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="radio" name="ans" id="a2" value="a2" >
                                                <input type="text" class="form-control" id="ans2" name="ans2" value="${quizzes['ans2']}" placeholder="Answer">
                                            </div>
                                                

                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="radio" name="ans" id="a3" value="a3" >
                                                <input type="text" class="form-control" id="ans3" name="ans3" placeholder="Answer" value="${quizzes['ans3']}">
                                            </div>
                                                
                                            <div class="form-check  mt-3">
                                                <input class="form-check-input" type="radio" name="ans" id="a4" value="a4" >
                                                <input type="text" class="form-control" id="ans4" name="ans4" placeholder="Answer" value="${quizzes['ans4']}">
                                            </div>

                                        <div class="form-group mt-3">
                                            <label for="reason_ans">Reason for the answer</label>
                                            <input type="text" class="form-control" id="reason_ans" name="reason_ans" placeholder="Reason for choosing the right answer" 
                                            value="${quizzes['reason_ans'] ?? ''}  "
                                            >
                                        </div>

                                        <button type="submit" class="btn btn-info"> <i class="las la-plus"></i> Add </button>

                                    </form>
                                
                                `);
                                


                            }
                        });
                }
                
            });

            $('.sec-container').on( 'submit', '.quiz_edit_form', function(e){
                    e.preventDefault();
                    let quiz_f = $(this);
                    let url = quiz_f.attr('quiz_url');
                    let form_data = quiz_f.serializeArray();
                    let quiz_con = quiz_f.parents('.quiz_q_con').first();
                    let err = quiz_con.find('.err_msg');
                    if(url){
                        $.ajax({
                            url: url,
                            type: 'put',
                            data: form_data,
                            dataType: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) { 
                                let quiz = data['quiz'];
                                quiz_con.find('.q-name').first().text(data['quiz_title']);
                                alert(data['status']);
                                
                            },
                            error: function(data){
                                let errs = JSON.parse(data.responseText).errors;
                                err.removeClass('d-none');
                               let ques = errs['question'];
                               let ans1 = errs['ans1'];
                               let ans2 = errs['ans2'];
                               let ans3 = errs['ans3'];
                               let ans4 = errs['ans4'];
                               let ans = errs['ans'];
                               let reason_ans = errs['reason_ans'];

                               if(ques){
                                   err.html(ques[0]);
                               }else
                               if(ans1){
                                   err.html(ans1[0]);
                               }else 
                               if(ans2){
                                   err.html(ans2[0]);
                               }else 
                               if(ans3){
                                   err.html(ans3[0]);
                               }else 
                               if(ans4){
                                   err.html(ans4[0]);
                               }else 
                               if(ans){
                                   err.html(ans[0]);
                               }
                               else if(reason_ans){
                                   err.html(reason_ans[0]);
                               }
                                setInterval(function(){
                                    err.addClass('d-none');
                                    err.text();
                                },10000);


                                
                            }
                        }); 
                    
                    }

            });

            $('.sec-container').on( 'click', '.close_q_form', function(){
                if(confirm('Do you want to close the form?')){
                    $(this).parents('.quiz_edit_form, .quiz_form').first().remove();

                }

            });

             
            $('.sec-container').on( 'click', '.del_quiz', function(){
                if(confirm('Do you want to delete this quiz?')){
                    let c_el = $(this);
                        let url = $(this).attr('quiz_del_url');
                        $.ajax({
                            url: url,
                            dataType: 'JSON',
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {  
                                    alert(data['status']);
                                    c_el.parents('.quiz-q-list').first().remove();

                            }
                        })
                }

            });

            $('.sec-container').on( 'keypress', '.article_text', function(){
                let char_counter = $(this).parent().find('.char-counter').first();
                let val = parseInt(char_counter.text());
                if(val >0){
                    val-=1;
                    char_counter.text(val.toString());
                }


            });
            $('.sec-container').on( 'keyup', '.article_text', function(e){
                if(e.keyCode == 8 || e.keyCode == 46){
                    let char_counter = $(this).parent().find('.char-counter').first();
                    if(!$(this).val()){
                        char_counter.text('1500');
                    }else{
                    let val = parseInt(char_counter.text());
                    if(val < 1500){
                        val+=1;
                        char_counter.text(val.toString());
                    }
                }
                }
            });
           
            $('.sec-container').on('paste', '.article_text', function(){                    
                    
                let char_counter = $(this).parent().find('.char-counter').first();
                let c_chars = $(this).val().length;   
                if(c_chars <= 1500){                        
                    char_counter.text((1500 - c_chars).toString());
                }else{
                    char_counter.text('0');
                }
            });
            $('.sec-container').on('cut', '.article_text', function(e){                    
                let char_counter = $(this).parent().find('.char-counter').first();
                let c_chars = $(this).val().length;  
                    if(c_chars <= 1500){                   
                    char_counter.text((1500-c_chars).toString());
                }                   
            });

            $('.sec-container').on('change', '.article_text', function(){     
                let char_counter = $(this).parent().find('.char-counter').first();                                        
                if(!$(this).val()){                        
                    char_counter.text('1500');
                }
            });

            $('#upload_bulk_videos').change(function(){
                var files = this.files;                
                var v_size = 0;
                var form = $(this).parents('form').first();
                var formData = new FormData();
                var up_err = false;
                for (var index=0;index<files.length;index++) {                   
                    var file = files[index];
                    if(file){
                        var file_type = file.type;
                        if(file_type){
                            if(file_type !== "video/mp4" && file_type !== "video/webm" && file_type !== "video/ogg" ){
                               up_err = true;
                                break; 
                            }
                            else{
                            var s = file.size / 1024 / 1024 /1024;

                            v_size += s;
                           
                        }
                    }
                    formData.append('upload_b_vid[]',file);
                }                  
                }
                if(up_err){
                    alert('Only MP4,webm and ogg files are allowed. Please choose one of them');
                }else if(v_size >  4){
                    alert('Total size allowed is 4GB');
                }else{
                    var progress_bar = $(this).parents('form').first().find('#show_progress');
                    var p_parent = progress_bar.parent();
                    p_parent.removeClass('d-none');
                    let form = $('#upload_bulk_videos');
                    form.prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url: "{{route('bulk_loader',['course' => $course_id])}}",
                        data:formData,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {                                    
                                        var percentComplete = evt.loaded / evt.total; 
                                        let c_progress = Math.round(percentComplete * 100); 
                                        progress_bar.attr('aria-valuenow',c_progress);
                                        progress_bar.css('width',c_progress+'%');
                                        progress_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                    }
                                }, false);
                                return xhr;
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        cache:false,
                        contentType: false,
                        processData: false,

                        success:function(data){
                            progress_bar.attr('aria-valuenow',0);
                            progress_bar.css('width',0+'%');
                            progress_bar.html('<b> Uploading  ' + 0 + '% </b>');
                            p_parent.addClass('d-none');
                            form.prop('disabled',false);

                            alert(data);
                        },

                        error: function(data){
                            progress_bar.attr('aria-valuenow',0);
                            progress_bar.css('width',0+'%');
                            progress_bar.html('<b> Uploading  ' + 0 + '% </b>');
                            p_parent.addClass('d-none');
                            form.prop('disabled',false);
                           alert('Only MP4,webm and ogg files are allowed. Please choose one of them');
                                                        
                        }
                    });    
                }
                       
            });

            $("#close").click(function(){
                if(confirm('Close the window will just hide the uploading process and you can easily show it by clicking the bulk uploader button')){
                    $('#bulk').modal('hide');
                }
            });

            $('.sec-container').on('click', '.vid_upload_op', function(){     
                let con = $(this).parents('.upload_video_con').first();
                console.log(con);
            });


            setTimeout(function(){ $('.alert').fadeOut() }, 5000);

        });

        function cancel(event){
            
            let current_elem = $( event.target );
            let prev_val = current_elem.attr('prev_val');
            let parent_form  = $(current_elem.parents('form'))
            if( parent_form!== 'undefined'){
                parent_form.replaceWith(`<div class="sec_title ml-md-2">
                   ${prev_val}
                    <span class="sec_title_edit ml-2" >
                        <i class="las la-pen"></i>
                    </span>
            </div>`);
            }else{
                console.error('could not find form element')
            }
        }
        function cancel_title(event){
            
            let current_elem = $( event.target );            
            let parent_form  = $(current_elem.parents('form'))
            if( parent_form!== 'undefined'){
                parent_form.replaceWith(`<div class="btn website add_title">
                    <i class="las la-plus"></i>
                    Add Title
                </div>`);
            }else{
                console.error('could not find form element')
            }
        }

        function reduceTextLen(input_txt,limit=50){
            if(input_txt.length > limit){
                return input_txt.substr(0,limit) + "...";
            }
            return input_txt;
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script>
        $(function(){
                $('#add_sec, .add_material').tooltip();
                $('body').addClass('min-vh-100 d-flex flex-column');
                $('.footer').addClass('mt-auto');
            });
    </script>
    {{-- <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script> --}}

@endsection
