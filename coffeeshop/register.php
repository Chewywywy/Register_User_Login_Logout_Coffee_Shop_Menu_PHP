<?php
$title = 'Register';
require_once 'dbconfig.php';

if (is_logged_in()) { redirect('/index.php'); }

$first_name = $last_name = $email = $username = $address = $age = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $username   = trim($_POST['username'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $age        = $_POST['age'] ?? '';
    $password   = $_POST['password'] ?? '';
    $confirm    = $_POST['confirm_password'] ?? '';

    if ($first_name === '' || $last_name === '' || $email === '' || $username === '' || $password === '') {
        $error = 'Please fill in all required fields.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $check = $pdo->prepare("SELECT user_id FROM users WHERE username = :u OR email = :e");
        $check->execute([':u' => $username, ':e' => $email]);
        if ($check->fetch()) {
            $error = 'That username or email is already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, username, password, address, age)
                                    VALUES (:fn, :ln, :em, :un, :pw, :ad, :ag)");
            $stmt->execute([
                ':fn' => $first_name, ':ln' => $last_name, ':em' => $email,
                ':un' => $username, ':pw' => $hash, ':ad' => $address,
                ':ag' => ($age !== '' ? (int)$age : null),
            ]);
            flash('Account created. Please log in.');
            redirect('/login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register | Bean Counter</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body>
<header class="top">
  <a class="brand" href="<?= BASE_URL ?>/login.php">Bean Counter</a>
</header>
<main>
<?php $f = flash(); if ($f): ?><div class="flash <?= e($f[1]) ?>"><?= e($f[0]) ?></div><?php endif; ?>
<div class="head"><div><h1>Create account</h1><p>Register to manage the menu.</p></div></div>
<?php if ($error): ?><div class="flash err"><?= e($error) ?></div><?php endif; ?>
<form class="card" method="post">
  <label for="first_name">First name</label>
  <input id="first_name" name="first_name" value="<?= e($first_name) ?>" required>
  <label for="last_name">Last name</label>
  <input id="last_name" name="last_name" value="<?= e($last_name) ?>" required>
  <label for="email">Email</label>
  <input id="email" name="email" type="email" value="<?= e($email) ?>" required>
  <label for="address">Address</label>
  <input id="address" name="address" value="<?= e($address) ?>">
  <label for="age">Age</label>
  <input id="age" name="age" type="number" min="0" value="<?= e($age) ?>">
  <label for="username">Username</label>
  <input id="username" name="username" value="<?= e($username) ?>" required>
  <label for="password">Password</label>
  <input id="password" name="password" type="password" required>
  <label for="confirm_password">Confirm password</label>
  <input id="confirm_password" name="confirm_password" type="password" required>
  <div class="actions"><button class="btn" type="submit">Register</button></div>
</form>
<p style="margin-top:1rem">Already have an account? <a href="login.php">Log in</a></p>
</main>
</body>
</html>
