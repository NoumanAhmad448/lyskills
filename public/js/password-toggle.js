$(document).ready(function(){
    var showPassword = (pass, icon) => {
        if(pass.attr('type') === "password"){
            pass.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            pass.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }

    // For main password
    $('#show_pass').click(function(){
        showPassword($('#password'), $(this).find('i'));
    });

    // For confirm password (only used in register page)
    $('#show_confirm_pass').click(function(){
        showPassword($('#password-confirm'), $(this).find('i'));
    });
}); 