
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="stylesheet" type="text/css"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap-datepicker.css">
        <!--    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script type="text/javascript" src="./bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="./index.js"></script>
        <script type="text/javascript" src="./jquery.bootpag.js"></script>
    </head>

    <body>
    <style>
        .container-form {
            width: 600px;
            height: 170px; /* Размеры */
            outline: 2px solid #000; /* Чёрная рамка */
            padding-top: 20px;
        }

        #table {
            margin-top: 40px;
        }

        .image {
            overflow: hidden;
            width: 38px;
            height: 25px;
        }

        .image {
            -moz-transition: all 0.5s ease-out;
            -o-transition: all 0.5s ease-out;
            -webkit-transition: all 0.5s ease-out;
        }

        .image:hover {
            -webkit-transform: scale(4);
            -moz-transform: scale(4);
            -o-transform: scale(4);
        }


    </style>
    <div class="container-fluid">
        <div class="row">

            <h2 style="padding-left: 12px">Реестр сотрудников</h2>
            <div class="form-class">
                <div class="col-md-12">
                    <div class="text-right col-md-5">
                        <a href="./add_worker.php">+ Добавить сотрудника</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="container-form" style="margin-top: 20px">

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                            <span class="input-group-btn">
                                 <button class="btn btn-default" type="button" id="search_button">Поиск</button>
                            </span>
                                    <input type="text" class="form-control" id="search_input">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="col-md-4 contol-label">
                                    Пол:
                                </label>
                                <label class="col-md-8 contol-label">
                                    Возраст:
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox col-md-4">
                                    <label>
                                        <input type="checkbox" id="male_check"> Муж
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="from" placeholder="С">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox col-md-4">
                                    <label>
                                        <input type="checkbox" id="female_check"> Жен
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="To" placeholder="По">
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        <table class="table table-bordered table-hover" id="table">
            <thead>
            <tr>
                <th style="width: 100px">
                    № id
                </th>
                <th style="width: 100px">
                    Фото
                </th>
                <th style="width: 100px">
                    ФИО
                </th>
                <th style="width: 100px">
                    Возраст
                </th>
                <th style="width: 100px">
                    Пол
                </th>
                <th style="width: 100px">
                    Действие
                </th>
            </tr>
            </thead>
            <tbody class="reestr_table">
            </tbody>
        </table>
    </div>
    <div class="pagination">

    </div>
    </body>
    </html>

<?php


?>