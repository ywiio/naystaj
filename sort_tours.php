<?php
include 'db_conn.php';
$sortType = $_POST['sortType'];

$sql ="SELECT * FROM tours
        INNER JOIN duration WHERE duration_fk=duration_id";

if ($sortType == 'desc') {
    $sql .= " ORDER BY price DESC";
} elseif ($sortType == 'asc') {
    $sql .= " ORDER BY price ASC";
}

$tours = $conn->query($sql);

foreach ($tours as $tour) {
    echo '<div class="home__tours-cards card">';
    echo '  <a href="tour.php?tourID=' . $tour['id'] . '">';
    echo '      <img src="' . $tour['hero_img'] . '" alt="' . $tour['name'] . '">';
    echo '      <div class="info-block">';
    echo '          <h4>' . $tour['name'] . '</h4>';
    echo '          <p class="overview">' . $tour['overview'] . '</p>';
    echo '          <div class="info">';
    echo '              <div>';
    echo '                  <p>' . $tour['time'] . '</p>';
    echo '                  <p class="price">' . $tour['price'] . ' BYN</p>';
    echo '              </div>';
    echo '              <button onclick="openPopup()">Заказать</button>';
    echo '          </div>';
    echo '      </div>';
    echo '  </a>';
    echo '</div>';
}