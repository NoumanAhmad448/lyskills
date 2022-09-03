$('.categories').change(function() {
    $('.next').attr('disabled', false);
    if ($(this).val() == 0) {
        $('.next').attr('disabled', true);
    }
});