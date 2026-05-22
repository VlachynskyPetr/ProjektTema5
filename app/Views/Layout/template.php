<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zavodnici z Francie</title>
    <?= $this->include('layout/css'); ?>
    
 
    <style>body {
    margin: 0;
    min-height: 200vh;

    background-image: url("img/pozadiKolo.png");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
        
    /* obrázek zůstane při scrollu */
    background-attachment: fixed;
    
}


</style>
</head>
<body >

    <div class="container">
        
<?= $this->renderSection('content'); ?>
</div>
</body>
</html>