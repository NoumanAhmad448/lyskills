window.show_popup = function (message) {
    $("#modal-body").html(message)
    $("#pop-message").modal({
    keyboard: true,
    focus: true,
    show: true
    })
}

window.show_message = function(text="your message",title="Info",icon="info",button="ok"){
    swal({
      title: title,
      text: text,
      icon: icon,
      button: button,
    })
}

window.popup_message = function(d){
    if(debug){
        console.error(d)
        console.error(typeof d)
    }
    if(Array.isArray(d)){
        show_message(text=d[0])
    }
    else if (typeof d === "object"){
        show_message(text=err_msg)
    }
    else if(typeof d === "json"){
        var d = JSON.parse(d.responseText).errors;

        if(typeof d == "string"){
              show_message(text=d)
        }else if(Array.isArray(d) && d.length > 1){
            show_message(text=d[0])
        }

    }else if(typeof d === "string"){
        show_message(text=d)
    }
}