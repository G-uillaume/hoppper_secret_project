<?php
require_once('models/postsFunctions.php');

function allPosts($page) {
    $posts = getAllPosts($page);
    $count = getPostsCount();
    // $posts = getPostsByTags('food');
    require_once('view/posts.php');
}

function postsByUser($page) {
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $count = getPostsCountById($_GET['id']);
        $posts = getPostsByUser($_GET['id'], $page);
        require_once('view/posts.php');
    }
}