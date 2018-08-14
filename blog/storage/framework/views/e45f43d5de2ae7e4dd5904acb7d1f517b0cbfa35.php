<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <meta charset="utf-8">
    <title>Laravel</title>

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-8"> <?php echo $__env->yieldContent('content'); ?> </div>
    </div>
</div>
</body>

</html>