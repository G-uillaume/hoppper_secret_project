<?php $title = 'Login'; ?>

<?php ob_start(); ?>

<main>
    <form action="index.php?view=users&p=logValidate" method="post">
        <p>
            <label for="email">Email : </label>
            <input type="email" id="email" name="email">
        </p>
        <p>
            <label for="password">Password : </label>
            <input type="password" name="password" id="password">
        </p>
        <p>
        <button type="submit">Log in</button>
        <button><a href="index.php?view=users&p=signup">Sign up</a></button>
        </p>
    </form>
</main>
<?php $content = ob_get_clean(); ?>
<?php require_once('template.php'); ?>