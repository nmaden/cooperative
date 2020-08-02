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
            
            table {
              margin-bottom: 20px;
            }
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
        border-color: {{$transaction->color}};
    }
    </style>
</head>
<body>
    <div class="newsletter__emailmessage emailmessage">
                        

        <img  src="/statics/headpost.svg" alt="">

        <div class="emailmessage__body emailmessage__border"    style="border-color: {{$emailProperties->color}};">
            <div class="emailmessage__head" style="position: relative">
                <div class="emailmessage__logo">
                    {{-- <img src="/images/bg.png" alt=""> --}}
                </div>
                <div class="emailmessage__contact">
                    <p class="emailmessage__name">{{$transaction->hotel->name}}</p>
                    <p class="emailmessage__phone">+77772224349: +7 (727) 323-11-37</p>
                </div>
            </div>

            <div class="newsletter__column">
                {{-- <div class="newsletter__section newsletter__2">
                    <p>2</p>
                </div> --}}
                <p class="emailmessage__bold">{{$emailProperties->appeal}}</p>
                
                <p class="emailmessage__text">{{$emailProperties->instant_text}}</p>
            </div>

            @if ($emailProperties->status_booking === 1)
                <div class="newsletter__column" v-if="email_data.detail_for_booking">
                    {{-- <div class="newsletter__section newsletter__3">
                        <p>3</p>
                    </div> --}}
                    <p class="emailmessage__bold">Детали вашего бронирования</p>
                    <p class="emailmessage__text">№123456789-11-11111 </p>
                    
                    <table width="100%"  align="center" 
                        cellpadding="4" cellspacing="0">
                        
                        <tr > 
                        <td style="border-top:1px solid #ccc; border-bottom: 1px solid #ccc; border-left: 1px solid #ccc "><p class="emailmessage__text">Заезд: {{$transaction->check_in}}</p></td>
                        <td style="border: 1px solid #ccc" rowspan="2"><p class="emailmessage__text">Выезд: {{$transaction->check_out}}</p></td>
                        </tr>
                        <tr> 
                            <td style="border-left: 1px solid #ccc; border-bottom: 1px solid #ccc"><p class="emailmessage__text">Ночей {{$daysAtHotel}}</p></td>
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
            <p>No</p>
        @endif
    
        <div class="newsletter__column">   
            @if ($emailProperties->status_pay === 1)
                <div  class="newsletter__column"  v-if="email_data.comment_for_payment">
                    <div v-if="email_data.comment_for_payment" class="newsletter__section newsletter__4">
                        <p>4</p>
                    </div>
                    <div class="newsletter__auto">
                        <p>Напоминаем, что вы выбрали способ оплаты:</p>
                        <a>Гарантия банковской картой</a>
                    </div>
                </div>
            @else
            
            @endif
            @if ($emailProperties->status_cancel === 1)
                <div class="newsletter__column" v-if="email_data.booking_condition">
                    <div v-if="email_data.booking_condition" class="newsletter__section newsletter__5">
                        <p>5</p>
                    </div>
                    <p>Условия отмены бронирования</p>
                    <p  class="emailmessage__text">Связаться со службой бронирования можно по телефону: +7 (727) 323-11-37 или e-mail: <a href="qwer@aser.zi">qwer@aser.zi</a></p>

                    <p  class="emailmessage__text">
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

        
            <div class="newsletter__column" v-if="email_data.sign">
                <div v-if="email_data.sign" class="newsletter__section newsletter__7">
                    <p>7</p>
                </div>
                <p style="align-self: center">{{$emailProperties->signature_text}}</p>
            </div>
        
        </div>
    </div>
        <div class="emailmessage__footer" style="background: #FFCE03; border-color: {{$emailProperties->color}}; { borderColor: email_data.borderColor, backgroundColor: em ail_data.backColor}">
            <p class="emailmessage__text">© 2020 Отель {{$transaction->hotel->name}} Казахстан, {{$transaction->hotel->region_id}} область, {{$transaction->hotel->area_id}} район, г. {{$transaction->hotel->locality_id}}, ул. {{$transaction->hotel->street}},, д. {{$transaction->hotel->house}}</p>

            <p class="emailmessage__text">Письмо автоматически сформировано системой TravelLine</p>

            <a href="">Отписаться от рассылки</a>
        </div>
                        
    </div>
</body>
</html>