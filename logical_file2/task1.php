<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $year = 2013;
    if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
        echo true;
    } else {
        echo false;
    }
    ?>

</body>

</html>