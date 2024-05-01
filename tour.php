<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <link rel="stylesheet" href="/css/sort.css" type="text/css">
    <title>НАЎСЦЯЖ</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php
    require "header.php";
    include "db_conn.php";
    ?>
    <main class='home'>
        <?php
        $sql = "SELECT * FROM tours
                    INNER JOIN duration WHERE duration_fk=duration_id";
        $tours = $conn->query($sql);

        foreach ($tours as $tour) {
            echo '<div class="tour-card">';
            echo '<img src="' . $tour['hero_img'] . '" alt="' . $tour['name'] . '">';
            echo '<h4>' . $tour['name'] . '</h4>';
            echo '<p class="overview">' . $tour['overview'] . '</p>';
            echo '<div class="info">';
            echo '<div>';
            echo '<p>' . $tour['time'] . '</p>';
            echo '<p class="price">' . $tour['price'] . ' BYN</p>';
            echo '</div>';
            echo '<button onclick="openPopup()">Заказать</button>';
            echo '</div>';
            echo '</div>';
        }
        ?>
        <img src="" alt="">
    </main>
    <?php require 'footer.php' ?>

</body>

</html>