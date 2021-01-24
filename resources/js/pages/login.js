$('#login-form').submit(function (e) {

    e.preventDefault();

    const formData = getFormAsJsonData('#login-form')
    const actionUrl = $(this).attr('action')

   
    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: formData,
        beforeSend: function () {
            toggleFullPageLoader(true, 'Login');
        },
        success: function (data, status, xhr) {
         
            $('#login-form')[0].reset();
            $('.alert').removeClass('alert-danger');
            $('#errorMsg').css('display', 'none')
            $('#errorMsg').html('')
            const url = data.data.intended_url;
            redirectTo(url)
            //console.log(data)
        },
        error: function (jqXhr, textStatus, errorMessage) {
            const data = jqXhr.responseJSON;
            const errors = data.errors || data.message || data.data || data;

            if (data.status == 401) {
                redirectTo('../');
            }

            if (typeof errors === "object") {
                Object.keys(data.errors).forEach(function (key) {
                    let selector = $('.alert');
                    selector.remove('alert-success');
                    selector.addClass('alert-danger')
                    selector.css('display', '')
                    selector.html(errors[key][0]);
                    selector.fadeIn();
                });

            } else {
                $('.alert').addClass('alert-danger');
                $('#errorMsg').css('display', '')
                $('#errorMsg').html(errors)
            }
        },
        complete: function () {
            toggleFullPageLoader(false, 'Login');
        }
    })

})