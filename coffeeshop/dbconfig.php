<?php
// Database connection using PDO
define('BASE_URL', '/coffeeshop');   // change if your folder name is different

$host    = 'localhost';
$dbname  = 'coffeeshop';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die('Connection failed: ' . htmlspecialchars($e->getMessage()));
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function flash($msg = null, $type = 'ok') {
    if ($msg !== null) { $_SESSION['flash'] = [$msg, $type]; return; }
    if (isset($_SESSION['flash'])) { $f = $_SESSION['flash']; unset($_SESSION['flash']); return $f; }
    return null;
}

function redirect($path) { header('Location: ' . BASE_URL . $path); exit; }

// ---- AUTH HELPERS ----

// Is anyone logged in right now?
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// The id of the logged-in user, or null
function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

// The username of the logged-in user
function current_username() {
    return $_SESSION['username'] ?? '';
}

// Call this at the top of any page that requires login.
// If nobody is logged in, bounce to the login page.
function require_login() {
    if (!is_logged_in()) {
        redirect('/login.php');
    }
}
