/******/ (() => { // webpackBootstrap
/*!***********************************!*\
  !*** ./resources/js/promotion.js ***!
  \***********************************/
$(function () {
  $('.ct_btn').click(function () {
    var c = $(this);
    var p = c.parents('.create_btn_row').first();
    if (p.nextAll('.c_con').length == 0) {
      p.after("\n                <section class=\"c_con\" >\n                <div class=\"row\">\n                    <div class=\"col-12\">\n                        <div class=\"float-right cursor_pointer text-danger close_form icon-sm mt-3\">\n                            <i class=\"las la-times-circle\"></i>\n                        </div>\n                    </div>\n                </div>\n                <div class=\"form-group\">\n                    <label for=\"coupon_no\">Coupon</label>\n                    <input type=\"text\" class=\"form-control\" id=\"coupon_no\" placeholder=\"Coupon\" name=\"coupon_no\">\n                    <small class=\"form-text text-muted\">write any specific word of your choice and share it with others\n                        to let them access your course at specific cost or totally free.\n                    </small>\n                </div>\n                <div class=\"form-group\">\n                    <div class=\"col-3\">\n                        <label for=\"date_time\">Until Valid Date?</label>\n                        <input type=\"datetime\" class=\"form-control\" id=\"date_time\" name=\"date_time\">\n                    </div>\n                    <div class=\"col-3\">\n                        <label for=\"no_of_coupons\">Allowed Coupons?</label>\n                        <input type=\"number\" class=\"form-control\" id=\"no_of_coupons\" name=\"no_of_coupons\">\n                    </div>\n                    <div class=\"col-3\">\n                        <label for=\"percent\"> Set Percentage %</label>\n                        ".concat(percentage_select, "\n                    </div>\n                </div>\n                <div class=\"err_msg text-danger my-2\"> </div>\n                <button type=\"submit\" class=\"btn btn-info\"> Create </button>\n\n                </section>\n            "));
    }
  });
  $('.coupon').on('click', '.close_form', function () {
    if (confirm('Do you want to close the form?')) {
      $(this).parents('.c_con').remove();
    }
  });
  $('.coupon').submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = $(this).attr('url');
    var c = $(this);
    var c_con = c.find('.c_con');
    var show_e_msg = $('.err_msg');
    var pricing_con = $('.pricing');
    $.ajax({
      url: url,
      type: 'post',
      data: data,
      success: function success(d) {
        pricing_con.append("\n                    <form url=\"".concat(d['edit'], "\" class=\"edit_coupon mt-3\">\n                        <div class=\"container\">\n                        <div class=\"row\">\n                            <div class=\"col-12 col-md-10\">\n                                <div class=\"form-group\">\n                                    <input type=\"text\" class=\"form-control\" id=\"coupon_no\" placeholder=\"Coupon\" name=\"coupon_no\" value=\"").concat(d['coupon'], "\">\n                                </div>\n                            </div>\n                            <div class=\"col-2 col-md-1\">\n                                <div class=\"btn btn-danger del_coupon\" url=\"").concat(d['delete'], "\"> Delete </div>\n                            </div>\n                            <div class=\"ml-3 ml-md-0 col-6 col-md-1\">\n                                <div class=\"submit btn btn-info mr-1\" > Update </div>\n                            </div>\n                        </div>\n                        </div>\n                    </form>\n                "));
        if (!coupon_form) {
          c_con.remove();
        } else {
          show_popup("coupon has been created");
        }
      },
      error: function error(d) {
        var err = JSON.parse(d.responseText).errors;
        var p_err = err['coupon_no'];
        if (p_err) {
          show_e_msg.text(p_err);
        }
        setTimeout(function () {
          show_e_msg.text('');
        }, 10000);
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'JSON'
    });
  });
  $('.pricing').on('submit', '.edit_coupon', function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = $(this).attr('url');
    var c = $(this);
    var c_con = c.find('#coupon_no');
    $.ajax({
      url: url,
      type: 'post',
      data: data,
      success: function success(d) {
        c_con.attr('value', d['coupon']);
        show_message('updated');
      },
      error: function error(d) {
        var err = JSON.parse(d.responseText).errors;
        var p_err = err['coupon_no'];
        if (p_err) {
          show_message(p_err);
        }
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'JSON'
    });
  });
  $('.pricing').on('click', '.del_coupon', function (e) {
    if (confirm('do you want to delete this coupon?')) {
      var url = $(this).attr('url');
      var edit_coupon = $(this).parents('.edit_coupon').first();
      $.ajax({
        url: url,
        type: 'delete',
        success: function success(d) {
          show_message(d['status']);
          edit_coupon.remove();
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'JSON'
      });
    }
  });
  $('#promotion').removeClass('text-info').addClass('bg-website text-white');
  $("#is_free").change(function () {
    if ($("#is_free").is(':checked')) {
      $("#set_free").addClass("d-none").removeClass("d-block");
    } else {
      $("#set_free").addClass("d-block").removeClass('d-none');
    }
  });
  $(".update-coupon").click(function () {
    $("#update-coupon-form").modal({
      keyboard: true,
      focus: true,
      show: true
    });
    $("#modal_coupon_no").val($(this).attr("coupon_no"));
    $("#modal_date_time").val($(this).attr("date_time"));
    if ($(this).attr("is_free") == 1) {
      $("#modal_is_free").prop("checked", true);
    }
    $("#modal_percentage").val($(this).attr("percentage"));
    $("#modal_no_of_coupons").val($(this).attr("no_of_coupons"));
    $("#coupon_id").val($(this).attr("id"));
  });
  $('.coupon_update').submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = $(".coupon").attr('url');
    var c = $(this);
    var c_con = c.find('.c_con');
    var show_e_msg = $('.err_msg_update');
    $.ajax({
      url: url,
      type: 'post',
      data: data,
      success: function success(d) {
        if (!coupon_form) {
          c_con.remove();
        } else {
          $("#update-coupon-form").modal("hide");
          show_popup("coupon has been updated");
        }
      },
      error: function error(d) {
        var err = JSON.parse(d.responseText).errors;
        var p_err = err['coupon_no'];
        if (p_err) {
          show_e_msg.text(p_err);
        }
        setTimeout(function () {
          show_e_msg.text('');
        }, 10000);
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'JSON'
    });
  });
});
/******/ })()
;