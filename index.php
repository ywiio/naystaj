<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <link rel="stylesheet" href="/css/sort.css" type="text/css">
    <link rel="stylesheet" href="/css/mediaStyle.css" type="text/css">
    <title>НАЎСЦЯЖ</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php
    require "header.php";
    include "db_conn.php";
    ?>
    <main class='home'>
        <div class="home__hero">
            <div>
                <h1>Знакомьтесь с местом, <br>где природа <br>сплетается с культурой</h1>
                <p>Ощутите уникальную красоту и богатую культуру <br>Беларуси с нашими турами</p>
                <button onclick="scrollToTours()">Посмотреть туры</button>
            </div>

        </div>
        <div class="home__adv">
            <h2>Почему мы?</h2>
            <div class="home__adv-cards">
                <div class="home__adv-cards-card">
                    <img src="/img/calendar_icon.svg" alt="calendar">
                    <div>
                        <h3>15+</h3>
                        <p>Лет опыта</p>
                    </div>
                </div>
                <div class="home__adv-cards-card">
                    <img src="/img/chart_icon.svg" alt="chart">
                    <div>
                        <h3>15k</h3>
                        <p>Счастливых<br>клиентов</p>
                    </div>
                </div>
                <div class="home__adv-cards-card">
                    <img src="/img/diff_icon.svg" alt="difference">
                    <div>
                        <h3>>23</h3>
                        <p>Программ</p>
                    </div>
                </div>
                <div class="home__adv-cards-card">
                    <img src="/img/person_icon.svg" alt="person">
                    <div>
                        <h3>100%</h3>
                        <p>Безопасность</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="home__select">
            <h2>Наши туры</h2>
            <div class="sort-dropdown">
                <div class="sort-btn">Сортировка</div>
                <div class="sort-options">
                    <a href="#" class="sort-option" data-sort="desc">По убыванию</a>
                    <a href="#" class="sort-option" data-sort="asc">По возрастанию</a>
                    <a href="#" class="sort-option" data-sort="default">По умолчанию</a>
                </div>
            </div>
        </div>
        <div class="home__tours">
            <div class="home__tours-filter">
                <div class="home__tours-filter-block">
                    <div class="home__tours-filter-block-title" onclick="toggleFilter('category')">
                        <h5>Тематика:</h5>
                        <img src="/img/arr-filter_icon.svg" alt="arrow">
                    </div>
                    <div id="categoryList" class="home__tours-filter-block-list">
                        <?php
                        $sql = "SELECT * FROM category";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<label><input type='checkbox' id=" . $row["category_id"] . " onclick='updateTours()'>" . $row["category"] . "</label>";
                        }
                        ?>
                    </div>
                </div>
                <div class="home__tours-filter-block">
                    <div class="home__tours-filter-block-title" onclick="toggleFilter('duration')">
                        <h5>Продолжительность:</h5>
                        <img src="/img/arr-filter_icon.svg" alt="arrow">
                    </div>
                    <div id="durationList" class="home__tours-filter-block-list">
                        <?php
                        $sql = "SELECT * FROM duration";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<label><input type='checkbox' id=" . $row["duration_id"] . " onclick='updateTours()'>" . $row["time"] . "</label>";
                        }
                        ?>
                    </div>
                </div>
                <div class="home__tours-filter-block">
                    <div class="home__tours-filter-block-title" onclick="toggleFilter('location')">
                        <h5>Локация:</h5>
                        <img src="/img/arr-filter_icon.svg" alt="arrow">
                    </div>
                    <div id="locationList" class="home__tours-filter-block-list">
                        <?php
                        $sql = "SELECT * FROM location";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<label><input type='checkbox' id=" . $row["location_id"] . " onclick='updateTours()'>" . $row["location"] . "</label>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="home__tours-cards">
                <?php
                $sql = "SELECT * FROM tours
                        INNER JOIN duration WHERE duration_fk=duration_id";
                $tours = $conn->query($sql);

                foreach ($tours as $tour) {
                    echo '<div class="home__tours-cards card" onclick="openTourPopup(' . $tour['id'] . ')">';
                    echo '    <img src="' . $tour['hero_img'] . '" alt="' . $tour['name'] . '" >';
                    echo '    <div class="info-block">';
                    echo '          <h4>' . $tour['name'] . '</h4>';
                    echo '          <p class="overview">' . $tour['overview'] . '</p>';
                    echo '          <div class="info">';
                    echo '              <div>';
                    echo '                  <p>' . $tour['time'] . '</p>';
                    echo '                <p class="price">' . $tour['price'] . ' BYN</p>';
                    echo '            </div>';
                    echo '            <button id="btn" onclick="openPopup(' . $tour['id'] . '); event.stopPropagation();">Заказать</button>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="popup" id="popup" style="display: none;">
                <div class="popup__info">
                    <h2>Оформить экскурсию</h2>
                    <img src="/img/close_icon.png" alt="close" onclick="closePopup()">
                </div>
                <form id="excursionForm" class="popup__form" action="booking.php" method="post">
                    <div class="personalData">
                        <h3>Контактные данные</h3>

                        <label for="firstName">Имя*</label>
                        <input type="text" name="firstName" placeholder="Иван" minlength="2" pattern="^([А-Я]{1}[а-яё]{1,23}|[A-Z]{1}[a-z]{1,23})$" required title="Имя должно быть с большой буквы">

                        <label for="lastName">Фамилия*</label>
                        <input type="text" name="lastName" placeholder="Иванович" pattern="^([А-Я]{1}[а-яё]{1,23}|[A-Z]{1}[a-z]{1,23})$" required title="Фамилиия должна быть с большой буквы">

                        <label for="phone">Телефон*</label>
                        <input type="tel" name="phone" placeholder="+375XXXXXXXXX" pattern="^(\+375|80)(29|25|44|33)(\d{3})(\d{2})(\d{2})$" required title="Введите номер телефона в формате +375XXXXXXXXX">

                        <label for="email">Почта*</label>
                        <input type="email" name="email" placeholder="email@gmail.com" pattern="/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i" required title='Введите правильный адрес электронной почты'>

                        <button type="submit">Отправить</button>
                    </div>
                    <div class="tourData">
                        <h3>Выберите экскурсию</h3>

                        <label for="date">Дата*</label>
                        <input type="date" id="date" name="date" required>

                        <label for="excursion">Экскурсия*</label>
                        <select name="excursion" id="excursion" required>
                            <option value="" disabled selected>Выберите экскурсию</option>
                            <?php
                            $sql = "SELECT * FROM tours";
                            foreach ($tours as $tour) {
                                echo '<option value=' . $tour['id'] . '>' . $tour['name'] . '</option>';
                            }
                            ?>
                        </select>

                        <div class="cta">
                            <div>
                                <p>Узнайте больше про туры <br>в нашем telegram-боте</p>
                                <button onclick="telegramDirect()">Подробнее</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="popup__tour" id="popup__tour" style="display: none;"></div>
        <div class="home__cta">
            <div>
                <p>Узнайте больше про туры <br>в нашем telegram-боте</p>
                <button onclick="telegramDirect()">Подробнее</button>
            </div>
        </div>
        <div class="home__about">
            <h2>О нас</h2>
            <div class="content">
                <div class="home__about-photo">
                    <img src="/img/about_photo1.jpg" class="big_img" alt="">
                    <div>
                        <img src="/img/about_photo2.jpg" alt="">
                        <img src="/img/about_photo3.jpg" alt="">
                    </div>
                </div>
                <div class="home__about-text">
                    <h3>Добро пожаловать!</h3>
                    <p>Мы - команда опытных гидов приветствуем вас в самом сердце Европы, где история, культура и природа сплетаются в гармонии.</p>
                    <p>Мы предлагаем разнообразные экскурсии, позволяющие вам открыть для себя Беларусь по-новому. От исторических городов и замков до величественных национальных парков и уникальных природных памятников, каждая наша экскурсия обещает быть незабываемым приключением.</p>
                    <p>Мы стремимся предоставить высочайший уровень сервиса и комфорта, чтобы посетители могли полностью насладиться своим путешествием.</p>
                    <p>Присоединяйтесь к нам и дайте нам возможность сделать ваше путешествие незабываемым!</p>
                    <div class="home__about-btns">
                        <button>Подробнее</button>
                        <div>
                            <a onclick="telegramDirect()"><img src="/img//telegram.svg" alt="telegram"></a>
                            <a href="#"><img src="/img//inst.svg" alt="instagram"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home__contact">
            <h2>Контакты</h2>
            <div>
                <div class="home__contact-block">
                    <div class="text">
                        <div>
                            <p>Контакт-центр:</p>
                            <p>8 (029) 555-55-55<br>8 (029) 555-55-55</p>
                        </div>
                        <a href="#">Пользовательское соглашение</a>
                    </div>
                    <img src="/img/contact_photo1.jpg" alt="">
                </div>
                <div class="home__contact-block">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.7683148134497!2d27.546629!3d53.9003218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46dbcfe92928a481%3A0x705ce604b23fa077!2svulica%20Niamiha%2034%2C%20Minsk%2C%20Minskaja%20voblas%C4%87!5e0!3m2!1sen!2sby!4v1709134834446!5m2!1sen!2sby" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="text">
                        <div>
                            <p>Адрес:</p>
                            <p>г. Минск, ул. Немига, д.34</p>
                        </div>
                        <div>
                            <p>Режим работы:</p>
                            <p>пн-пт: 10:00-21:00<br>сб-вс: 11:00-22:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home__team">
            <h2>Команда</h2>
            <div class="home__team-catalog">
                <?php
                $sql = "SELECT * FROM team";
                $team = $conn->query($sql);

                foreach ($team as $t) {
                    echo '<div class="home__team-card">';
                    echo '<img src="' . $t['img'] . '" alt="' . $t['name'] . '">';
                    echo '<div class="info">';
                    echo '<div>';
                    echo '<h4>' . $t['name'] . '</h4>';
                    echo '<div class="label">' . $t['experience'] . '</div>';
                    echo '</div>';
                    echo '<p class="overview">' . $t['overview'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </main>
    <?php require 'footer.php' ?>
    <script>
        function scrollToTop() {
            $('html, body').animate({
                scrollTop: $(".home__hero").offset().top
            }, 1000);
        };

        function scrollToTours() {
            $('html, body').animate({
                scrollTop: $(".home__tours").offset().top
            }, 1000);
        };

        function scrollToTeam() {
            $('html, body').animate({
                scrollTop: $(".home__team").offset().top
            }, 1000);
        };

        function scrollToContact() {
            $('html, body').animate({
                scrollTop: $(".home__contact").offset().top
            }, 1000);
        };

        function scrollToAbout() {
            $('html, body').animate({
                scrollTop: $(".home__about").offset().top
            }, 1000);
        };

        function openPopup(selectedExcursionId) {
            var topPosition = window.screenY + (window.screen.height / 2);
            var popup = document.querySelector('.popup');
            popup.style.display = 'block';
            popup.style.top = 'topPosition';
            document.getElementById("excursion").value = selectedExcursionId;
        }

        function openTourPopup(tourId) {
            $.ajax({
                type: "POST",
                url: "tourPopup.php",
                data: {
                    tourId: tourId
                },
                dataType: "html",
                success: function(data) {
                    $('.popup__tour').html(data);
                }
            });

            var topPosition = window.screenY + (window.screen.height / 2);
            var popup = document.querySelector('.popup__tour');
            popup.style.display = 'block';
            popup.style.top = 'topPosition';

        }

        function closePopup() {
            var popup = document.querySelector('.popup');
            var popupTour = document.querySelector('.popup__tour');
            popup.style.display = 'none';
            popupTour.style.display = 'none';
        }

        $(document).mouseup(function(e) {
            var popup = $(".popup");
            var popupTour = $(".popup__tour");
            if (!popup.is(e.target) && popup.has(e.target).length === 0) {
                popup.hide();
            }
            if (!popupTour.is(e.target) && popupTour.has(e.target).length === 0) {
                popupTour.hide();
            }
        });

        function telegramDirect() {
            window.open("https://t.me/naystaj_bot");
        }

        function toggleFilter(filter) {
            if (window.innerWidth < 770) {
                var filterList = document.getElementById(filter + "List");
                filterList.style.display = filterList.style.display === "none" ? "block" : "none";
            }
        }

        window.addEventListener("resize", function() {
            if (window.innerWidth < 770) {
                var filterLists = document.getElementsByClassName("home__tours-filter-block-list");
                for (var i = 0; i < filterLists.length; i++) {
                    filterLists[i].style.display = "none";
                }
            } else {
                var filterLists = document.getElementsByClassName("home__tours-filter-block-list");
                for (var i = 0; i < filterLists.length; i++) {
                    filterLists[i].style.display = "block";
                }
            }
        });

        // $(document).ready(function() {
        //     $(".sort-option").click(function(e) {
        //         e.preventDefault();
        //         var sortType = $(this).data("sort");
        //         $.ajax({
        //             type: "POST",
        //             url: "sort_tours.php",
        //             data: {
        //                 sortType: sortType
        //             },
        //             success: function(response) {
        //                 $(".home__tours-cards").html(response);
        //             }
        //         });
        //     });
        // });

        // function toggleFilter(str) {
        //     var categoryList = document.getElementById('categoryList');
        //     var durationList = document.getElementById('durationList');
        //     var locationList = document.getElementById('locationList');

        //     if (str == 'category') {
        //         if (categoryList.style.display === 'none' || categoryList.style.display === '') {
        //             categoryList.style.display = 'flex';
        //         } else {
        //             categoryList.style.display = 'none';
        //         }
        //     } else if (str == 'duration') {
        //         if (durationList.style.display === 'none' || durationList.style.display === '') {
        //             durationList.style.display = 'flex';
        //         } else {
        //             durationList.style.display = 'none';
        //         }
        //     } else if (str == 'location') {
        //         if (locationList.style.display === 'none' || locationList.style.display === '') {
        //             locationList.style.display = 'flex';
        //         } else {
        //             locationList.style.display = 'none';
        //         }
        //     }
        // }

        // function getCheckedValues() {
        //     var categoryIds = [];
        //     var durationIds = [];
        //     var locationIds = [];

        //     var categoryCheckboxes = document.querySelectorAll('#categoryList input[type="checkbox"]:checked');
        //     categoryCheckboxes.forEach(function(checkbox) {
        //         categoryIds.push(checkbox.id);
        //     });
        //     var durationCheckboxes = document.querySelectorAll('#durationList input[type="checkbox"]:checked');
        //     durationCheckboxes.forEach(function(checkbox) {
        //         durationIds.push(checkbox.id);
        //     });
        //     var locationCheckboxes = document.querySelectorAll('#locationList input[type="checkbox"]:checked');
        //     locationCheckboxes.forEach(function(checkbox) {
        //         locationIds.push(checkbox.id);
        //     });

        //     return {
        //         durationIds: durationIds,
        //         categoryIds: categoryIds,
        //         locationIds: locationIds
        //     };
        // }

        // function updateTours() {
        //     var Ids = getCheckedValues();

        //     $.ajax({
        //         type: "POST",
        //         url: "filter.php",
        //         data: {
        //             category: Ids['categoryIds'],
        //             duration: Ids['durationIds'],
        //             location: Ids['locationIds']
        //         },
        //         dataType: "html",
        //         success: function(data) {
        //             $('.home__tours-cards').html(data);
        //         }
        //     });
        // }

        $(document).ready(function() {
            $(".sort-option").click(function(e) {
                e.preventDefault();
                var sortType = $(this).data("sort");
                var filterIds = getCheckedValues();
                $.ajax({
                    type: "POST",
                    url: "sort_filter.php",
                    data: {
                        sortType: sortType,
                        category: filterIds.categoryIds,
                        duration: filterIds.durationIds,
                        location: filterIds.locationIds
                    },
                    success: function(response) {
                        $(".home__tours-cards").html(response);
                    }
                });
            });

            $(".filter-option").change(function() {
                updateTours();
            });
        });

        function getCheckedValues() {
            var categoryIds = [];
            var durationIds = [];
            var locationIds = [];

            var categoryCheckboxes = document.querySelectorAll('#categoryList input[type="checkbox"]:checked');
            categoryCheckboxes.forEach(function(checkbox) {
                categoryIds.push(checkbox.id);
            });
            var durationCheckboxes = document.querySelectorAll('#durationList input[type="checkbox"]:checked');
            durationCheckboxes.forEach(function(checkbox) {
                durationIds.push(checkbox.id);
            });
            var locationCheckboxes = document.querySelectorAll('#locationList input[type="checkbox"]:checked');
            locationCheckboxes.forEach(function(checkbox) {
                locationIds.push(checkbox.id);
            });

            return {
                durationIds: durationIds,
                categoryIds: categoryIds,
                locationIds: locationIds
            };
        }

        function updateTours() {
            var filterIds = getCheckedValues();

            $.ajax({
                type: "POST",
                url: "sort_filter.php",
                data: {
                    category: filterIds.categoryIds,
                    duration: filterIds.durationIds,
                    location: filterIds.locationIds
                },
                dataType: "html",
                success: function(data) {
                    $('.home__tours-cards').html(data);
                }
            });
        }

        var today = new Date().toISOString().split('T')[0];
        document.getElementById("date").setAttribute("min", today);
    </script>
</body>

</html>