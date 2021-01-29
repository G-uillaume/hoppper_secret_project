<?php $title = 'Posts'; ?>

<?php ob_start(); ?>

<button><a href="index.php?view=users">Return</a></button>
<?php
if (!empty($posts)) {
    // echo "<pre>";
    // print_r($posts);
    // echo "</pre>";
    foreach($posts as $post) {
        ?>
        <div class="post">
        <h2><?= strtoupper($post['firstname']) ?> <?= strtoupper($post['lastname']) ?>, le <?= $post['date_fr'] ?></h2>
            <?php
            // print_r(explode(",", $post['tags']));

            foreach(json_decode($post['tags'], true) as $title => $color) {
                ?>
                <h3 class="tags" style="background-color: <?= $color ?>;"><?= $title ?></h3>
                <?php
            }
            ?>
            <p><?= $post['content'] ?></p>
        </div>
        <?php
    }
    if ($count > 10) {
        $nbPages = ceil($count / 10);
        for ($i = 1; $i <= $nbPages; $i++) {
            ?>
            <a href="index.php?view=posts&p=<?= $_GET['p'] ?>&page=<?= $i - 1 ?>"><?= $i ?></a>
            <?php
        }
    }
    ?>
    <?php
} else {
    ?>
    <h2>There are no posts from this user !</h2>
    <?php
}

$content = ob_get_clean();

require_once('template.php');