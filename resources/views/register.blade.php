<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>User Registration</title>
</head>
<body>

<h1>User register</h1>

<form id="register_id">
    <input type="text" name="name" placeholder="Name"><br>
    <input type="text" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="password" name="password_confirmation" placeholder="Password confirmation"><br>
    <button type="submit">Register</button>
</form>

<script>
    $(document).ready(function () {
        $('#register_id').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:8000/api/register",
                data: $(this).serialize(),
                success: function (data) {
                    if (data.message) {
                        alert(data.message);
                    } else if (data.errors) {
                        // If there are validation errors, display them
                        alert("Registration failed. Please check the form for errors.");
                        console.log(data.errors);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error: ' + error);
                }
            });
        });
    });
</script>

</body>
</html>
