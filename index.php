<!-- detib - Detideti1 --> <!-- admin -->
<!-- user - Useruser1 --> <!-- active user -->
<!-- user2 - Useruser2 --> <!-- not active user -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <title>Blog App</title>
</head>
<body>
    <?php include 'inc/navbar.php' ?>
    <h1>Welcome <?php if($user) echo $name; else echo "random"?></h1>
    <?php ?>
    <!-- <?php include 'inc/footer.php' ?> -->
</body>
</html>