<!doctype html>

<html lang="ru">
<head>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script type="text/javascript" src="js/bin/jquery-3.3.1.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<header class="header">
            <div class="header__inner">

                <div class="header__menu">
                    <i class="fas fa-bars" style="font-size: 25px" onclick="openToggle()"></i>
                </div>


                <div class="header__left">
                    <div class="header__logo">
                        <a href="/hotels" class="header__link"><img src="{{asset('images/kt_dark.svg')}}" ></a>
                    </div>
        
                    <div class="header__labels">
                        <a href="/description" class="">Куда доехать</a>
                        <a href="#" class="header__link">Чем заняться</a>
                        <a href="/directory" class="header__link">Запланируйте поездку</a>
                        <a href="#" class="header__link" style="color: gray">For business</a>
                        <a href="#" class="header__link" style="color: gray">MICE</a>    
                    </div>    
                </div>
               
                <div class="header__form">
                    <div class="header__lang lang"   onmouseover="showLang()">

                        <div class="lang__inner">
                            <div class="lang__type">
                                <p>RU</p>
                            </div>
                            <div class="lang__updown">
                                <i class="fas fa-chevron-up lang__up"></i>
                                <i class="fas fa-chevron-down lang__down"></i>
                         </div>
                        </div>

                        <div class="lang__value" onmouseout="hideLang()">
                                <p>KZ</p>
                                <p>RU</p>
                                <p>EN</p>
                        </div>
                    </div>

                    <div class="header__search">
                        <input type="text"  onkeyup="myFunction()" class="header__input">
                        <i class="fas fa-search" ></i>
                        <i class="fas fa-unlock"></i>
                    </div>
                </div>
                
                <div class="header__logo--last" onclick="home_back()">
                    <a href="/hotels" class="header__link"> <img src="{{asset('images/kt_dark.svg')}}" alt=""></a>
                </div>
                
            </div>

            <div class="header__menu--left">
                
            <div class="header__form--toggle">
                
                    <div class="header__lang lang"   onmouseover="showLang()">

                        <div class="lang__inner">
                            <div class="lang__type">
                                <p>RU</p>
                            </div>
                            <div class="lang__updown">
                                <i class="fas fa-chevron-up lang__up"></i>
                                <i class="fas fa-chevron-down lang__down"></i>
                            </div>
                        </div>

                        <div class="lang__value" onmouseout="hideLang()">
                                <p>KZ</p>
                                <p>RU</p>
                                <p>EN</p>
                        </div>
                        <div class="header__search">
                            <input type="text"  onkeyup="myFunction()" class="header__input">
                            <i class="fas fa-search" ></i>
                            <i class="fas fa-unlock"></i>
                        </div>

                    </div>
<!--                     
                   
                    <i class="fas fa-times" onclick="closeToggle()"></i> -->
                </div>
                <div class="header__labels">
                        <a href="/description" class="">Куда доехать</a>
                        <a href="#" class="header__link">Чем заняться</a>
                        <a href="/directory" class="header__link">Запланируйте поездку</a>
                        <a href="#" class="header__link" style="color: gray">For business</a>
                        <a href="#" class="header__link" style="color: gray">MICE</a>   
                </div> 
                
                   
   
                
            </div>
</header>

<body style="background-image: url('/images/bg.png');background-size: cover">
@yield('content')

</div>

<div id="public__inner">
    

</div>

<div id="public__description"></div>

</main>
</body>


<script>
    function home_back() { 
        
        document.querySelector('#public__inner').style.cssText ="display: none"; 
        document.querySelector('.quest__inner').style.cssText ="display: block"; 
        
    }
    function directory() {

        document.querySelector('#public__inner').style.cssText ="display: block"; 
        document.querySelector('.quest__inner').style.cssText ="display: none"; 
        
        $("#public__inner").load("/directory/");
    }
    function openToggle() {
        document.querySelector('.header__menu--left').style.cssText ="display: flex; ";
    }
    function closeToggle() {
        document.querySelector('.header__menu--left').style.cssText ="display: none; ";
    }


function showLang() {
        document.querySelector('.lang__value').style.display = "flex";
        document.querySelector('.lang__up').style.display = "none !important";
        document.querySelector('.lang__down').style.display = "flex !important";
    }
    function hideLang() {
        document.querySelector('.lang__value').style.display = "none";
        document.querySelector('.lang__up').style.display = "flex";
        document.querySelector('.lang__down').style.display = "none";
    }

   
    $(".header__logo").click(function(){
        window.location.replace("http://eqonaqpublic");
    });

    $(".fa-search").click(function(){
        $(".header__input").animate({
            width: 'toggle'
        },"slow");
    });


    

    $(".quest__placement").click(function(){

        window.location.href = "http://127.0.0.1:8000/description";
      
    });
  

    $(".public__more").click(function(){ 
        $(".public__description").animate({
            height: 'toggle'
        },"slow");

    });
      
  

</script>
<style>
    .quest__bottom {
        display: flex;
        flex-direction: column;
        padding: 10px;
    }
    .quest__level {
        display: flex;
        flex-direction: column;
        flex-direction: row;
        padding-bottom: 5px;
    }

   
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
.header__menu {
    display: none;
}
.header__left {
    width: 850px;
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
.header__form,.header__form--toggle {
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
    display: none !important;
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

    display: block !important;
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
        display: block !important;
        padding: 10px;
        width: 250px;
        border-radius: 3px;
    }
    /* .guide__form {
        width: 350px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: white;
        border: 1px solid #a9a9a9;
        border-radius: 3px;
    } */
    .guide__form input {
        border: none;
        outline: none;
        width: 350px;
     
    }


    .guide__info {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
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

    .header__form--toggle  {
        display: none;
    }

    .header__menu--left {
        display: none;
    }
    .header__logo--last {
        display: none;
    }
    @media screen and (max-width: 600px) {
        .public__inner {
            width: 100%;
        }
        .guide__inner {
            width: 100%;
            align-items: center;
        }
        .quest__title {
            width: 100%;
        }
        .guide__search {
            width: 100%;
            flex-direction: column;
        }
        .guide__search select {
            width: 90%;
            margin-bottom: 10px;
        }
        .guide__form {
            width: 90%;
        }
        .guide__countries {
            width: 90%;
        }
        .guide__col2 {
            width: 90%;
        }
        .guide__info {
            flex-direction: column;
            align-items:center;
        }
        .guide__top {
            flex-direction: column;
            margin: 0;
        }
        .guide__top div {
            width: 100%;
            margin-bottom: 20px;
        }
        .guide__center {
            flex-direction: column;
            margin: 0;
        }
        .guide__center div {
            width: 100%;
            margin-bottom: 20px;
        }
        .guide__bottom {
            flex-direction: column;
        }
        .guide__bottom div {
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
</html>


