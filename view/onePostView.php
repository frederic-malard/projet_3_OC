<!--
A REECRIRE !!!!!!!!!!!!!
traduire, virer les fonction, garder les while et if, donner des noms simples aux variables.
-->

<!-- show post -->
<section class="row">
    <article class="col-xxl-12 col-xl-12 col-sm-12 post">
        <h4><?= $postTitle ?></h4>
        <p class="float-right onePostDate">Le <?= $postDateTimePub ?></p>
        <div class="row" id="parent">
            <div class="col-xxl-6 col-xl-12 col-sm-12">
                <p id="content"></p>
                <!-- pagination -->
                <p id="shouldAppear"></p>
                <p id="shouldNotAppear"></p>
            </div>
        </div>
        <hr />
    </article>
    <article class="col-xxl-12 col-xl-12 col-sm-12">
<?php
    if ($error)
    {
?>
        <p class="alert alert-danger" role="alert">Erreur : <?= $message; ?></p>
<?php
    }
?>
<?php
    if ($sent)
    {
?>
        <p class="alert alert-success" role="alert"><?= $message; ?></p>
<?php
    }
?>
        <form method="post">
            <h4>Ecrivez un commentaire :</h4>
            <p>
                <label for="login">votre pseudo :  </label><input type="text" id="login" name="login" maxlength="30" /><br />
                <!-- suppr mail ? Y est pas dans BDD -->
                <label for="email">votre email (pour vous prévenir en cas de modération) : </label><input type="email" id="email" name="email" />
            </p>
            <p>
                <label for="message">Votre message :</label><br />
                <textarea id="message" name="message"></textarea>
            </p>
            <p>
                <input type="submit" value="Valider" />
            </p>
        </form>
        <hr />
    </article>
<!-- show all comments relatives to the post -->
    <article class="col-xxl-12 col-xl-12 col-sm-12">
        <h4>commentaires</h4>
<?php
    foreach($comments as $comment) // reste à réadapter noms dessous pour tableau
    {
?>
        <div class="hidden-xl-down col-xxl-3"></div>
        <div class="col-xxl-6 col-xl-12 col-sm-12 bulle">
            <p><?= $comment['visitorLogin'] ?><span class="float-right">Le <?= $comment['dateTime'] ?></span></p>
            <p class="dernier"><?= $comment['content'] ?></p>
        </div>
<?php
    }
?>
    </article>
</section>