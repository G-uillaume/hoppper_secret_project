<?php $title = 'Edit'; ?>
<?php ob_start();?>
<main>
<?php
    if (isAdmin($_SESSION['user_id'])) {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if ($_SESSION['user_id'] == $_GET['id']) {
                include('userForm.php');
            } else {
                include('adminForm.php');
            }
        }
    } else {
        include('userForm.php');
    }
?>
<div>
    <button><a href="index.php?view=users">Retour</a></button>
</div>
</main>
<?php $content = ob_get_clean(); ?>
<?php require_once('template.php'); ?>