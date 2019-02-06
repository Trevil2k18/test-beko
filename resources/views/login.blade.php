<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Login page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="{{ asset('js/md5.js') }}"></script>
</head>
<body>
<form id="submit-form" title="" method="post" action="{{ '/api/auth/login' }}">
    <div>
        <label class="title">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label class="title">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <input type="submit" id="submitButton" value="Submit">
    </div>
</form>
<script>
    $("#submit-form").submit(function(event) {
        event.preventDefault();

        let $form = $(this),
            url = $form.attr('action'),
            method = $form.attr('method');

        $.ajax({
            url: url,
            method: method,
            data: {
                email: $('#email').val(),
                password: md5($('#password').val())
            },
            success: function(data) {
                alert(data.message);
            },
            error: function (result, status, err) {
                alert(JSON.parse(result.responseText).message);
            }
        });
    });
</script>
</body>
</html>
