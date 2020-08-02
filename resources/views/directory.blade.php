@extends('layouts.master')

@section('content')
                <div class="guide__inner">
                    <div class="quest__title">
                        <p>Миграционный справочник</p>
                    </div>

                    <div class="guide__body">
                        <div class="guide__search">

                            <select name="" id="">
                                <option value="">Страны</option>
                            </select>
                            
                            <div class="guide__form">
                                <input type="text">
                                <i class="fas fa-search"></i>
                            </div>
                           
                        </div>


                        <div class="guide__info">
                            <div class="guide__countries countries">
                                <p class="countries__title">Топ 10 стран</p>
    
                                <p class="countries__item">Армения</p>
                                <p class="countries__item">Абхазия</p>
                                <p class="countries__item">Абхазия</p>
                            </div>
    
                            <div class="guide__col2">
                                
                                <p class="col2__title">Армения</p>
    
                                <div class="guide__top">
                                    <div>
                                        <p>Безвизовый въезд в течение</p>
                                        <p>30 дней</p>
                                    </div>
                                    <div>
                                        <p>Электронная виза (eVisa)</p>
                                        <p>Да</p>
                                    </div>
                                </div>
                                <div class="guide__center">
                                    <div style="display: flex; flex-direction: column;
                                    align-items: flex-start;">
                                        <p>
                                            Для получения элекронной визы необходимо обратиться в визово-миграционный портал 
                                            
                                        </p>
                                        <a href="">www.vmp.gov.kz</a>
                                    </div>
                                    <div>
                                        <p>
                                            Регистрация осуществляется автоматически при вьезде в страну на срок действие безвизового режима или визы
                                        </p>
                                    </div>
                                </div>
                                <div class="guide__bottom">
                                    <p>Вы можете находиться в Республике Казахстан без визы если период пребывания не превышает 30 дней, если свыше указанного срока необходимо оформление визы.</p>
                                </div>
    
                                <p class="guide__footertext">Принимающая сторона обязана произвести уведомление в течение (дней) трех дней. Данная возможность реализована посредством система eQonaq, а также через визиво-миграционный портал</p>
                            </div>
                        </div>
                        
                    </div>


                </div>
                @endsection


                <style>
                    
body {
    margin: 0;
    padding: 0;
    font-family: 'Tahoma';
    width: 100%;
}
p {
    margin: 0;
    padding: 0; 
}
.header {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    z-index: 50;
    -webkit-box-shadow: 0 8px 6px -6px gray;
    -moz-box-shadow: 0 8px 6px -6px gray;
    box-shadow: 0 8px 6px -6px gray;
    position: fixed;
    top: 0;
    background-color: white;
}
.header__inner {
    width: 1150px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}
.header__left {
    width: 740px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.header__logo img{
    width: 100px;
    height: 100px;
}
.header__labels {
    display: flex;
    flex-direction: row;
    align-items: center;
}
.header__labels a {
    white-space: nowrap;
    font-size: 18px;
    margin-right: 10px;
    text-decoration: none;
    color: #080C2E;
}
.header__labels a:hover {
    color: #6069b6;
}
.header__form {
    display: flex;
    flex-direction: row;
    align-items: center;
}

.header__search {
    display: flex;
    flex-direction: row;
    align-items: center;
}
.header__search i {
    color: #67A1D6;
    margin-right: 10px;
}
.header__input {
    display: none;
    border-radius: 20px;
    border: 1px solid #ccc;
    padding: 5px;
    margin-right: 5px;
    outline: none;
}
.header__input:focus {
    border: 2px solid #67A1D6;
}

.header__lang {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    position: relative;
    margin-right: 10px;
}
.lang__inner {
    display: flex;
    flex-direction: row;
    align-items: center;
}
.lang__inner p {
    font-size: 16px;

}
.lang__type {
    margin-right: 5px;
}

.lang__updown {
    color: #67A1D6;
    display: flex;
    flex-direction: row;
    align-items: center;
}
.lang__down {
    color: #67A1D6;
    display: none;
}

.lang__value {
    display: none;
    position: absolute;
    top: 35px;
   
    flex-direction: column;
    align-items: center;
    background-color: white;
    -webkit-box-shadow: 0 8px 6px -6px #a9a9a9;
    -moz-box-shadow: 0 8px 6px -6px #a9a9a9;
    box-shadow: 2px 8px 6px -6px #a9a9a9;
}
.lang__value p {
    font-size: 16px;
    cursor: default;
    padding: 10px;
 
}
.lang__value p:hover{
    background-color: #ccc;
    color: #67A1D6;
}

    
/* ----  GUEST  ----  */
.public {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-image: url("../img/bg.png");
    padding-top: 130px;
}

.quest__inner {
    width: 1150px;
    display: flex;
    flex-direction: column;

    margin-bottom: 20px;

}
.guide__inner { 
    width: 1150px;
    display: flex;
    flex-direction: column;
    padding-top: 130px;
    margin: auto;
    margin-bottom: 20px;
}
.quest__title {
    width: 1150px;
    border-radius: 3px;
    margin-bottom: 20px;
    
}
.quest__title p {
    font-size: 30px;
    font-weight: bold;
}

.quest__sort {
  width: 1150px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 20px;
} 
.sort__inputs {
    display: flex;
    flex-direction: row;
    align-items: center;
}
.sort__inputs select {
    margin-right: 20px;
    width: 280px;
    padding: 10px;
    border-radius: 3px;
}
.sort__fromto {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width:  240px;
}
.sort__fromto div {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.sort__fromto p {
    margin-bottom: 2px;
    color: #67A1D6;
}
.sort__fromto input {
    padding: 10px;
    border-radius: 3px;
    outline: none;
    border: 1px solid #a9a9a9;
    width: 90px;
}




.quest__placements {
  width: 100%;
  margin-bottom: 20px;
  display: flex;
  flex-wrap: wrap;   
}
    
.quest__placement {
    display: flex;
    flex-direction: column;
   
    background-color: white;
    width: 370px;
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
}
.quest__placements .quest__placement:nth-child(even){
    margin-right: 20px;
    margin-left: 20px;
}
.quest__top {
    display: flex;
    flex-direction: column;
}
.quest__top img {
    width: 100%;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}

.quest__level {
    display: flex;
    flex-direction: column;
    flex-direction: row;  
    margin-bottom: 20px;
}
.quest__level i {
    margin-right: 3px;
    color: #FFCE03;
}

.quest__bottom {
    display: flex;
    flex-direction: column;
    padding: 20px;     
}
.quest__bottom div:nth-child(1) {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.quest__bottom  p {
    margin-left: 3px;
}
.guest__location,.guest__phone {
    
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    margin-bottom: 5px;
}
.guest__location i,.guest__phone i {
    display: flex;
    align-items: center;
    width: 20px;
    height: 20px;
    color:  #DADADA;
}


.quest__bottom .q-icon {
    color: #FFCE03;
}
.quest__placename {
    font-size: 18px;
    margin-bottom: 15px;
}


.guest__seeall {
  border-radius: 3px;
  width: 200px;
  align-self: center;
  background-color: #E5E5E5;
  border: none;
  outline: none;
  color: black;
  padding: 14px;
}
.guest__seeall p {
    font-size: 16px;
}
/*----  ---- */


/*---- ----- */
.public {
  width: 100%;
  display: flex;
  justify-content: center;
}
.public__inner {
    width: 1150px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-top: 20px;
    margin-bottom: 20px;
}
.public__col1 {
    display: flex;
    flex-direction: column;
    width: 750px;
}
.public__information {
    width: 100%;
    margin-bottom: 20px;
    border-radius: 3px;
    background-color: white;
    display: flex;
    flex-direction: column;
}
.public__top {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
}
.public__logo {
    
}

.public__names {
    display: flex;
    flex-direction: column;
    width: 300px;
}
.public__name {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
}
.public__level {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
}
.public__level {
    color: #FFCE03;
}
.public__sections {
    display: flex;
    flex-direction: row;
}
.public__sections a {
    margin-right: 5px;
}
    
.public__level {
    display: flex;
    flex-direction: row;
}
.public__level .q-icon {
    margin-right: 5px;
    color: #FFCE03;
}
 
.public__center {
  
    padding: 35px;
    background-color:  #654BD8;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
}
.public__center div {
      display: flex;
      flex-direction: row;
      align-items: center;
}
.public__center p {
      color: white;
      margin-left: 10px;
}
.public__center a {
    color: white;
    margin-left: 10px;
    text-decoration: underline;
    cursor: pointer;
}
.public__center i {
    font-size: 22px;
      color: #FFCE03;
}
.public__statistics{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-bottom: 30px;
}
.public__statistics   div {
    width: 280px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    
}
.public__var {
    font-size: 20px;
}
.public__value {
    font-size: 26px;
    font-weight: bold;
}

.public__bottom {
    padding: 20px;
}

      
.public__texts {
    display: flex;
    flex-direction: column;
}
.public__title {
    margin-bottom: 20px;
}
.public__description {
    display: none;
  
}

.public__more {

    width: 100px;
    color: #654BD8;
    margin-top: 20px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    cursor: default;
}


.public__table {
  width: 710px;
  background-color: white;
  border-radius: 5px;
  padding: 20px;
}
.table__search {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}
.table__search p {
    font-size: 16px;
    font-weight: bold;
}
.table__form {
    width: 220px;
    padding: 8px;
    border-bottom: 1px solid #ccc;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}
.table__form input {
    outline: none;
    border: none;
    padding: 10px;
}

.public__col2 {
    width: 380px;
    display: flex;
    flex-direction: column;
}
.public__owninfo {
  width: 340px;
  background-color: white;

  border-radius: 3px;   
  padding: 20px;
}
.public__owninfo div {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;

}
.public__owninfo p:nth-child(1) {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
}
.public__owninfo p:nth-child(2) {
    font-size: 12px;
}


/*--- --- */


/* Image Gallery */
        /* Position the image container (needed to position the left and right arrows) */
    .container {
    position: relative;
    margin-bottom: 20px;
    }

    /* Hide the images by default */
    .mySlides {
    display: none;
    margin-bottom: 20px;
    }

    /* Add a pointer when hovering over the thumbnail images */
    .cursor {
    cursor: pointer;
    }

    /* Next & previous buttons */
    .prev,
    .next {
    cursor: pointer;
    position: absolute;
    top: 40%;
    width: auto;
    padding: 16px;
    margin-top: -50px;
    color: white;
    font-weight: bold;
    font-size: 20px;
    border-radius: 0 3px 3px 0;
    user-select: none;
    -webkit-user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
    right: 0;
    border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
    background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
    }

    /* Container for image text */
    .caption-container {
    text-align: center;
    background-color: #222;
    padding: 2px 16px;
    color: white;
    }


    .row {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 380px;
    }


    /* Six columns side by side */
    .column {
    width: 120px;
    height: 100%;
    }

    /* Add a transparency effect for thumnbail images */
    .demo {
    opacity: 0.6;
    }

    .active,
    .demo:hover {
    opacity: 1;
    }
    /*--- ---- */

    /*--- --- */
    .guide__body {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .guide__search {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        width: 670px;
    }
    .guide__search select {
        padding: 10px;
        width: 250px;
        border-radius: 3px;
    }
    .guide__form {
        width: 350px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding-right: 10px;
        background-color: white;
        border: 1px solid #a9a9a9;
        border-radius: 3px;
    }
    .guide__form input {
        border: none;
        outline: none;
        width: 350px;
        margin: 0 !important;
        border-bottom: none !important;
     
    }


    .guide__info {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .guide__countries {
        width: 250px;
        background-color: white;
        border-radius: 3px;
        padding: 20px;
    }
    .countries__title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;

    }
    .countries__item {
        margin-bottom: 10px;
    }
    .countries__item:hover {
        color: #FFCE03;
        cursor: default;
    }



    .guide__col2 {
        width: 830px;
        display: flex;
        flex-direction: column;
        padding: 20px;
        border-radius: 3px;
        background-color: white;
    }
    .col2__title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .guide__top {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .guide__top div {
        width: 40%;
        padding: 35px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #a9a9a9;
        border-radius: 3px;
    }

    .guide__center {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .guide__center div {
        width: 40%;
        padding: 35px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 1px solid #a9a9a9;
        border-radius: 3px;
    }

    .guide__bottom {
        padding: 35px;
        border: 1px solid #a9a9a9;
        border-radius: 3px;
        margin-bottom: 20px;
    
    }
    .guide__footertext {
        font-weight: bold;
    }

    .table {
        display: flex;
    }


    @media screen and (max-width: 600px) {
        .public__inner {
            width: 100%;
        }
        .guide__inner {
            width: 100%;
        }
        .guide__search {
            width: 100%;
        }
        .header__form--toggle {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 100px;
        }
        .header__lang {
            align-items:center;
            flex-direction: row;
        }
        .lang__inner {
            margin-right: 20px;
        }
        
        .header__form--toggle .fa-times {
            display: block !important;
            font-size: 28px;
        }
        .header__form--toggle .fa-times:hover {
            color: #67A1D6;
        }
        .header__menu--left {
            display: none;
            flex-direction: column;
            
            width: 80%;
            background-color: white;
            
            position: fixed;
            z-index: 20;
            padding: 30px;
            top: 0;
            left: 0;
            bottom: 0;
          
        }
        .header__labels {
            flex-direction: column;
            
            align-items: flex-start;
        }
        .header__labels a{
            margin-bottom: 20px;
        }
        .public {
            padding-top: 100px;
        }
        .header__left {
            display: none;
        }
        .header__logo {
            display: none;
        }
        .header__form {
            display: none;
        }
        .header__inner {
            width: 90%;
        }

        .header__logo--last {
            display: block;
        }
        .header__logo--last img {
            width: 70px;
            height: 70px;
        }

        .header__menu {
            display: block;
        }

        .quest__inner {
            width: 100%;
            align-items: center;
        }
        .quest__title {
            background-color: white;
            padding: 20px;
            width: 90%;
            text-align: center;
        }
        .quest__title p {
            font-size: 18px;
        }
        .quest__sort {
            width: 100%;
            flex-direction: column;
            align-items: center;
        }
        .sort__inputs select {
            margin-right: 0;
            margin-bottom: 10px;
            width: 90%;
        }
        .sort__inputs {
            width: 100%;
            flex-direction: column;
        }
        .sort__fromto {
            width: 100%;
            flex-direction: column;
        }
        .sort__fromto div {
            width: 90%;
        }

        .quest__placements {
            justify-content: center;
        }
        .quest__placement {
            margin-bottom: 20px;
            width: 90%;
        }
    }


</style>