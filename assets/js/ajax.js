$(document).ready(function () {

    $('.savepass').submit(function(event){
        event.preventDefault();

        //header for all ajax form submission
        setHeader();

        //assign vars to form input values
        var password = $('input[name="password"]').val();
        var con_password = $('input[name="con-password"]').val();
        var statusMsg, msg_class;

        if(password !== con_password){ //if password and confirm mismatch

            statusMsg = 'Passwords do not match';
            msg_class = 'err-msg';

        }

        else if(password.length < 6){// password too short

            statusMsg = 'Password should be at least 6 xters';
            msg_class = 'err-msg';
        }

        else{// send to controller if no error occurs

            $('.savepass').hide();
            //show loading animation
            $('.loading-gif').show();

            $.ajax({
                type: 'POST',
                url: 'savepass',
                data: {
                    'password': password,
                    'con_pass': con_password},
                success: function(response){

                    $('.loading-gif').hide();
                    var success = response['success'];
                    var msg = response['msg'];

                    if(success){// if server side update succeeds

                        statusMsg = 'Password changed successfully... you\'ll now be logged out';
                        msg_class = 'sxs-msg';

                        $('#modal-msg').html(statusMsg).addClass(msg_class).show();

                        $('#logout-form').submit();

                    }
                    else{// if server side error occurs

                        statusMsg = msg;
                        msg_class = 'err-msg';
                        $('.savepass').show();
                    }
                    //console.log(response);
                }
            });
        }

        // show message for operations
        $('#pswd-modal-msg').html(statusMsg).addClass(msg_class).show();
    });

})