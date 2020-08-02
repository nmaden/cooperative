@extends('layouts.master')

@section('content')
<main class="public" >

<div class="quest__inner"> 
    <div class="quest__title">
        <p>Места размещения</p>
    </div>



    <div class="quest__sort sort">

        <div class="sort__inputs">
            <select name="" id="" placeholder="Регион">
                <option value="" default>Регион</option>
                <option value=""></option>
                <option value=""></option>
            </select>

            <select name="" id="" placeholder="Тип гостиницы">
                <option value="">Тип гостиницы</option>
                <option value=""></option>
                <option value=""></option>
            </select>
            <select name="" id="" placeholder="Заезды">
                <option value="">Заезды</option>
                <option value=""></option>
                <option value=""></option>
            </select>
        </div>

        <div class="sort__fromto">
            <div>
                <p>от:</p>
                <input type="number">
            </div>
            <div>
                <p>до:</p>
                <input type="number">
            </div>
        </div>
        
        


    </div>
    
    <div class="quest__placements">

        <div class="quest__placement" >
            <div class="quest__top">
                <img src="https://visitkazakhstan.kz/uploads/img/128210104860_hotel.jpg" alt="">
            </div>
            <div class="quest__bottom">
                 <div>
                    <p class="quest__placename">Пекин Палас Солакс</p>
                    <div class="quest__level">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                 </div>
                 <div class="guest__location">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Нур-султан</p>
                 </div>
                 <div class="guest__phone">
                    <i class="fas fa-phone-alt"></i>
                    <p>8 705 534 34 34</p>
                 </div>
            </div>
        </div>

        
        <div class="quest__placement">
          
            <div class="quest__top">
                <img src="https://visitkazakhstan.kz/uploads/img/128210104860_hotel.jpg" alt="">
            </div>

            <div class="quest__bottom">
                 <div>
                    <p class="quest__placename">Пекин Палас Солакс</p>
                    <div class="quest__level">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                 </div>
                 <div class="guest__location">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Нур-султан</p>
                 </div>
                 <div class="guest__phone">
                    <i class="fas fa-phone-alt"></i>
                    <p>8 705 534 34 34</p>
                 </div>
            </div>
        </div>

        
        <div class="quest__placement">
          
            <div class="quest__top">
                <img src="https://visitkazakhstan.kz/uploads/img/128210104860_hotel.jpg" alt="">
            </div>

            <div class="quest__bottom">
                 <div>
                    <p class="quest__placename">Пекин Палас Солакс</p>
                    <div class="quest__level">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                 </div>
                 <div class="guest__location">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Нур-султан</p>
                 </div>
                 <div class="guest__phone">
                    <i class="fas fa-phone-alt"></i>
                    <p>8 705 534 34 34</p>
                 </div>
            </div>
        </div>
    </div>

    <button class="guest__seeall"> 
        <p>Посмотреть еще</p>
    </button>
    @endsection
