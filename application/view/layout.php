<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $titulo ?? 'Mini3' ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/hojaestilos.css" rel="stylesheet">
</head>
<body>
<!-- logo, check the CSS file for more info how the logo "image" is shown -->
<!--<div class="logo"></div>-->

<?php $this->insert('partials/menu') ?>

<!--Método dado por la librería plates-->
<?= $this->section('content') ?>

<div class="footer">
    Find <a href="https://github.com/panique/mini3">MINI3 on GitHub</a>.
    If you like the project, support it by <a href="http://tracking.rackspace.com/SH1ES">using Rackspace</a> as your hoster [affiliate link].
</div>

<!-- jQuery, loaded in the recommended protocol-less way -->
<!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
<script>
    var url = "<?php echo URL; ?>";
</script>

<!-- our JavaScript -->
<script src="<?php echo URL; ?>js/application.js"></script>
</body>
</html>
