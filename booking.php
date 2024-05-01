<?php
include 'db_conn.php';
session_start();

$firstName = $_POST['firstName'];
$lastName =$_POST['lastName'];
$phone= $_POST['phone'];
$email = $_POST['email'];
$date = $_POST['date'];
$excursion= $_POST['excursion'];

$query = "INSERT INTO booking (user_name, user_surname, id_tour, user_tel, user_email, tour_date) 
            VALUES ('$firstName','$lastName','$excursion','$phone','$email', '$date')";
$result = mysqli_query($conn, $query) or die("Ошибка " . mysqli_error($conn));

if ($result) {
    print"<script language='Javascript' type='text/javascript'> 
        alert('Тур заказан! Ожидайте письмо с подтверждением на почту.'); 
        function reload(){top.location= 'index.php'}; 
        reload(); </script>";
} else {
    print"<script language='Javascript' type='text/javascript'> 
        alert('Ошибка отправки заявки'); 
        reload(); </script>";
}

$conn->close();
