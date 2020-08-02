<!-- <head>
<meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head> -->

@extends('layouts.master')

@section('content')
<div class="description">
    <div class="description__inner">
        <div class="description__top">
            
            <div class="description__information">              
                <div class="description__logo">
                    <img src="{{asset('images/hotel.svg')}}" alt="">
                </div>  
                <div class="description__info">
                    <div class="description__name">
                        <p>Park Inn by Radisson</p>
                        <div class="description__stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <a href="" class="description__link">www.radisson-astana.kz </a>

                    <p class="description__issues">Услуги</p>

                    <div class="description__services">
                        <p>WIFI</p>
                        <p>Завтрак</p>
                        <p>Ресепшн круглосуточно</p>
                        <p>Ежедневная уборка</p>
                    </div>

                    <div class="description__location" >
                        <i class="fas fa-map-marker-alt"></i>
                        <a href="#description__map">ул. Сары Арка, 4, Нур-Султан, Казахстан</a>
                    </div>

                </div>
            </div>



            <div class="description__booking">

                <div class="description__book">
                    <a href="">Отзывы</a>
                    <a href="">booking</a>
                    <a href="">tripAdvisor</a>
                </div>
                
                <div class="description__order" onclick="openModal()">
                    <p>Забронировать</p>
                </div>
            </div>
        </div>

        <div class="description__images">
            <div class="description__image">
                <img src="{{asset('images/hotel.svg')}}" alt="">
                <img src="{{asset('images/hotel.svg')}}" alt="">
                <img src="{{asset('images/hotel.svg')}}" alt="">
                <img src="{{asset('images/hotel.svg')}}" alt="">
                <img src="{{asset('images/hotel.svg')}}" alt="">
                <img src="{{asset('images/hotel.svg')}}" alt="">
            </div>
               

            <div class="description__arrow" >
                <i class="fas fa-chevron-left"></i>
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <div class="description__texts">
            <p>
            Спектр услуг элегантного 5-звездочного Radisson Hotel, Astana включают в себя круглосуточный ресепшн, автосервис и уборку номеров. Здесь есть 181 комфортабельных номеров. Nur Astana Mosque и Kazakhstan Sports Palace находятся на расстоянии 3.6 км и 3.8 км соответственно.
            </p>
            
        </div>

        <div class="description__numbers">
            <p class="numbers__title">Наличие мест</p>

            <div class="numbers__table">
                <div class="numbers__table--header">
                    <div class="numbers__table--left">
                        <p>Вмещает</p>  
                    </div>
                    <div class="numbers__table--right">
                        <p>Тип номера</p>
                    </div>
                </div>

                <div class="numbers__table--row">
                    <div class="numbers__table--left">
                        <i class="fas fa-users"></i>
                    </div>

                    <div class="numbers__table--right">
                        <div class="numbers__table--text">
                            <p>Стандартный номер</p>
                            <p>1 большая двуспальная кровать или 2 односпальные кровати</p>
                        </div>
                        <div class="description__order"  onclick="openModal()">
                            <p>Забронировать</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="description__map" id="description__map">

                <img src="{{asset('images/map.svg')}}" alt="">
        </div>
    </div>


    <div class="modal" style="display: none">
        <div class="modal__inner">

                   
            <i class="fas fa-times modal__exit" onclick="closeModal()" ></i>
            <!-- <div class="modal__calendars">

                <div class="modal__calendar">
                    <p class="modal__month">Май 2020</p>
                    <div class="modal__days">
                        <p></p>
                        <p></p>
                    </div>
                </div>
                <div class="modal__calendar">
                    <p class="modal__month">Май 2020</p>
                    <div class="modal__days">
                        <p></p>
                        <p></p>
                    </div>
                </div>

                <div class="modal__calendar">
                    <p class="modal__month">Май 2020</p>
                    <div class="modal__days">
                        <p></p>
                        <p></p>
                    </div>
                </div>
                <div class="modal__calendar">
                    <p class="modal__month">Май 2020</p>
                    <div class="modal__days">
                        <p></p>
                        <p></p>
                    </div>
                </div>

                <div class="modal__calendar">
                    <p class="modal__month">Май 2020</p>
                    <div class="modal__days">
                        <p></p>
                        <p></p>
                    </div>
                </div>
                <div class="modal__calendar">
                    <p class="modal__month">Май 2020</p>
                    <div class="modal__days">
                        <p></p>
                        <p></p>
                    </div>
                </div>


            </div> -->

            <div class="modal__forms">

                <div class="modal__inputs">
                    <input class="modal__input" type="text" placeholder="Ваше ФИО">
                    <input class="modal__input" type="text" placeholder="Телефон">
                    <input class="modal__input"type="text" placeholder="Email">
                    <select class="modal__input" name="" id="">
                        <option value="">Нужно вас встретить</option>
                    </select>
                    <p class="modal__total">Цена за номер: 25 000 тнг.</p>
                </div>

                <div class="modal__inputs">
                    <select class="modal__input" name="" id="">
                        <option value="">Тип номера</option>
                    </select>
                    <input class="modal__date" type="date">
                    <input class="modal__date" type="date">
                    <select class="modal__input" name="" id="">
                        <option value="">Количество человек</option>
                    </select>
                </div>

                <p class="modal__total--last">Цена за номер: 25 000 тнг.</p>



            </div>


                <div class="modal__agreement">
                    <input type="checkbox">
                    <p>Согласен на обработку персональных данных</p>
                </div>

                <div class="modal__buttons">
                        <div class="modal__order">
                            <p>Забронировать</p>
                        </div>
                        <div class="modal__close">
                            <p>Закрыть</p>
                        </div>
                </div>

        </div>
    </div>
</div>
@endsection

<script>
    function openModal() {
        document.querySelector('.modal').style.display = 'flex';
    }
    function closeModal() {
        document.querySelector('.modal').style.display = 'none';
    }

</script>

<style>
    .modal {
        display: none;
        
    }
    p {
        padding: 0;
        margin: 0;
        font-family: Tahoma;
    }
    .description {
        display: flex;
        flex-direction: row;
        justify-content:center;
        width: 100%;
        padding-top: 130px;
    }
    .description__inner {
        width: 1150px;
        
        display: flex;
        flex-direction: column;
        align-items:center;
    }

    .description__top {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        border-bottom: 1px solid gray;
        padding: 20px;
    }
    .description__information {
        display: flex;
        flex-direction: row;
    }
    .description__info {
        margin-left: 20px;
        display: flex;
        flex-direction: column;
    }
    .description__logo img {
        
        height: 150px;
    }
    .description__name {
        display: flex;
        flex-direction: row;
        align-items: center;    
        
        margin-bottom: 10px;
    }
    .description__name p {
        font-size: 25px;
        white-space: nowrap;
        font-weight: bold;
        margin-right:10px;
    }
    .description__stars {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
       
        width: 110px;
    }
    .description__stars i {
        color:  #F5C93C;
    }

    .description__link {
        margin-bottom: 10px;
    }
    .description__issues {
        margin-bottom: 10px;
    }
    .description__services {
       
        display: flex;
        flex-direction: row;
        margin-bottom: 20px;
    }
    .description__services p {
        margin-right: 10px;
    }

    .description__booking {
        display: flex;
        flex-direction: column;
        
    }
    .description__location {
        
        display: flex;
        flex-direction: row;
        align-items: center;        
    }
    .description__location a {
        text-decoration: none;
    }
    .description__location i {
        margin-right: 10px;
        color: orangered;
        color:  #F5C93C;
    }
    .description__book {
        width: 200px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom:10px;
    }
    .description__order {
        cursor: pointer;
        background-color:  #F5C93C;
        color: black;
        text-align: center;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .description__order:hover {
        color: white;
        background-color: #f7c730;
    }
    .description__images {
        display: flex;
        flex-direction: column;
        border-bottom: 1px solid gray;
        width: 100%;
     
        padding: 20px;
    
    }
    .description__image {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        overflow-x: scroll;
        margin-bottom: 20px;
    }
    .description__images img {
        height: 133px;
        border-radius: 3px;
        margin-right: 20px;
    }
    .description__arrow {
        width: 40px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-self: flex-end;

    }
    .description__arrow i {
        color: #67A1D6;
        font-size: 20px;
    }

    .description__texts {
        width: 1150px;
        padding: 20px;
        border-bottom: 1px solid gray;
    }
    
    .description__numbers {
        width: 1150px;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }
    .numbers__title {
        font-weight: bold;
        margin-bottom: 20px;
        font-size: 22px;
    }

    .numbers__table {
        display: flex;
        flex-direction: column;
    }
    .numbers__table--right {
        width: 50%;
        display: flex;
        flex-direction: row;
    }
    .numbers__table--left {
        width: 50%;
        text-align: center;
    }
    .numbers__table--header {
        background-color: #F2F2F2;
        padding: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        text-align: center;
        
    }
    .numbers__table--row {
        padding: 20px;
        background-color: #FAFAFA;

        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
  
    .numbers__table--row i {
        font-size: 40px;
    }
    .numbers__table--type {
        width: 550px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .numbers__table--text {
        font-size: 14px;
        display: flex;
        flex-direction: column;
        margin-right: 20px;
    }
    .numbers__table--text p:nth-child(1) {
        font-weight: bold;
    }


    .description__map {
        width: 1200px;
    }

    .description__map img {
        width: 100%;
    }


    /* modal */
    .modal {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        bottom: 0;
        height: 100vh;
        
        
        background: rgba(0, 0, 0, 0.7);
    }
    .modal__inner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #FFFFFF;
        border-radius: 3px;
        height: 90vh;
        width: 1150px;
    }
    .modal__calendars {
        width: 100%;
        overflow-x: scroll;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 20px;
        margin-bottom: 20px;
    }
    .modal__calendar {
        border-radius: 3px;
        width: 300px;
        padding: 20px;
        height: 200px;
        background-color: white;
        z-index: 1;
        box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.62);
       
    }

    .modal__forms {
        width: 480px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 10px;

    }
    .modal__inputs {
        display: flex;
        flex-direction: column;
    }
    .modal__inputs p{
        font-size: 20px;
    }
    .modal__inputs .modal__input {
        width: 230px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;

        margin-bottom: 10px;
    }
    .modal__date {
        width: 230px;
        padding: 12px;
        border-radius: 3px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }
    .modal__inputs select {
        padding: 14px;
        border: 1px solid #ccc;
        border-radius: 3px;

        margin-bottom: 10px;
    }
    .modal__total {
        display: block;
    }
    .modal__total--last {
        display: none;
    }
    .modal__agreement {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 10px;
    }
    .modal__agreement p {
        margin-left: 10px;
    }
    .modal__buttons {
        width: 320px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    
    }
    .modal__order {
        color: black;
        width: 140px;
        padding: 8px;
        background-color: #F5C93C;
        text-align: center;
        
        cursor: pointer;
        
    }
    .modal__order:hover {
        color: white;
    }
    .modal__close {
        color: black;
        width: 140px;
        padding: 8px;
        background-color: #ccc;
     
        text-align: center;
        cursor: pointer;
       
    }
    .modal__close:hover {
        color: white;
    }
    .modal__exit {
        position:absolute;
        top: 50px;
        right: 70px;
        font-size: 24px;
    }
    @media screen and (max-width: 600px) { 
        .modal__exit {
            align-self: flex-end; margin: 20px; font-size: 30px
        }
        .description__inner {
            width: 100%;
        }
        .description__top {
            padding: 0;
            width: 90%;
            flex-direction: column;
        }
        .description__information {
            flex-direction: column;
        }

        .description__logo {
            margin-bottom: 20px;
        }
        .description__location {
            margin-bottom: 20px;
        }
        .description__info {
            margin: 0;
        }
        .description__name p {
            margin-bottom: 10px;
        }
        .description__name {
            flex-direction: column;
        }
       
       
        .numbers__table--right {
            flex-direction: column;
        }
        .numbers__table--right p {
            margin-bottom: 5px;
        }
        .description__information {
            width: 100%;
        }
        .description__images {
            width: 90%;
        }

        .description__texts {
            width: 90%;
        }
        .description__numbers {
            width: 90%;
        }
        .description__map {
            width: 90%;
        }

        .modal {
            align-items: flex-start;
        }
        .modal__inner {
            width: 100%;
            height: 100vh;
            justify-content: center;
            position: relative;
        }
        .modal__forms {
            flex-direction: column;
            align-items: center;
        }
        .modal__inputs {
            align-items: center;
        }

        .modal__total {
            display: none;
        }
        .modal__total--last {
            display: block;
        }
    }

</style>