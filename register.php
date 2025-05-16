<?php
function validate_password($password, $email) {
    if (strlen($password) != 12) {
        return "Password ต้องมีความยาว 12 ตัวอักษร";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password ต้องมีตัวอักษรพิมพ์ใหญ่ อย่างน้อย 1 ตัว";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Password ต้องมีตัวอักษรพิมพ์เล็ก อย่างน้อย 1 ตัว";
    }
    if (!preg_match('/\d/', $password)) {
        return "Password ต้องมีตัวเลข อย่างน้อย 1 ตัว";
    }
    if (!preg_match('/[!@#$%^&*\-\+\/\\=_]/', $password)) {
    return "Password ต้องมีอักษรพิเศษ (!@#$%^&* - + / \\ = _) อย่างน้อย 1 ตัว";
}
    if (strpos($password, $email) !== false) {
        return "Password ห้ามซ้ำกับ Email";
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $c_password = trim($_POST["c_password"]);

    $validation_result = validate_password($password, $email);

    if ($validation_result === true) {
        if ($password === $c_password) {
            $data = "Firstname: $fname\nLastname: $lname\nEmail: $email\nPassword: $password\n---\n";
            file_put_contents("data.txt", $data, FILE_APPEND);
            echo "<p style='color:green;'>Register Success! Data saved to data.txt</p>";
        } else {
            echo "<p style='color:red;'>Passwords do not match</p>";
        }
    } else {
        echo "<p style='color:red;'>$validation_result</p>";
    }
}
?>
<form method="post">
    <label>FirstName</label><input type="text" name="fname" required><br>
    <label>LastName</label><input type="text" name="lname" required><br>
    <label>Email</label><input type="email" name="email" required><br>
    <label>Password</label><input type="password" name="password" required><br>
    <label>Confirm Password</label><input type="password" name="c_password" required><br>
    <button type="submit">Register</button>
    <p>ถ้าลงทะเบียนเเล้วให้คลิกที่นี่<a href="login.php">เข้าสู่ระบบ</a></p>
</form>
