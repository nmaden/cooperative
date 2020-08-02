@extends('layouts.app')

@section('content')
    <div  id="modal1" class="modal">
        <div class="modal-content">
            <div id="erconts"></div>
{{--            <form class="col s12">--}}
            <div class="col s12">

                <div class="modal__headers">
                    <p class="modal__title">Регистрация места размещения</p>
                  
                </div>
                <div class="modal__buttons">
                    <div class="modal__close" onclick="closeModalAlert()">
                        <!-- <i  class="fas fa-times"></i> -->
                    </div>   
                    <div  class="active" id="modal__ur" onclick="changeInputs(1)">Для юридических лиц</div>
                    <div id="modal__fiz" onclick="changeInputs(2)">Для физических лиц</div>
                 
                </div>

                <p class="modal__description">Заполните данную заявку для регистрации места размещения в системе. После модерации заявки вам на почту будут высланы доступы в вашу учетную запись, к которой будет прикреплен кабинет вашей организации (места размещения).</p>

                <div id="modal__first">
                    <form action="/request/register" method="POST">
                        <div class="modal__inputs">
                            <div class="modal__input">
                                <p>ФИО</p>
                                <input type="text" required>
                            </div>
                            <div class="modal__input">
                                <p>Номер документа</p>
                                <input type="text" required>
                            </div>
                            <div class="modal__input">
                                <p>ИИН</p>
                                <input type="text" required>
                            </div>
                            <div class="modal__input">
                                <p>Роль</p>
                                <select class="select browser-default">
                                    <option value="" disabled selected>Выберите роль</option>
                                    <option value="1">Администартор</option>
                                    <option value="2">Пользователь</option>
                                    {{-- <option value="3">Option 3</option> --}}
                                </select>
                            </div>
                            <div class="modal__input">
                                <p>Email</p>
                                <input type="text" required>
                            </div>
                            <div class="modal__input">
                                <p>Телефон</p>
                                <input type="text" required>
                            </div>
                            {{-- <div class="modal__input">
                                <p>Наименование места размещения</p>
                                <input type="text">
                            </div> --}}
                            <div class="modal__input">
                                <p>БИН места размещения</p>
                                <input type="text" required>
                            </div>
                            <div class="modal__input">
                                <p>ЭЦП Юридического лица (места размещения)</p>
                                <button>Выбрать сертификат</button>
                            </div>
                        </div>
                        <button class="modal__send">Отправить</button>
                    </form>
                </div>

                <div class="modal__inputs" id="modal__second">
                    <div class="modal__input">
                        <p>ФИО</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>Номер документа</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>ИИН</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>Email</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>Пароль</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>Подверждение пароля</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>Область</p>
                        <select class="select browser-default">
                            <option value="" disabled selected>Выберите область</option>
                            @foreach ($regions as $region)
                            <option value="1">{{ $region->name_rus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal__input">
                        <p>Населенный пункт</p>
                        <select class="select browser-default">
                            <option value="" disabled selected>Выберите населенный пункт</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                    </div>
                    <div class="modal__input">
                        <p>Адрес</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>Номер дома</p>
                        <input type="text">
                    </div>
                    <div class="modal__input">
                        <p>Номер квартиры</p>
                        <input type="text">
                    </div>
                   
                    <div class="modal__input">
                        <p>ЭЦП Юридического лица (места размещения)</p>
                        <button>Выбрать сертификат</button>
                    </div>
                </div>
                <p class="modal__description">Есть вопросы по регистрации, воспользуйтесь  <a>формой обратной связи</a> или свяжитесь с нами по телефону +7 7172 77 99 37.</p>
                {{-- <button class="modal__send">Отправить</button> --}}
            </div>
{{--            </form>--}}
        </div>
<!--
        <div class="modal-footer">
            <a href="#" style="display: none;" class="modal-close waves-effect btn-flat">Закрыть</a>
        </div>
-->
    </div>
    <section id="header">
        <!-- 1 -->
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="top">
                        <nav>
                            <div class="nav-wrapper">
                                <!-- <a href="http://kazakhstan.travel/" class="brand-logo"><img src="{{asset('images/logo.svg')}}" alt=""></a> -->

                                <a href="https://kazakhstan.travel/" class="left left-logo" target="_blank"><img src="{{asset('images/logo.svg')}}" alt=""></a>
                                <a href="https://eqonaq.kz" class="right right-logo"><img src="{{asset('images/icon_logo.png')}}" alt="" style="max-height: 25px;"></a>

                                <a href="#" style="display: none;" data-target="mobile-demo" class="sidenav-trigger"><i
                                            class="material-icons">menu</i></a>
                                <a class="sidenav-trigger right" href="#" style="display: none;"> <i
                                            class="material-icons">lock_outline</i></a>
                                <ul class="right hide-on-med-and-down">
                                    <li><a href="#" style="display: none;" data-target="dropdown1" class="dropdown-trigger">Русский<i
                                                    class="material-icons right">expand_more</i></a></li>
                                    <ul id='dropdown1' class='dropdown-content'>
                                        <li><a href="#" style="display: none;">English</a></li>
                                        <li><a href="#" style="display: none;">Қазақ</a></li>
                                    </ul>
                                    <li><a href="#" style="display: none;"> <i class="material-icons">lock_outline</i></a></li>
                                </ul>
                                <ul class="right hide-on-med-and-down">
                                    <li><a href="#" style="display: none;" class="link_other">Для бизнеса</a></li>
                                </ul>
                                <ul class="right hide-on-med-and-down">
                                    <li><a href="#" style="display: none;">Куда поехать</a></li>
                                    <li><a href="#" style="display: none;">Чем заняться</a></li>
                                    <li><a href="#" style="display: none;">Запланируйте поездку</a></li>
                                </ul>
                            </div>
                        </nav>

                        <ul class="sidenav" id="mobile-demo">
                            <li><a href="#" style="display: none;">Куда поехать</a></li>
                            <li><a href="#" style="display: none;">Чем заняться</a></li>
                            <li><a href="#" style="display: none;">Запланируйте поездку</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row no_mb">
                <div class="col s12 m12 l12">
                    <div class="title_text center-align">
                        <h3>Добро пожаловать в информационную cистему eQonaq</h3>
                        <div class="lin"></div>
                        <h5>eQonaq – специализированная информационная система для взаимодействия мест размещения,
                            иностранных туристов и государственных органов</h5>
                        <!--div-- class="points">
                            <p><span>•</span> создание единого реестра мест размещений и их категоризация</p>
                            <p><span>•</span> учет и последующий анализ данных с использованием технологии Big Data</p>
                            <p><span>•</span> подготовка инфраструктуры для внедрения туристического сбора (bed-tax)
                            </p>
                            <p><span>•</span> упрощение приглашения и регистрации иностранных туристов</p>
                        </!--div-->
                        <div class="log_user">
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <p class="log_user__text">Просто и бесплатно. Отправляйте заявку на подключение прямо сейчас
                                    </p>
                                    <div class="request">
                                        <a  onclick="openModal()" >Регистрация</a>
                                    </div> 
                                </div>
                                <div class="col s12 m6 l6">
                                    <div class="login">
                                        <p class="log_user__text">Если Вы уже зарегистрированы. Войдите под своим логином и паролем</p>
                                        <a href="https://cabinet.eqonaq.kz">Войти</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="information">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="title center-align">
                        <h2>еQonaq - это</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12 m4 l4">
                    <div class="icon">
                        <img src="{{asset('images/icon_6.svg')}}" alt="">
                        <h5>Единый реестр мест размещения</h5>
                        
                    </div>
                </div>
                <div class="col s12 m4 l4">
                    <div class="icon">
                        <img src="{{asset('images/icon_4.svg')}}" alt="">
                        <h5>Учет прибытия и убытия туристов</h5>
                    </div>
                </div>
<!--
                <div class="col s12 m4 l4">
                    <div class="icon">
                        <img src="{{asset('images/icon_3.svg')}}" alt="">
                        <h5>Создание приглашений для получения e-Visa</h5>
                    </div>
                </div>
-->
                <div class="col s12 m4 l4">
                    <div class="icon">
                        <img src="{{asset('images/icon_1.svg')}}" alt="">
                        <!-- <h5>Регистрация и уведомление ГО о прибытии и убытии туристов онлайн</h5> -->
                        <h5>Уведомление МВД РК о прибытии иностранных туристов</h5>
                    </div>
                </div>
                <div class="col s12 m4 l4 offset-l2">
                    <div class="icon">
                        <img src="{{asset('images/icon_5.svg')}}" alt="">
                        <h5>Инфраструктура для учета туристического сбора Bed-Tax</h5>
                    </div>
                </div>
                <div class="col s12 m4 l4">
                    <div class="icon">
                        <img src="{{asset('images/icon_2.svg')}}" alt="">
                        <!-- <h5>Отчеты и аналитика туристической отрасли</h5> -->
                        <h5>Отчеты и аналитика по туристическим потокам и портрету туристов</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="blcok_text_scrin">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="images_ehotel">
                            <img class="materialboxed" src="{{asset('images/e_hotel.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <h4>Модуль реестр мест размещения</h4>
                        <div class="points">
                            <p>Модуль создает единый реестр отелей, гостиниц и других мест размещения, а также содержит
                                подробную информацию о местах размещения иностранных туристах. Реестр является
                                инфраструктурой для передачи данных об иностранных туристов в ИС «Миграционная полиция» и сбора
                                налога
                                Bed-Tax. Данный модуль является публичным и предоставляет рынку и уполномоченным
                                органам
                                достоверную информацию о местах размещения и их категоризации.</p>
                            <p class="litle"> <i class="material-icons left">brightness_1</i> Eдиная база данных
                                отелей,гостиниц,
                                хостелов, баз
                                отдыха и т.д.</p>
                            <p class="litle"> <i class="material-icons left">brightness_1</i> Учет номерного фонда.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i>Фильтрация и поиск по
                                атрибутам.</p>
<!--
                            <div class="btn_main">
                                <a href="#" style="display: none;">Перейти в реестр</a>
                            </div>
-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="blcok_text_scrin">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="images_ehotel">
                            <img class="materialboxed" src="{{asset('images/e_hotel_2.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <h4>Модуль бронирования</h4>
                        <div class="points">
                            <p>Создавайте базу постояльцев и контролируйте качество своих услуг. Удобно и своевременно
                                (без
                                штрафов) предоставляйте данные об иностранных туристах в МВД РК, согласно правилам
                                миграционного учёта, и автоматически известите иностранных туристов о правилах
                                миграционной
                                политики при бронировании и заселении. А также ведите учет постояльцев при отсутсвии
                                специализированной PMS системы.
                            </p>
                            <p class="litle"> <i class="material-icons left">brightness_1</i> Учет прибытия и убытия
                                постояльцев.</p>
                            <p class="litle"> <i class="material-icons left">brightness_1</i> Реестр гостей.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i> Выдача приглашения для
                                e-Visa.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i> Оповещение МВД РК о
                                прибытии
                                иностранных туристов.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i> Тригерные сообщения.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="blcok_text_scrin">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="images_ehotel">
                            <img class="materialboxed" src="{{asset('images/e_hotel_3.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <h4>Отчеты и аналитика</h4>
                        <div class="points">
                            <p class="litle"> <i class="material-icons left">brightness_1</i> Диаграммы и графики о
                                пребывании туристов в местах размещения.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i>Возможность использования
                                технологий Big Data.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i>ТОП 10 популярных стран.
                            </p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i>Отчет по регионам и
                                гостиницам.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i>Количество иностранных
                                гостей
                                по месяцам.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="blcok_text_scrin">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="images_ehotel">
                            <img class="materialboxed" src="{{asset('images/e_hotel_4.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <h4>BED - TAX и Модуль взаимодействия</h4>
                        <div class="points">
                            <p class="litle"> <i class="material-icons left">brightness_1</i> Оповещение мест
                                размещени.
                            </p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i> Обратная связь с местами
                                размещения.</p>
                            <p class="litle"> <i class="material-icons left">brightness_1</i> Инфраструктура для
                                внедрения
                                туристического сбора.</p>
                            <p class="litle"> <i class=" material-icons left">brightness_1</i>Управление сбором:
                                начисление, просмотр и оплата туристического сбора.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="request_block">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="title center-align">
                        <h2>Просто и бесплатно</h2>
                        <p>Отправляйте заявку на подключение прямо сейчас</p>
                        <div class="lin"></div>
                    </div>
                    <div class="request center-align">
                        <a class="modal-trigger" href="#modal1">Отправить заявку</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col s12 m3 l3">
                    <div class="logo_footer">
                        <a href="http://kazakhstan.travel/" ><img src="{{asset('images/logo_footer.svg')}}" alt=""></a>
                    </div>
                    <!--
                    <div class="btn_contact">
                        <a href="#" style="display: none;">Контакты</a>
                    </div>
                    <div class="icon_media">
                        <a href="#"  style="display: none;"><img src="{{asset('images/icon-instagram.svg')}}" alt=""></a>
                        <a href="#" style="display: none;"><img src="{{asset('images/icon-twitter.svg')}}" alt=""></a>
                        <a href="#" style="display: none;"><img src="{{asset('images/icon-youtube.svg')}}" alt=""></a>
                        <a href="#" style="display: none;"><img src="{{asset('images/icon-facebook.svg')}}" alt=""></a>
                    </div>
                    -->
                </div>
                <!--
                <div class="col s12 m2 l2">
                    <ul class="footer_nav">
                        <li><a href="#" style="display: none;">Для бизнеса</a></li>
                        <li><a href="#" style="display: none;">Список полезных <br> веб-ресурсов</a></li>
                        <li><a href="#" style="display: none;">Партнеры</a></li>
                        <li><a href="#" style="display: none;">Соглашение</a></li>
                    </ul>
                </div>
                <div class="col s12 m2 l2">
                    <ul class="footer_nav">
                        <li><a href="#" style="display: none;">О проекте</a></li>
                        <li><a href="#" style="display: none;">Контакты</a></li>
                        <li><a href="#" style="display: none;">Обратная связь</a></li>
                    </ul>
                </div>
                <div class="col s12 m2 l5">
                    <ul class="footer_nav">
                        <li><a href="#" style="display: none;"> Министерство культуры и спорта
                                Республики Казахстан</a></li>
                        <li><a href="#" style="display: none;"> Акционерное общество «Национальная компания
                                «Kazakh Tourism»</a></li>
                    </ul>
                </div>
                -->
            </div>
        </div>
    </footer>


@endsection


<script>
    // function closeModalAlert() {
    //     alert("sda");
    //     document.getElementsByClassName('modal-overlay')[0].style.display = 'none';
        
    //     document.getElementsByClassName('modal')[0].style.display = 'none';
    //     document.getElementsByTagName('body')[0].style.cssText = 'overflow: scroll';
    // }
    function changeInputs(type) {
        if(type==1) {
            document.getElementById('modal__first').style.display = 'flex';
            document.getElementById('modal__second').style.display = 'none';
            
            var element =  document.getElementById('modal__ur');
            element.classList.add("active");
            var element2 =  document.getElementById('modal__fiz');
            element2.classList.remove("active");
        }
        else {
            document.getElementById('modal__first').style.display = 'none';
            document.getElementById('modal__second').style.display = 'flex';
            
            var element =  document.getElementById('modal__ur');
            element.classList.remove("active");
            var element2 =  document.getElementById('modal__fiz');
            element2.classList.add("active");
        }
    }

  

    function openModal() {
        document.getElementsByClassName('modal')[0].style.display = 'block';
        document.getElementsByTagName('body')[0].style.cssText = 'overflow: hidden';
    }
</script>

<style  scoped>

    p {
        padding: 0;
        margin: 0;
    }
    .modal {
        max-height: 88% !important;
        overflow-y: unset !important;
        top: 70px;
        z-index: 999;
    }
    #modal1 {
        width: 905px;
        height: 100%;
    }
    .modal__title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .modal__headers {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .modal__headers div {
        border: 1px solid red;
        width: 20px;
    }
    .modal__headers i {
        cursor: pointer;
        font-size: 20px;
    }
    .modal__headers i:hover  {
        color:  #67A1D6;
    }
    .modal__buttons {
        position: relative;
        display: flex;
        flex-direction: row;
        margin-bottom: 20px; 
    }
    .modal__close {
        position: absolute;
        right: 0;
        top: -20px;
    }
    .modal__description {
        font-size: 12px;
        margin-bottom: 10px;
    }
   
    .modal__buttons div {
        cursor: pointer;
        border-radius: 3px;
        /* margin-left: 10px; */
        white-space: nowrap;
        color: black;
        border: none;
        padding: 15px;
    }
    .modal__buttons .active {
        color: white;
        background-color:  #67A1D6;
    }


    .modal__inputs {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }
    #modal__second {
        display: none;
        width: 100%;
        flex-wrap: wrap;
    }
    .modal__input {
        
        width: 275px;
        display: flex;
        flex-direction: column;

    }
    .modal__input p {
        font-size: 14px;
        margin-bottom: 5px;
        white-space:nowrap;
    }
    .modal__input input {
        width: 255px !important;
        padding-left: 5px !important;
        margin-right: 7px !important;
        border: 1px solid #ccc !important;
        border-radius: 3px !important; 
    }
    .modal__input select {
        width: 263px !important;
        height: 47px;
        border: 1px solid #ccc !important;
        border-radius: 3px !important; 
        background-color: transparent;
    }
    .modal__input select:focus {
        outline: none;
        border: none;
    }
    .modal__input button {
        color: white;
        width: 250px;
        padding: 14px;
        background-color: #98D667;
        border-radius: 3px;
        border: none;
        outline: none;  
    }
    .modal__send {
        padding: 10px;
        cursor: pointer;
        background-color:  #67A1D6;
        color: white;
        border-radius: 3px;
        border:none;
        outline: none;
    }

    .log_user__text {
        margin-bottom: 10px;
    }

    #header .title_text .log_user .request a {
        margin-right: 0;
        cursor: pointer;
    }
    #information .points .litle {
        display: flex;
    }
    #information .icon img {
        height: 112px;
    }


    @media only screen and (max-width: 600px){
        #request_block .request a {
            margin-right: 0;
        }
        #header .title_text .log_user .request a {
            margin-right: 0;
            width: 100%;
        }
        #header .title_text .log_user .login a {
            margin-right: 0;
            width: 100%;
        }
        .modal .modal-content {
            padding: 15px;
        }
        div#modal1 {
            top: 5% !important;
        }
        #modal1 .row .col.s12 {
            margin: 5px 0;
        }
        #modal1 input {
            margin-bottom: 0 !important;
        }
        a.left.left-logo img {
            max-width: 80px;
        }

        a.right.right-logo img {
            max-width: 180px;
        }

        #information .blcok_text_scrin {
            margin-bottom: 20px !important;
        }
    }
   
</style>