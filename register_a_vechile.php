<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Vechile</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="register_all">
        <div class="register_title">
            <h2>Register a Vechile</h2>
        </div>
        <form method="post" action="" enctype="multipart/form-data">

            <div class="forms">
                <label>Vechile Registration Date:</label>
                <input type="date" name="vechile_registration_date" required>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Middle Name:</label>
                    <input type="text" name="middle_name">
                </div>

                <div class="forms">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" required>
                </div>
            </div>
        </form>
    </div>
</body>

</html>