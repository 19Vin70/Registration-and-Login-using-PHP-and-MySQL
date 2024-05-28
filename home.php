<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body>
        <div class="profile-container" id="profile-container">
            <h1 id="user-name">Loading...</h1>
            <img id="user-image" src="" alt="User Image" width="100">
            <p>Name: <span id="user-name-span">Loading...</span></p>
            <p>Email: <span id="user-email">Loading...</span></p>
            <a href="logout.php" class="logout">Logout</a>
        </div>

        <script>
        $(document).ready(function() {
            $.ajax({
                url: 'fetch_user.php',
                method: 'GET',
                cache: false,
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        console.log(data.error);
                    } else {
                        $('#user-name').text(data.name || 'No name available');
                        $('#user-image').attr('src', 'uploads/' + (data.image || 'default.jpeg'));
                        $('#user-name-span').text(data.name || 'No name available');
                        $('#user-email').text(data.email || 'No email available');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('AJAX Error: ' + textStatus + ': ' + errorThrown);
                }
            });
        });
        </script>
    </body>

</html>