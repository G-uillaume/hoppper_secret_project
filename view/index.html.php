<?php $title = 'Users'; ?>

<?php ob_start(); ?>
<main>
    <div>
        <?php
        if ($_SESSION['account_type'] !== 'NORMAL') {
        ?>
            <div class="dropdown" id="btndrop">
                <button class="dropbtn">Order by : </button>
                <div id="myDropdown" class="dropdown-content drop">
                    <a href="index.php?view=users&order=firstname">Firstname</a>
                    <a href="index.php?view=users&order=lastname">Lastname</a>
                    <a href="index.php?view=users&order=country">Country</a>
                    <a href="index.php?view=users&order=account_type">Account type</a>
                </div>
            </div>
            <?php
        } 
        ?>
        <table>
        <?php
            foreach ($results as $row) {
                ?>
                <tr>
                    <td><?= $row['firstname']; ?></td>
                    <td><?= $row['lastname']; ?></td>
                    <td><?= $row['account_type']; ?></td>
                    <td><?= $row['country']; ?></td>
                    <td><button><a href="index.php?view=users&p=details&id=<?= $row['id']; ?>">details</a></button></td>
                    <?php
                    if ($_SESSION['account_type'] === 'ADMIN' && $row['account_type'] !== 'ADMIN') {
                        ?>
                        <td><button><a href="index.php?view=users&p=edit&id=<?= $row['id']; ?>">edit</a></button></td>
                        <?php
                    } else if ($row['id'] === $_SESSION['user_id']){
                        ?>
                        <td><button><a href="index.php?view=users&p=edit&id=<?= $row['id']; ?>">edit</a></button></td>
                        <?php
                    } else {
                        ?>
                        <td></td>
                        <?php
                    }
                    if (isAdmin($_SESSION['user_id'])) {
                    ?>
                        <td><button><a href="index.php?view=users&p=delete&id=<?= $row['id']; ?>">delete</a></button></td>
                    <?php
                    }
                    ?>
                    <td><button><a href="index.php?view=posts&p=postsUser&id=<?= $row['id'] ?>">See posts</a></button>
                </tr>
                <?php
            }
        ?>
        </table>
        <?php
            $nbPages = ceil($count / 25);
            for ($i = 1 ; $i <= $nbPages; $i++) {
                ?>  
                    <a href="index.php?view=users&page=<?= $i - 1; ?>&order=<?= $_SESSION['order']; ?>"><?= $i; ?></a>
                <?php
            }
        ?>
    </div>
    <div>
        <button><a href="index.php?view=posts&p=all">See all posts</a></button>
        <button><a href="index.php?view=users&p=logout">Logout</a></button> <!-- C'EST LE MAAAAAAAAL -->
    </div
</main>
<?php $content = ob_get_clean(); ?>
<?php require_once('template.php'); ?>