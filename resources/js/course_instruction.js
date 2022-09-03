$(".p1").click(function() {
    $('.p1').addClass("text-primary");
    $('.p2').removeClass("text-primary border border-primary");
    $('.next').attr('disabled', false);
    $('#course').attr('value','course');
    $('#practice').attr('value','');

});

$(".p2").click(function() {
    $('.p2').addClass("text-primary");
    $('.p1').removeClass("text-primary border border-primary");
    $('.next').attr('disabled', false);
    $('#practice').attr('value','practice');
    $('#course').attr('value','');
});

$("#nextbtn").prop('disabled', true); 