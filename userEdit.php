<?php
$title = "Edit User";
$css_file ="./css-files/adminStyle.css";
$css_filee = "./css-files/header.css";
include_once "header.php";
require_once "validateAdmin.php";
include "db_connect.php";
?>

<?php

if(isset($_GET["id"])) {
    $user_id = $_GET["id"];

    $query = "SELECT * FROM registered_user WHERE user_id=:user";

    $stmt = $pdo->prepare($query);
    $data = [
      ":user" => $user_id
    ];
    $stmt->execute($data);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<form class="edit-form" action="./php-files/userEditProcess.php" method="post">
    <input type="hidden" value="<?= $result["user_id"] ?>" name="userid">
    <div>
        <label>Username:</label>
        <input type="text" value="<?= $result["user_nickname"] ?>" name="username">
    </div>
    <div>
        <label>Full name:</label>
        <input type="text" value="<?= $result["user_name"] ?>" name="fullname">
    </div>
    <div>
        <label>Email:</label>
        <input type="email" value="<?= $result["user_email"] ?>" name="email">
    </div>
    <div>
        <label>Promote to Admin</label>
        <input type="checkbox"  <?php if($result["is_admin"]) echo "checked"; ?> value="<?= $result['is_admin']?>" name="admin">
    </div>
    <button type="submit" name="submit">Update User</button>
</form>

<?php
    include_once "footer.php";
    ?>

</body>

</html>
