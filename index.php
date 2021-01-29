<?php
session_start();
// session_destroy();

require_once('models/functions.php');
require_once('controllers/controller.php');
require_once('controllers/postController.php');

if (isAuthenticated()) {
    if (isset($_GET['view'])) {
        if ($_GET['view'] === 'users') {
            if (isset($_GET['p'])) {
                $page = $_GET['p'];
                if ($page === 'logout') {
                    quit();
                } else if ($page === 'edit') {
                    edit();
                } else if ($page === 'details') {
                    details();
                } else if ($page === 'delete') {
                    delete();
                } else if ($page === 'editValidate') {
                    editValidate();
                }
            } else {
                $order = 'firstname';
                $possibleOrder = ['firstname', 'lastname', 'country', 'account_type'];
                if (isset($_GET['order']) && in_array($_GET['order'], $possibleOrder)) {
                    $order = $_GET['order'];
                    if (isset($_GET['page'])) {
                        index($order, $_GET['page']);
                    }
                }
                index($order, 0);
            }
        } else if ($_GET['view'] === 'posts') {
            if (isset($_GET['p'])) {
                if ($_GET['p'] === 'all') {
                    if (isset($_GET['page'])) {
                        allPosts($_GET['page']);
                    } else {
                        allPosts(0);
                    }
                } else if($_GET['p'] ==='postsUser') {
                    if (isset($_GET['page'])) {
                        postsByUser($_GET['page']);
                    } else {
                        postsByUser(0);
                    }
                }
            }
        }
    } else {
        $order = 'firstname';
        index($order, 0);
    }
} else {
    if (isset($_GET['p'])) {
        $page = $_GET['p'];
        if ($page === 'signup') {
            signUp();
        } else if ($page === 'logValidate') {
            logValidate();
        } else if ($page === 'signUpValidate') {
            signUpValidate();
        }
    } else {
        logForm();
    }
}