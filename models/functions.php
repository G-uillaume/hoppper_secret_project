<?php

require_once('db.php');

function getUserType($user_id) {
    $db = dbConnect();
    $req = $db->prepare('SELECT account_type FROM users WHERE id = ?');
    $req->execute([ $user_id ]);
    $result = $req->fetch();
    return $result['account_type'];
}

function session_start_once() {
    if(session_status() == PHP_SESSION_NONE){
      return session_start();
    }
}

function login($email, $password){
    session_start_once();

    $db = dbConnect();
    $req = $db->prepare('SELECT id, firstname, lastname, country,  password, account_type from users WHERE email=?');
    $req->execute([
        filter_var($email, FILTER_SANITIZE_EMAIL)
        ]);
    $results = $req->fetch();
    if (!empty($results)) {
        if(password_verify($password, $results['password'])){
            $_SESSION['order'] = 'firstname';
            $_SESSION['user_id'] = $results['id'];
            $_SESSION['firstname'] = $results['firstname'];
            $_SESSION['lastname'] = $results['lastname'];
            $_SESSION['account_type'] = $results['account_type'];
            $_SESSION['country'] = $results['country'];
            $_SESSION['email'] = $email;
            return true;
        } else {
            return "Wrong Password";
        }
    } else {
        return "Wrong email adress !";
    }
  }

function isAuthenticated() {
    session_start_once();
    return !empty($_SESSION['user_id']);
}

function isAdmin() {
    session_start_once();
    return isAuthenticated() && $_SESSION['account_type'] == 'ADMIN';
}

function queryUsers($user_id, $order, $page = 0) {
    $_SESSION['order'] = filter_var($order,  FILTER_SANITIZE_STRING);
    $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT) * 25;
    $db = dbConnect();
    $user = queryUserById($user_id);

    if ($user['account_type'] === 'NORMAL') {
        return [$user];
    } else if ($user['account_type'] === 'ADMIN') {
        $query = $db->query("SELECT * FROM users ORDER BY {$_SESSION['order']} LIMIT {$page}, 25");
        // $query->execute([ filter_var($order, FILTER_SANITIZE_STRING) ]);
    } else if ($user['account_type'] === 'MODERATOR') {
        $query = $db->query("SELECT * FROM users WHERE NOT account_type = 'ADMIN' ORDER BY {$_SESSION['order']} LIMIT {$page}, 25");
        // $query->execute([ filter_var($order, FILTER_SANITIZE_STRING) ]);
    }
    return $query->fetchAll();
}

function getCount($user_id) { 
    $user = queryUserById($user_id);
    $db = dbConnect();
    // print_r($user);
    if ($user['account_type'] === 'ADMIN') {
        $req = $db->query("SELECT COUNT(*) AS count FROM users");
    } else if ($user['account_type'] === 'MODERATOR') {
        $req = $db->query("SELECT COUNT(*) AS count FROM users WHERE NOT account_type = 'ADMIN'");
    }
    $count = $req->fetch();

    return $count['count'];
}

function getLink() {

}

function queryUserById($userId) {
    $db = dbConnect();
    $query = $db->prepare("SELECT * FROM users WHERE id= ?");
    $query->execute([ $userId ]);
    return $query->fetch(); 
}

function editUserWhenAdmin($id, $type) {
    $db = dbConnect();
    $req = $db->prepare('UPDATE users SET account_type = ? WHERE id = ?');
    $affectedLines = $req->execute([
        filter_var($type, FILTER_SANITIZE_STRING),
        (int)$id
    ]);
    return $affectedLines;
}

function editUserWhenNormal($id, $firstname, $lastname, $email, $country, $password) {
    $db = dbConnect();
    $req = $db->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, country = ?, password = ? WHERE id = ?');
    $affectedLines = $req->execute([
        filter_var($firstname, FILTER_SANITIZE_STRING),
        filter_var($lastname, FILTER_SANITIZE_STRING),
        filter_var($email, FILTER_SANITIZE_EMAIL),
        filter_var($country, FILTER_SANITIZE_STRING),
        password_hash($password, PASSWORD_BCRYPT),
        (int)$id
    ]);
    return $affectedLines;
}

function deleteUser($user_id) {
    $db = dbConnect();
    $req = $db->prepare('DELETE FROM users WHERE id = ?');
    $affectedLines = $req->execute([ $user_id ]); // $affectedLines renvoyer le nombre de lignes modifiées/supprimées si ça a fonctionné, sinon ça renvoie false
    return $affectedLines;
}

function createUser($firstname, $lastname, $email, $country, $password) {
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO users (firstname, lastname, email, account_type, country, password) VALUES(?, ?, ?, "NORMAL", ?, ?) ');
    $affectedLines = $req->execute([
        filter_var($firstname, FILTER_SANITIZE_STRING),
        filter_var($lastname, FILTER_SANITIZE_STRING),
        filter_var($email, FILTER_SANITIZE_EMAIL),
        filter_var($country, FILTER_SANITIZE_STRING),
        password_hash($password, PASSWORD_BCRYPT)
    ]);
    return $affectedLines;
}

function logout() {
    session_start_once();
    session_destroy();
}