<?php

use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ ltrim(elixir('css/pdf.css'), '/') }}" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body style="font-family: DejaVu Sans;">


    <p>Дата заказа: {{$name}}</p>
    <p>Дата редактирования: 20.02.2021  {{$id}}</p>

    <p>Cотрудник: </p>
    <p>Примечание: </p>
    <p>Толшина: 15</p>
    <p>Сумма заказа: </p>

    <p>Заказанные элементы</p>

    <div>
        <p>Название</p>
       
        <p>Длина: 1 м</p>
        <p>Ширина: 1 м</p>
        <p>Количество: 1 м</p>
        <p>Цена: 3555 тг</p>
        <p>Сумма: 1000 тг</p>

    </div>



</body>

</html>
