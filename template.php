<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <title><?=$title;?></title>
</head>

<body>
    <section id="header" >
        <div class="container-fluid px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="col-md-6 col-lg-5 col-11 mx-auto my-auto">
                <div class="input-group form-container">
                    <h1 class="search-title mb-5 fs-3">Найдите информацию о московских учебных учреждения и сведения об участии в олимпиадах</h1>
                    <input type="text" id="search" name="search" class="form-control search-input" autofocus="autofocus" autocomplete="off" placeholder="Начните вводить название учебного учреждения...">
                    <span class="input-group-btn">
                        <button id="search-btn" class="btn btn-search fs-5" data-id>&nbsp;Найти&nbsp;</button>
                    </span>
                    <div id="autocomplete-list" class="autocomplete-items"></div>
                </div>
                <div class="mt-5 d-flex justify-content-center">
                    <?php if(isset($_GET['id'])): ?>
                    <a onClick="document.getElementById('main-info').scrollIntoView();">
                        <img id="down-arrow" width="50px" src="source/arrow.png" alt="arrow">
                    </a>
                    <?php endif; ?>
                </div>
                <p class="fs-1">&nbsp;</p>
            </div>
                             
        </div>
    </section>
    
    <?php if(isset($_GET['id'])): ?>
    <section id="main-info" class="py-5 text-center">
        <h2><?=$title;?></h2>
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-10 mx-auto">
                    <div class="row gx-5 row-cols-1 row-cols-md-3">
                        <div class="col mb-md-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                            <h3 class="h5 fw-bolder">Полное наименование</h3>
                            <p class="mb-0"><?=$fullName;?></p>
                        </div>
                        <div class="col mb-md-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-building"></i></div>
                            <h2 class="h5 fw-bolder">Тип организации</h2>
                            <p class="mb-0"><?=$type;?></p>
                        </div>
                        <div class="col mb-md-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                            <h2 class="h5 fw-bolder">Адрес</h2>
                            <p class="mb-0"><?=$address;?></p>
                        </div>
                    </div>
                    <div class="row gx-5 row-cols-1 row-cols-md-3">
                        <div class="col mb-md-0 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                            <h2 class="h5 fw-bolder">Веб-сайт</h2>
                            <a href="http://<?=$website;?>" class="mb-0 text-decoration-none"><?=$website;?></a>
                        </div>
                        <div class="col h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                            <h2 class="h5 fw-bolder">Email</h2>
                            <a href="mailto:<?=$email;?>" class="mb-0 text-decoration-none"><?=$email;?></a>
                        </div>
                        <div class="col h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                            <h2 class="h5 fw-bolder">Телефон</h2>
                            <a href="tel:<?=$phone;?>" class="mb-0 text-decoration-none"><?=$phone;?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="olympiads-info" class="py-5 text-center">
        <h2>Участие в олимпиадах</h2>
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-3 mx-auto info-menu pb-5">
                    <h3 class="mt-3 mb-5 fs-4">Сортировка</h3>

                    <label for="menu-type">Тип олимпиады</label>
                    <select class="form-select menu" id="menu-type">
                        <option value="" selected>Выберите тип олимпиады...</option>
                        <?=$olympiad_types;?>
                    </select>

                    <label for="menu-type">Призовое место</label>
                    <select class="form-select menu" id="menu-status">
                        <option value="" selected>Выберите призовое место...</option>
                        <option value="победитель">Победитель</option>
                        <option value="призёр">Призер</option>
                    </select>

                    <label for="menu-subject">Предмет</label>
                    <select class="form-select menu" id="menu-subject">
                        <option value="" selected>Выберите предмет...</option>
                        <?=$subjects;?>
                    </select>

                    <label for="menu-class">Класс</label>
                    <select class="form-select menu" id="menu-class">
                        <option value="" selected>Выберите класс...</option>
                        <?=$classes;?>
                    </select>

                    <label for="menu-year">Год участия</label>
                    <select class="form-select menu" id="menu-year">
                        <option value="" selected>Выберите год участия...</option>
                        <?=$years;?>
                    </select>

                </div>

                <div class="col-lg-9 mx-auto info-results">
                    <h3 class="my-3 fs-4">Результаты</h3>
                    <div class="info-results-olympiads">

                    </div>
                </div>
            
            </div>
        </div>
    </section>
   
    <!-- Футер
    <div>Icons made by <a href="https://www.flaticon.com/authors/eucalyp" title="Eucalyp">Eucalyp</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
    <?php endif; ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="scripts/main.js"></script>
<script type="text/javascript" src="scripts/olympiads.js"></script>
</html>