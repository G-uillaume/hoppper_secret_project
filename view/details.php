<?php $title = 'Details'; ?>
<?php
// require_once('functions.php');
// if (isset($_GET['id']) && $_GET['id'] > 0) {
//     $userInfo = queryUserById($_GET['id']);
// }
?>
<?php ob_start(); ?>
<main>
    <table>
        <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Account Type</th>
            <th>Country</th>
        </tr>
        <tr>
            <td><?= $userInfo['firstname']; ?></td>
            <td><?= $userInfo['lastname']; ?></td>
            <td><?= $userInfo['email']; ?></td>
            <td><?= $userInfo['account_type']; ?></td>
            <td><?= $userInfo['country']; ?></td>
        </tr>
    </table>
    <div>
        <button><a href="index.php?view=users">Retour</a></button>
    </div>
</main>
<?php $content = ob_get_clean(); ?>
<?php require_once('template.php'); ?>