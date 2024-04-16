<?php
include "db_conn.php";

$sql = "SELECT * FROM tours INNER JOIN duration WHERE duration_fk=duration_id";

if (!empty($_POST['category'])) {
    $category = "category_fk IN (" . implode(', ', $_POST['category']) . ")";
    $sql .= " AND $category";
}
if (!empty($_POST['duration'])) {
    $duration = "duration_fk IN (" . implode(', ', $_POST['duration']) . ")";
    $sql .= " AND $duration";
}
if (!empty($_POST['location'])) {
    $location = "location_fk IN (" . implode(', ', $_POST['location']) . ")";
    $sql .= " AND $location";
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
