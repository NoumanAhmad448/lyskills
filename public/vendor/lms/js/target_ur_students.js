$(document).ready(function() {
    $("#learnable_skills_btn").click(function() {
        let learnable_skills_err = $("#learnable_skills_err");
        let learnable_skills_sec = $('#learnable_skills_sec input');
        let existed_elem = Boolean(learnable_skills_sec.length);
        if (existed_elem) {
            if (learnable_skills_sec.last().val() !== "") {
                let last_elem = $('#learnable_skills_sec input').last();


                $("#learnable_skills_sec").append(
                    ' <div class="input-group input-group-lg my-2" >' +
                    '<input type="text"'  +
                    'class="form-control learnable_skills"' +
                    'placeholder="example: about the design of wordpress" >' +
                    '<span class="input-group-text btn btn-danger"  onclick="removeParent(event)" ><i class="las la-trash-alt"></i></span>' +
                    '<span class="input-group-text"  > <i class="las la-arrows-alt"></i></span>' +

                    '</div>');

                learnable_skills_err.removeClass('d-block').addClass('d-none').text('');

            } else {
                learnable_skills_err.removeClass('d-none').addClass('d-block').text(
                    "please fill up the first requirement before");
            }
        } else {
            $("#learnable_skills_sec").append(' <div class="input-group input-group-lg mt-2" >' +
                '<input type="text" class="form-control learnable_skills"' +
                'placeholder="example: about the design of wordpress" >' +
                '<span class="input-group-text btn btn-danger"  onclick="removeParent(event)" ><i class="las la-trash-alt"></i></span>' +
                '<span class="input-group-text"  > <i class="las la-arrows-alt"></i></span>' +
                '</div>');

            learnable_skills_err.removeClass('d-block').addClass('d-none').text('');
        }

    });

    $("#course_requirement_btn").click(function() {
        // show_message('working');
        let course_requirement_err = $("#course_requirement_err");
        let course_requirement_sec = $('#course_requirement_sec input');
        let existed_elem = Boolean(course_requirement_sec.length);
        if (existed_elem) {
            if (course_requirement_sec.last().val() !== "") {
                let last_elem = course_requirement_sec.last();


                $("#course_requirement_sec").append(
                    ' <div class="input-group input-group-lg mt-2" >' +
                    '<input type="text"  class="form-control course_requirement"' +
                    'placeholder="example: wordpress designing must be experienced before a bit" >' +
                    '<span class="input-group-text btn btn-danger"  onclick="removeParent(event)" ><i class="las la-trash-alt"></i></span>' +
                    '<span class="input-group-text"  > <i class="las la-arrows-alt"></i></span>' +
                    '</div>');

                course_requirement_err.removeClass('d-block').addClass('d-none').text('');

            } else {
                course_requirement_err.removeClass('d-none').addClass('d-block').text(
                    "please fill up the first requirement before");
            }
        } else {
            $("#course_requirement_sec").append(' <div class="input-group input-group-lg mt-2" >' +
                '<input type="text"  class="form-control course_requirement"' +
                'placeholder="example: wordpress designing must be experienced before a bit" >' +
                '<span class="input-group-text btn btn-danger"  onclick="removeParent(event)" ><i class="las la-trash-alt"></i></span>' +
                '<span class="input-group-text"  > <i class="las la-arrows-alt"></i></span>' +
                '</div>');

            course_requirement_err.removeClass('d-block').addClass('d-none').text('');
        }

    });

    $("#targeting_students_btn").click(function() {
        // show_message('working');
        let targeting_students_err = $("#targeting_students_err");
        let targeting_students_sec = $('#targeting_students_sec input');
        let existed_elem = Boolean(targeting_students_sec.length);
        if (existed_elem) {
            if ($('#targeting_students_sec input').last().val() !== "") {
                let last_elem = $('#targeting_students_sec input').last();
                

                $("#targeting_students_sec").append(
                    ' <div class="input-group input-group-lg mt-2" >' +
                    '<input type="text" class="form-control targeting_students"' +
                    'placeholder="Example: Beginner Python developers curious about data science" >' +
                    '<span class="input-group-text btn btn-danger"  onclick="removeParent(event)" ><i class="las la-trash-alt"></i></span>' +
                    '<span class="input-group-text"  > <i class="las la-arrows-alt"></i></span>' +

                    '</div>');

                targeting_students_err.removeClass('d-block').addClass('d-none').text('');

            } else {
                targeting_students_err.removeClass('d-none').addClass('d-block').text(
                    "please fill up the first field before");
            }
        } else {
            $("#targeting_students_sec").append(' <div class="input-group input-group-lg mt-2" >' +
                '<input type="text"  class="form-control targeting_students"' +
                'placeholder="Example: Beginner Python developers curious about data science" >' +
                '<span class="input-group-text btn btn-danger"  onclick="removeParent(event)" ><i class="las la-trash-alt"></i></span>' +
                '<span class="input-group-text"  > <i class="las la-arrows-alt"></i></span>' +
                '</div>');

            targeting_students_err.removeClass('d-block').addClass('d-none').text('');
        }

    });

    $( ".learnable_skills, .course_requirement , .targeting_students" ).keypress(function() {
        $('#save_btn,.save_btn').removeAttr('disabled');
    });

    if($('.learnable_skills').first().val() !== '' || $('.course_requirement').first().val() !== '' || $('.targeting_students').first().val() !== ''){
        $('#save_btn, .save_btn').removeAttr('disabled');

    }

    $('#target_students').removeClass('text-info').addClass('bg-website text-white');

    $('#learnable_skills_sec').sortable({
        revert: true
    });

    $('#course_requirement_sec').sortable({
        revert: true
    });

    $('#targeting_students_sec').sortable({
        revert: true
    });
});

 