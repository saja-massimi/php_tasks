<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

$originalString = 'The quick brown fox jumps over the lazy dog---';


$newString = rtrim($originalString, '-');
echo $newString;
?>

</body>

</html>