<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/room" method="POST">
        @csrf
        <input type="text" name="day1" value="1"><br>
        <input type="text" name="day1price" value="2000"><br>
        <input type="text" name="day1price_per_person" value="0"><br><br>
        
        <input type="text" name="day2" value="2"><br>
        <input type="text" name="day2price" value="3000"><br>
        <input type="text" name="day2price_per_person" value="0"><br><br>
        
        <input type="text" name="day30" value="30"><br>
        <input type="text" name="day30price" value="2000"><br>
        <input type="text" name="day30price_per_person" value="0"><br>
        <input name="button" type="submit">

    </form>
</body>
</html>
