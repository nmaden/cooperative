<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Получение</h1>
    <form action="/test-placement" method="get">
        @csrf
        <input type="text" name="id"><br>
        <input type="submit" name="button">

    </form>

    <h1>POST Обновление</h1>
    <form action="/test-placement" method="post">
        @csrf
        <input type="text" name="id" value="4">
            <p>name</p>
            <input name="name" type="text">
            <p>regionID</p>
            <input name="region_id" type="number"><br>
            <p>areaID</p>
            <input name="area_id" type="number"><br>
            <p>localityID</p>
            <input name="locality_id" type="number"><br>
            <p>street</p>
            <input name="street" type="text"><br>
            <p>house</p>
            <input name="house" type="number"><br>
            <p>BIN</p>
            <input name="BIN" type="number"><br>
            <p>PMS</p>
            <input name="PMS" type="number"><br>
            {{-- <p>start</p>   
            <input value="{{$certificates->start}}" type="text"><br> --}}

            <p>description</p>
            <input name="description" type="text"><br>
            <p>site</p>
            <input name="site" type="text"><br>
            <p>bookinglink</p>
            <input name="booking_link" type="text"><br>
            <p>tripadvisor_link</p>
            <input name="tripadvisor_link" type="text"><br><br>
            {{-- <div>
                <label for="image">Image</label>
                <input name="image" type="file" placeholder="image"> 
            </div><br> --}}
            {{-- {{ csrf_field() }} --}}


            <input name="button" type="submit"><br>
    </form>

    <h1>Фото</h1>
    <form action="/test-placement/image/upload" enctype="multipart/form-data" method="POST">
        @csrf
        <p>Загрузите файл с картинкой</p>
        <input type="text" name="hotel_id">
        <p><input type="file" name="image"></p>
        <input name="button" type="submit"><br>
    </form>
</body>
</html>