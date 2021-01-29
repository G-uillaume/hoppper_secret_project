<form action="index.php?view=users&p=editValidate&id=<?= $_GET['id']; ?>&type=<?= $_SESSION['account_type']; ?>" method="post">
    <p>
        <label for="account_type">Account Type</label>
        <select id="account_type" name="account_type" value="<?= $userInfo['account_type']; ?>">
            <option>...</option>
            <option value='ADMIN'>ADMIN</option>
            <option value="MODERATOR">MODERATOR</option>
            <option value="NORMAL">NORMAL</option>
        </select>
    </p>
    <input type="submit" value="Edit">
</form>