<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "demo";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Error" . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <label for="">File upload: </label>
        <input type="file" name="fileupload"><br>

        <label for="">Name: </label>
        <input type="text" name="name"><br>

        <label for="">Email: </label>
        <input type="email" name="email"><br>

        <label for="">Password: </label>
        <input type="password" name="password"><br>

        <button type="submit" name="insert">Add</button>
    </form> <br><br><br><br><br>

    <form method="post">
        <label for="">Email: </label>
        <input type="email" name="email1"><br>

        <label for="">Password: </label>
        <input type="password" name="password1"><br>

        <button type="submit" name="login">login</button>
    </form><br><br><br>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Pic</th>
            </tr>
        </thead>
</body>

</html>
<?php


if (isset($_POST['insert'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $path = $_FILES['fileupload']['name'];
    $tmp_name = $_FILES['fileupload']['tmp_name'];
    $upload_path = "./store/uploadtest/" . $path;
    if (move_uploaded_file($tmp_name, $upload_path)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO test_user (name, email, password, upload) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password_hash, $upload_path);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            echo "<script>alert('Register Successful!');</script>";
        } else {
            echo "<script>alert('Registration Failed. Please try again later.');</script>";
        }
    } else
        echo "<script>alert('Image Not Uploaded!');</script>";
}


if (isset($_POST['login'])) {
    $email1 = $_POST['email1'];
    $password1 = $_POST['password1'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM test_user WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($stmt && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password1, $row['password'])) {
            $_SESSION['email'] = $email;
            echo "<script>alert('login success');</script>";
        } else {
            echo "<script>alert('password Wrong');</script>";
        }
    } else {
        echo "<script>alert('email not registration');</script>";
    }
}

$sql = "SELECT * FROM test_user";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tbody>
            <tr>
                <th scope='row'>{$row['id']}</th>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['upload']}</td>
            </tr>";
    }
} else {
    echo "<tr><td>Empty Data</td></tr>  
      </tbody>
    </table>";
}
?>