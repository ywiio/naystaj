<?php
include 'db_conn.php';
$tourId = $_POST['tourId'];

$sql = "SELECT * FROM tours
        INNER JOIN duration ON duration_fk=duration_id WHERE id='$tourId'";

$tours = $conn->query($sql);

foreach ($tours as $tour) {
?>
    <div class="popup__info">
        <h2><?= $tour['name'] ?></h2>
        <img src="/img/close_icon.png" alt="close" onclick="closePopup()">
    </div>
    <div class="popup__content">
        <img src=<?= $tour['hero_img'] ?> alt="">
        <div class="popup__content-text">
            <h3>Что вас ожидает?</h3>
            <p><?= $tour['overview2'] ?></p>
            <div class="popup__content-text-price">
                <div class="info">
                    <p><?= $tour['time'] ?></p>
                    <p><?= $tour['price'] ?> BYN</p>
                </div>
                <button><a href="#">Подробнее</a></button>
            </div>
            <button onclick="openPopup(<?= $tour['id'] ?>)">Заказать</button>
        </div>
    </div>
<?php
}
