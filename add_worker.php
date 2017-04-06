<?php
require_once 'database.php';
if (isset($_GET[id])) {
    $sqlsch = "SELECT workers.*, files.file_path FROM workers 
LEFT JOIN files ON files.id = workers.photo_id 
WHERE workers.id = " . $_GET['id'];
    $search = Database::sqlQueryWithResult($sqlsch)[0];
}
?>


    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="stylesheet" type="text/css"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap-datepicker.css">
        <script type="text/javascript"
                src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script type="text/javascript" src="./bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="./add_worker.js"></script>
    </head>
    <body>
    <style>
        .container-fluid {
            text-align: center;
        }

        .form-group {
            padding: 20px;
        }

        .control-label {
            padding-top: 6px;
        }
    </style>
    <div class="container-fluid">
        <h2><?= isset($_GET['id']) ? "Редактирование сотрудника" : "Создание сотрудника" ?></h2>
        <div class="row">
            <div class="col-md-4 col-xs-offset-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="container-form">

                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Фамилия:
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="surname" placeholder="Введите фамилия..."
                                       value="<?= $search['surname'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Имя:
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="name" placeholder="Введите имя..."
                                       value="<?= $search['name'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Отчество:
                            </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="patronymic"
                                       placeholder="Введите отчество..." value="<?= $search['patronymic'] ?> ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" id="datepic">
                                Дата рождения:
                            </label>
                            <div class="input-group input-append date col-md-9" id="dateRangePicker">
                                <input type="text" class="form-control" name="date"
                                       value="<?= $search['date_birthday'] ?>" required>
                                <span class="input-group-addon add-on"><span
                                            class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Пол:
                            </label>
                            <div class="col-md-9">
                                <select class="form-control" name="gender" required>
                                    <option value="male" <?= $search['gender'] == "male" ? "selected" : "" ?>>Мужской
                                    </option>
                                    <option value="female" <?= $search['gender'] == "female" ? "selected" : "" ?>>
                                        Женский
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Фото:
                            </label>
                            <div class="col-md-9">
                                <input type="file" name="image" <?= isset($_GET['id']) ? "" : "required" ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php if (isset($_GET['id'])): ?>
                                <button class="btn btn-default" type="submit" name="but_edit">Редактировать</button>
                            <?php else: ?>
                                <button class="btn btn-default" type="submit" name="but_save">Сохранить</button>
                            <?php endif; ?>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>

    </body>
    </html>

<?php
if (isset($_POST['but_save'])) {
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    $expensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $expensions) === false) {
        $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
        echo "Extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 200000) {
        $errors[] = 'File size must be excately 200 kb';
        echo "File size must be excately 200 kb";
    }

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "images/" . $file_name);
//        die(print_r($_POST['date']));
        $sql = "INSERT INTO files (file_path)  VALUES
            ('/images/" . $file_name . "')";
        if ($id = Database::sqlQuery($sql)) {
            $sql = "INSERT INTO workers (name, surname, patronymic, date_birthday, gender, photo_id)  VALUES
            ('" . $_POST['name'] . "',
            '" . $_POST['surname'] . "',
            '" . $_POST['patronymic'] . "',
            '" . $_POST['date'] . "',
            '" . $_POST['gender'] . "', 
            '" . $id . "')";
            if (Database::sqlQuery($sql)) {
                echo "<script>window.location.replace('/index.php');</script>";
            }
        }
    }


}

if (isset($_POST['but_edit'])) {
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    $expensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $expensions) === false) {
        if (!empty($file_name)) {
            $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
            echo "Extension not allowed, please choose a JPEG or PNG file.";
        }
    }
    if ($file_size > 200000) {
        if (!empty($file_name)) {
            $errors[] = 'File size must be excately 200 kb';
            echo "File size must be excately 200 kb";
        }
    }
    if (empty($errors) == true && isset($_POST['but_edit'])) {
        if (!empty($file_name)) {
            move_uploaded_file($file_tmp, "images/" . $file_name);
            $sql = "UPDATE files SET file_path = '/images/" . $file_name . "' WHERE id = (SELECT photo_id FROM workers WHERE id = " . $_GET['id'] . ")";
            Database::sqlQuery($sql);
        }
        $sql = "UPDATE workers 
                  SET name = '" . $_POST['name'] . "', 
                      surname = '" . $_POST['surname'] . "', 
                      patronymic = '" . $_POST['patronymic'] . "', 
                      date_birthday = '" . $_POST['date'] . "', 
                      gender = '" . $_POST['gender'] . "' 
                      WHERE id = " . $_GET['id'];
        Database::sqlQuery($sql);
        echo "<script>window.location.replace('/index.php');</script>";

    }
}


?>