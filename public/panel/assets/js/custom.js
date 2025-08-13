function jsonMessage4(message, status = 'success') {
  const icon = '<i class="fa fa-bell-o"></i>';
  const formattedStatus = status.toUpperCase();

  const isError = status === 'error';

  const labelBadge = `
        <span style="
            display: inline-block;
            background-color: ${isError ? '#fff' : '#7366ff'};
            color: ${isError ? '#dc3545' : '#fff'};
            padding: 2px 6px;
            font-size: 12px;
            border-radius: 4px;
            font-weight: bold;
            margin-right: 4px;
        ">${formattedStatus}:</span>`;

  const boxStyle = isError ? 'background-color: #dc3545; color: #fff;' : '';

  const messageHtml = `
        <div style="${boxStyle}">
            ${icon} ${labelBadge} ${message}
        </div>`;

  const notify = $.notify(messageHtml, {
    type: 'theme',
    allow_dismiss: true,
    delay: 2000,
    showProgressbar: true,
    timer: 300,
    animate: {
      enter: 'animated fadeInDown',
      exit: 'animated fadeOutUp'
    }
  });

  setTimeout(function () {
    const doneHtml = `
            <div style="${boxStyle}">
                ${icon} ${labelBadge} Processing done.
            </div>`;
    notify.update('message', doneHtml);
  }, 1000);
}




function jsonMessage(response, message, title = "") {
  var text = message;
  if (title == "") {
    title = response;
  }

  swal({
    html: text,
    title: title,
    text: text,
    type: response,
    confirmButtonText: "close"
  }).catch(swal.noop);

}
function jsonMessage2(response, message, title = "") {
  toastr[response](message, title);
}

$(document).on({
  ajaxStart: function () {
    $("#preloader1").css("display", "block")
    $("#status1").css("display", "block")

  },
  ajaxStop: function () {
    $("#preloader1").css("display", "none")
    $("#status1").css("display", "none")
  }
})


function isJSON(str) {

  if (!isNaN(str)) return false;

  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

function printErrorMsg(msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display', 'block');
  $.each(msg, function (key, value) {
    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
  });
}

function printErrorMsg1(msg) {
  $(".print-error-msg1").find("ul").html('');
  $(".print-error-msg1").css('display', 'block');
  $.each(msg, function (key, value) {
    $(".print-error-msg1").find("ul").append('<li>' + value + '</li>');
  });
}

function saveOrder() {
  var list = new Array();
  $('#sortable').find('.ui-state-default').each(function () {
    var id = $(this).attr('data-id');
    list.push(id);
  });
  var post_list_value = list.join(',');

  $("#sequence_ingredents").val(post_list_value);


}


function verifyEmail(verificationDesc, email, url) {
  var text = verificationDesc + "<br><br>" + "<b style='font-weight: bold !important;'>" + email + "</b>";
  text += "<br><hr>";
  text += "<a href='" + url + "' class='btn btn-warning' style='width: 100%;' > Resend Mail </a>";

  swal({
    html: true,
    title: "Please Verify Your Email Address",
    text: text,
    type: "warning",
    confirmButtonText: "close"
  });

}

