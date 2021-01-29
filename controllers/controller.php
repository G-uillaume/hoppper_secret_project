<?php
require_once('models/functions.php');

function index($order, $page) {
    $count = getCount($_SESSION['user_id']);
    $results = queryUsers($_SESSION['user_id'], $order, $page);

    require_once('view/index.html.php');
}

function logForm() {
    require_once('view/loginForm.html.php');
}

function quit() {
    logout();
    header('Location: index.php');
}

function edit() {
    if (isAdmin($_SESSION['user_id'])) {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $userInfo = queryUserById($_GET['id']);
        }
    } else {
        $userInfo = queryUserById($_SESSION['user_id']);
    }   
    require_once('view/edit.php');
}

function delete() {
    if (isAdmin($_SESSION['id'])) {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $affectedLines = deleteUser($_GET['id']);
            if (!$affectedLines) {
                echo "Il y a eu une erreur !";
            } else {
                header('Location: index.php?view=users');
            }
        }
    } else {
        ?>
        <p>Vous n'avez pas les droits pour suppprimer un profile</p>
        <?php
    } 
}

function details() {
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $userInfo = queryUserById($_GET['id']);
    }
    require_once('view/details.php');
}

function signUp() {
    require_once('view/signForm.php');
}

function logValidate() {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        if (login($_POST['email'], $_POST['password']) === true) {
            header('Location: index.php?view=users');
        } else {
            echo login($_POST['email'], $_POST['password']);
        }
    }
}

function editValidate() {
    if (isset($_GET['id']) && isset($_GET['type'])) {
        if ($_GET['type'] === 'ADMIN') {
            if (!empty($_POST['account_type'])) {
                $affectedLines = editUserWhenAdmin($_GET['id'], $_POST['account_type']);
                if (!$affectedLines) {
                    echo "Il y a eu une erreur !";
                } else {
                    header('Location: index.php?view=users');
                }
            }
        } else if ($_GET['type'] === 'ADMINSELF' || $_GET['type'] === 'NORMALSELF' || $_GET['type'] === 'MODERATORSELF') {
            if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['country']) && !empty($_POST['password'])) {
                $affectedLines = editUserWhenNormal($_SESSION['user_id'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['country'], $_POST['password']);
                if (!$affectedLines) {
                    echo "Il y a eu une erreur !";
                } else {
                    header('Location: index.php?view=users');
                }
            }
        }
    }
}

function signUpValidate() {
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['country']) && !empty($_POST['password'])) {
        // $affectedLines = createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['country'], $_POST['password']);
        try {
            if ($affectedLines = createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['country'], $_POST['password'])) {
                header('Location: index.php');
            } else {
                throw new Exception('Impossible d\'ajouter cet utilisateur');
            }
        } catch(Exception $e) {
            echo 'Impossible d\'ajouter cet utilisateur';
        }
    }
}