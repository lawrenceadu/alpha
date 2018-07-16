<!DOCTYPE html>
<html lang="en">
<head>

    <base href="/">
    <title><?= (isset($data) && isset($data["title"]))? $data["title"] : __SITENAME__ ?></title>
    
    <!-- meta data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= __AUTHOR__ ?>">
    <meta name="keywords" content="<?= (isset($data) && isset($data["keywords"]))? $data["keywords"] : "" ?>">
    <meta name="description" content="<?= (isset($data) && isset($data["description"]))? $data["description"] : "" ?>">  

    <!-- meta og -->
    <meta property="og:image" content="<?= (isset($data) && isset($data["img"]))? $data["img"] : '/public/assets/img/logo/logo.png' ?>">
    <meta property="og:description" content="<?= (isset($data) && isset($data["description"]))? $data["description"] : "" ?>">
    <meta property="og:title" content="<?= (isset($data) && isset($data["title"]))? $data["title"] : __SITENAME__ ?>">
    <meta name="theme-color" content="#F44336">
    
    <!-- css assets -->
    <link rel="stylesheet" href="public/assets/css/app.css?v=0.0.1">
    <link rel="shortcut icon" href="public/assets/img/logo/favicon.ico">
    <link rel="manifest" href="public/manifest.json">

    <!-- js assets -->
    <?php foreach(["jquery","turbolinks","app"] as $js): ?>
    <script type="text/javascript" src="public/assets/js/<?= $js ?>.js"></script>
    <?php endforeach; ?>
</head>
<body>
    <main class="u-full-height u-full-width position-relative">