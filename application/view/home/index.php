<!--Método dado por la librería plates-->
<?php $this->layout('layout') ?>

<!--Método dado por la librería plates-->
<?php $this->insert('partials/banner',['dato'=>'Dato que enviamos al banner']) ?>

<div class="container">
    <?= $titulo ?>
    <p>Estoy en la página principal de la aplicación</p>
</div>
