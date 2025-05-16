<?php
$login_success = false;
$error = "";
$fullname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (file_exists("data.txt")) {
        $contents = file_get_contents("data.txt");

        // แยกข้อมูลผู้ใช้แต่ละคนด้วย ---
        $users = explode("---", $contents);

        foreach ($users as $user) {
            $lines = explode("\n", trim($user));
            $user_data = [];
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                $parts = explode(":", $line, 2);
                if (count($parts) == 2) {
                    $key = strtolower(trim($parts[0]));
                    $value = trim($parts[1]);
                    $user_data[$key] = $value;
                }
            }

            if (isset($user_data['email']) && isset($user_data['password'])) {
                if ($email === $user_data['email'] && $password === $user_data['password']) {
                    $login_success = true;
                    $fullname = ($user_data['firstname'] ?? '') . ' ' . ($user_data['lastname'] ?? '');
                    break;
                }
            }
        }

        if (!$login_success) {
            $error = "❌ Invalid email or password.";
        }
    } else {
        $error = "⚠️ No user data found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if ($login_success): ?>
        <p style="color:green; font-weight:bold; font-size:18px;">
            ✅ Welcome, <?php echo htmlspecialchars($fullname); ?>!
        </p>
    <?php else: ?>
        <?php if ($error) echo "<p style='color:red; font-weight:bold;'>$error</p>"; ?>
        <form method="post" action="">
            <label>Email</label>
            <input type="email" name="email" required><br>
            <label>Password</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    <?php endif; ?>
    <p>ถ้ายังไม่ลงทะเบียนให้คลิกที่นี่ <a href="register.php">ลงทะเบียน</a></p>
</body>
</html>
