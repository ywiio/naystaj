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
            <p>Территория старого парка располагается на окраине города. Здесь кроме уютных аллей и ухоженных полянок есть множество исторических мест и зданий. </p>
            <p>Среди них - тропы, по которым гуляли Янка Купала и Винцент Дунин-Марцинкевич, места сталинских расстрелов, усадьба графа Любанского вместе с местом, где случилось несчастье с его женой Ядвигой Кеневич, штаб по подготовке диверсионных отрядов НКВД, старое имение Прушинских с целым хозяйским двором, научная база исследований под руководством знаменитого ученого Вавилова,места работы нацистского штаба и проведения акции минских подпольщиков и многое другое. В парке можно найти интересные достопримечательности самых разных эпох. Каждый любитель истории и ее увлекательной романтики получит истинное удовольствие от посещения Лошицкого парка!</p>
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
