<?php
    function enTete($titre)
    {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../vue/perso.css" />
        <!--[if lt IE 9]>
        <![endif]-->
        <title><?php echo $titre; ?></title>
    </head>
    <body>
        <div class="fondBleu">
            <div class="container">
                <header class="row">
                    <h1 class="enTete col-xxl-12 col-xl-12 col-sm-12">BILLET SIMPLE POUR L'ALASKA</h1>
                </header>
<?php
    }
?>