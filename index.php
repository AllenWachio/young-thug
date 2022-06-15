<?php

require_once './db_connection.php';
require_once './fetch_data.php';
require_once './insert_data.php';
$all_user = array_reverse(fetchUsers($conn));

if (isset($_POST['u_name']) && isset($_POST['u_email']) && isset($_POST['phone'])) {
    $insert_data = insertData($conn, $_POST['u_name'], $_POST['u_email'],$_POST['phone']);
    if ($insert_data === true) {
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allen Crud Application</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>

    <div class="container">
        <header class="header">
            <h1 class="title">Allens CRUD Application</h1>
        </header>
        <div class="wrapper">
            <div class="form">
                <form method="POST">
                    <label for="userName"><b>Full Name</b></label>
                    <input type="text" name="u_name" id="userName" placeholder="Enter Name" autocomplete="off" required>
                    <label for="userEmail"><b>Email Address</b></label>
                    <input type="email" name="u_email" id="userEmail" placeholder="Enter Email" autocomplete="off" required>
                    <label for="phone"><b>Phone Number</b></label>
                    <input type="text" id="phone" required placeholder="Enter Phone Number" autocomplete="off" name="phone">

                    <?php if (isset($insert_data) && $insert_data !== true) {
                        echo '<p class="msg err-msg">' . $insert_data . '</p>';
                    }
                    ?>
                    <input type="submit" value="Submit">
                </form>
            </div>
            <div class="user-list">
                <?php if (count($all_user) > 0) : ?>
                    <table>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($all_user as $user) :
                                $id = $user['id'];
                                $name = $user['name'];
                                $email = $user['email'];
                                $phone = $user['phone'];
                            ?>
                                <tr>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $phone; ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $id; ?>" class="edit">Edit</a>&nbsp;|
                                        <a href="delete.php?id=<?php echo $id; ?>" class="delete delete-action">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <h2>No records found. Please insert some records.</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        let delteAction = document.querySelectorAll('.delete-action');
        delteAction.forEach((el) => {
            el.onclick = function(e) {
                e.preventDefault();
                if (confirm('Are you sure?')) {
                    window.location.href = e.target.href;
                }
            }
        });
    </script>

</body>

</html>