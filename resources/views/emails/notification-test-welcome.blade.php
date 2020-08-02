<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
            
    .emailmessage__body {
        display: flex;
        flex-direction: column;
        padding: 20px;
        border-left: 10px solid;
        border-right: 10px solid;
    }

        .emailmessage__border {
            border-color: #654BD8;
        }

        .newsletter__column {
            position: relative;
            padding-top: 10px;
        }

        .newsletter__column table {
              margin-bottom: 20px;
        }
        .emailmessage__head {
          display: flex;
          flex-direction: row;
          align-items: center;
          margin-bottom: 10px;
        }
        .emailmessage__contact {
            margin-left: 40px;
        }
        .emailmessage__contact p {
              font-weight: normal;
        }
        .emailmessage__contact img {
            width: 150px;
            height: 100px;
        }

        .emailmessage__bold {
          font-size: 20px;
          font-weight: bold;
        }
        .emailmessage__text {
          font-weight: normal !important;
        }

    .emailmessage__footer {

        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20px;
        color: white;
        border-left: 10px solid;
        border-bottom: 10px solid;
        border-right: 10px solid;
    }

    .firstcolor {
        border-color: {{$emailProperties->color}};
    }
    </style>
</head>
<body>
    <div class="newsletter__emailmessage emailmessage">
                        

        <img  src="https://vk.com/photo359417559_457239505?rev=1" alt="" width="100%">

        <div class="emailmessage__body emailmessage__border"    style="display:block; padding: 20px; border-left: 10px solid; border-right: 10px solid; border-color: {{$emailProperties->color}};">
            <div class="emailmessage__head" style="display: flex; flex-direction: row; align-items: center; margin-bottom: 10px; position: relative">
                <div class="emailmessage__logo">
                    {{-- <img src="/images/bg.png" alt=""> --}}
                </div>
                <div class="emailmessage__contact">
                    <p class="emailmessage__name">{{$hotel->name}}</p>
                    <p class="emailmessage__phone">+77772224349: +7 (727) 323-11-37</p>
                </div>
            </div>

            <div class="newsletter__column" style="position: relative; padding-top: 10px;">
                {{-- <div class="newsletter__section newsletter__2">
                    <p>2</p>
                </div> --}}
                <p class="emailmessage__bold" style="font-size: 20px; font-weight: bold;">{{$emailProperties->appeal}}</p>

                {{-- @if ($typeMessage == 'welcome') --}}
                <p class="emailmessage__text" style="font-weight: normal;">{{$emailProperties->welcome_text}}</p>
                {{-- @endif

                @if ($typeMessage == 'farewell')
                <p class="emailmessage__text" style="font-weight: normal;">{{$emailProperties->farewell_text}}</p>
                @endif --}}

            </div>

            @if ($emailProperties->status_booking === 1)
                <div class="newsletter__column" style="position: relative; padding-top: 10px;">
                    {{-- <div class="newsletter__section newsletter__3">
                        <p>3</p>
                    </div> --}}
                    <p class="emailmessage__bold" style="font-size: 20px; font-weight: bold;">Детали вашего бронирования</p>
                    <p class="emailmessage__text" style="font-weight: normal;">№123456789-11-11111 </p>
                    
                    <table width="100%"  align="center" 
                        cellpadding="4" cellspacing="0">
                        
                        <tr > 
                        <td style="border-top:1px solid #ccc; border-bottom: 1px solid #ccc; border-left: 1px solid #ccc "><p class="emailmessage__text">Заезд: XX:XX:XX</p></td>
                        <td style="border: 1px solid #ccc" rowspan="2"><p class="emailmessage__text">Выезд: XX:XX:XX</p></td>
                        </tr>
                        <tr> 
                            <td style="border-left: 1px solid #ccc; border-bottom: 1px solid #ccc"><p class="emailmessage__text">Ночей X</p></td>
                        </tr>
                    </table>

                    <table style="width: 100%">
                        <tr>
                            <td style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Категории номеров</td>
                            <td style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Цена, тнг</td>
                            <td style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Кол-во</td>
                            <td style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Стоимость, тнг.</td>
                        </tr>

                        <tr>
                        <td style="width: 180px; background-color: #FAFAFA; text-align: center; padding: 5px"> 
                            <p class="emailmessage__text">Стандарт повышенной комфортности</p>
                            <p class="emailmessage__text">Алматинская область, Алмалинский район, г. Алматы, ул. ул. Ауэзова, д. 48</p>
                        </td>
                        <td style="background-color: #FAFAFA; text-align: center; padding: 5px">6500</td>
                        <td style="background-color: #FAFAFA; text-align: center; padding: 5px">1</td>
                        <td style="background-color: #FAFAFA; text-align: center; padding: 5px">6500</td>
                        </tr>

                        <tr>
                        <td style="text-align:center">Услуга в номере ежедневная</td>
                        <td></td>
                        <td></td>
                        <td style="text-align:center">включено</td>
                        </tr>

                
                    </table>

                    <table style="width: 100%;">
                        <tr>
                            <td  style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Доп. услуги и сервисы</td>
                            <td  style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Цена, тнг.</td>
                            <td  style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Кол-во</td>
                            <td  style="background-color: #F2F2F2; text-align: center;  padding: 5px;">Стоимость, тнг.</td>
                        </tr>

                        <tr>
                            <td style="background-color: #FAFAFA; text-align: center; padding: 5px;">Трансфер из аэропорта</td>
                            <td style="background-color: #FAFAFA; text-align: center; padding: 5px;">6500</td>
                            <td style="background-color: #FAFAFA; text-align: center; padding: 5px;">1</td>
                            <td style="background-color: #FAFAFA; text-align: center; padding: 5px;">6500</td>
                        </tr>
                    </table>

                    <div class="newsletter__auto" style="align-self: flex-end">
                        <p>Итого к оплате, тнг</p>
                    <p>13 000</p>
                </div>     
        </div>
        @else

        @endif
    
        <div class="newsletter__column" style="position: relative; padding-top: 10px;">   
            @if ($emailProperties->status_pay === 1)
                <div  class="newsletter__column" style="position: relative; padding-top: 10px;">
                    
                    <div class="newsletter__auto">
                        <p>Напоминаем, что вы выбрали способ оплаты:</p>
                        <a>Гарантия банковской картой</a>
                    </div>
                </div>
            @else
            
            @endif
            @if ($emailProperties->status_cancel === 1)
                <div class="newsletter__column" style="position: relative; padding-top: 10px;">
                    
                    <p>Условия отмены бронирования</p>
                    <p  class="emailmessage__text" style="font-weight: normal;">Связаться со службой бронирования можно по телефону: +7 (727) 323-11-37 или e-mail: <a href="qwer@aser.zi">qwer@aser.zi</a></p>

                    <p  class="emailmessage__text" style="font-weight: normal;">
                        Для отмены бронирования необходимо пройти по ссылке <a href="http://www.travelline.ru/cancellation?number=123456789-11-11111">http://www.travelline.ru/cancellation?number=123456789-11-11111</a> и ввести код отмены бронирования VF23J.
                    </p>
                </div>
            @else
            
            @endif

            {{-- <div class="newsletter__column" v-if="email_data.weather">
                <div v-if="email_data.weather" class="newsletter__section newsletter__6">
                    <p>6</p>
                </div>
                <p>Погода</p>
                <div style="align-self: center">
                    <img src="/statics/weather.svg" alt="">
                </div>
            </div> --}}

        
            <div class="newsletter__column" style="position: relative; padding-top: 10px;">
                
                <p style="align-self: center">{{$emailProperties->signature_text}}</p>
            </div>
        
        </div>
    </div>
        <div class="emailmessage__footer" style="text-align: center; display: block; padding: 20px; margin-top: -20px; color: white; border-left: 10px solid; border-bottom: 10px solid; border-right: 10px solid;background: #FFCE03; border-color: {{$emailProperties->color}};">
            <p class="emailmessage__text" style="font-weight: normal;">© 2020 Отель {{$hotel->name}} Казахстан, {{$hotel->region_id}} область, {{$hotel->area_id}} район, г. {{$hotel->locality_id}}, ул. {{$hotel->street}},, д. {{$hotel->house}}</p>

            <p class="emailmessage__text" style="font-weight: normal;">Письмо автоматически сформировано системой TravelLine</p>

            <a href="">Отписаться от рассылки</a>
        </div>
                        
    </div>
</body>
</html>