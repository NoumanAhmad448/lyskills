window.show_popup = function (message) {
    $("#modal-body").html(message)
    $("#pop-message").modal({
    keyboard: true,
    focus: true,
    show: true
    })
}
