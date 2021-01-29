<?php
require_once('db.php');

function getAllPosts($page = 0) {
    $db = dbConnect();
    $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT) * 10;
    $req = $db->query("SELECT 
    JSON_OBJECTAGG(t.title, t.color) AS tags,
    ANY_VALUE(DATE_FORMAT(p.date, '%d/%m/%Y à %Hh%imin%ss')) AS date_fr,
     ANY_VALUE(p.date), 
     ANY_VALUE(p.content) AS content, 
     ANY_VALUE(u.firstname) AS firstname, 
     ANY_VALUE(u.lastname) AS lastname
     FROM posts_has_tags AS pht
        INNER JOIN tags AS t
        ON pht.fk_tags_id = t.id
            INNER JOIN posts AS p
            ON p.id = pht.fk_posts_id
                INNER JOIN users AS u
                ON u.id = p.fk_author_id
                    GROUP BY p.id
                    ORDER BY ANY_VALUE(p.date) DESC
                    LIMIT {$page}, 10
                ");
    return $req->fetchAll();
}

function getPostsByUser($user_id, $page = 0) {
    $db = dbConnect();
    $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT) * 10;
    $req = $db->prepare("SELECT 
    JSON_OBJECTAGG(t.title, t.color) AS tags,
    ANY_VALUE(DATE_FORMAT(p.date, '%d/%m/%Y à %Hh%imin%ss')) AS date_fr,
    ANY_VALUE(p.date), 
    ANY_VALUE(p.content) AS content, 
    ANY_VALUE(u.firstname) AS firstname, 
    ANY_VALUE(u.lastname) AS lastname
     FROM posts_has_tags AS pht
        INNER JOIN tags AS t
        ON pht.fk_tags_id = t.id
            INNER JOIN posts AS p
            ON p.id = pht.fk_posts_id
                INNER JOIN users AS u
                ON u.id = p.fk_author_id
                    WHERE u.id = ?
                    GROUP BY p.id
                    ORDER BY ANY_VALUE(p.date) DESC
                    LIMIT {$page}, 10
                    ");
    $req->execute([ $user_id ]);
    return $req->fetchAll();
}

function getPostsByTags($tag) {
    $db = dbConnect();
    $req = $db->prepare('SELECT 
    JSON_OBJECTAGG(t.title, t.color) AS tags,
    ANY_VALUE(DATE_FORMAT(p.date, "%d/%m/%Y à %Hh%imin%ss")) AS date_fr,
    ANY_VALUE(p.date), 
    ANY_VALUE(p.content) AS content, 
    ANY_VALUE(u.firstname) AS firstname, 
    ANY_VALUE(u.lastname) AS lastname
     FROM posts_has_tags AS pht
        INNER JOIN tags AS t
        ON pht.fk_tags_id = t.id
            INNER JOIN posts AS p
            ON p.id = pht.fk_posts_id
                INNER JOIN users AS u
                ON u.id = p.fk_author_id
                    WHERE t.title = ?
                    GROUP BY p.id
                    ORDER BY ANY_VALUE(p.date) DESC
                    ');
    $req->execute([ $tag ]);
    return $req->fetchAll();
}

function getPostsCount() {
    $db = dbConnect();
    $req = $db->query("SELECT COUNT(*) AS count FROM posts");
    $count = $req->fetch();
    return $count['count']; 
}

function getPostsCountById($author_id) {
    $db = dbConnect();
    $req = $db->prepare("SELECT COUNT(*) AS count FROM posts WHERE fk_author_id = ?");
    $req->execute([ $author_id ]);
    $count = $req->fetch();
    return $count['count']; 
}