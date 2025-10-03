<?php
if (count($errors)): ?>

    <div class="alert alert-danger ml-3 mt-3 mr-3">
        <?php foreach ($errors as $error): ?>
            <p> <?php echo $error ?> </p>

        <?php endforeach; ?>
    </div>

<?php
endif;
