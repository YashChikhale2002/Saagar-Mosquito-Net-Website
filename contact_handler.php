<?php
// ============================================================
// contact_handler.php
// Place this file in ROOT of your project
// Works on: localhost/subfolder AND live domain both
// ============================================================

// ── Output buffering — prevent any accidental output ────────
ob_start();

session_start();

// ── Absolute path include — works everywhere ─────────────────
include __DIR__ . '/include/config.php';

// ── Kill any buffered output before JSON header ──────────────
ob_clean();

header('Content-Type: application/json; charset=UTF-8');

// ── Only allow POST ──────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// ── DB connection check ──────────────────────────────────────
if (!isset($conn) || $conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please try again later.'
    ]);
    exit;
}

// ── Helper: sanitize input ───────────────────────────────────
function clean($value) {
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

// ── Collect & Sanitize ───────────────────────────────────────
$name    = clean($_POST['name']    ?? '');
$email   = clean($_POST['email']   ?? '');
$phone   = clean($_POST['phone']   ?? '');
$message = clean($_POST['message'] ?? '');

// ── Validate ─────────────────────────────────────────────────
$errors = [];

// Name
if (empty($name)) {
    $errors['name'] = 'Please enter your full name.';
} elseif (strlen($name) < 2) {
    $errors['name'] = 'Name must be at least 2 characters.';
} elseif (strlen($name) > 100) {
    $errors['name'] = 'Name must not exceed 100 characters.';
} elseif (!preg_match("/^[a-zA-Z\s\.\-']+$/u", $name)) {
    $errors['name'] = 'Name can only contain letters, spaces, dots, or hyphens.';
}

// Email
if (empty($email)) {
    $errors['email'] = 'Please enter your email address.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
} elseif (strlen($email) > 150) {
    $errors['email'] = 'Email address is too long.';
}

// Phone
if (empty($phone)) {
    $errors['phone'] = 'Please enter your mobile number.';
} elseif (!preg_match('/^[6-9][0-9]{9}$/', $phone)) {
    $errors['phone'] = 'Please enter a valid 10-digit Indian mobile number.';
}

// Message
if (empty($message)) {
    $errors['message'] = 'Please describe your mosquito net requirement.';
} elseif (strlen($message) < 10) {
    $errors['message'] = 'Message must be at least 10 characters.';
} elseif (strlen($message) > 1000) {
    $errors['message'] = 'Message must not exceed 1000 characters.';
}

// ── Return errors if any ─────────────────────────────────────
if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// ── IP Address ───────────────────────────────────────────────
$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
// Take only first IP if multiple (proxy chain)
$ip_address = trim(explode(',', $ip_address)[0]);
$ip_address = substr($ip_address, 0, 45); // max length safety

// ── Save to Database — Prepared Statement ────────────────────
$stmt = $conn->prepare(
    "INSERT INTO enquiries (name, email, phone, message, ip_address, created_at)
     VALUES (?, ?, ?, ?, ?, NOW())"
);

if (!$stmt) {
    error_log('DB prepare failed: ' . $conn->error);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again later.'
    ]);
    exit;
}

$stmt->bind_param('sssss', $name, $email, $phone, $message, $ip_address);
$inserted = $stmt->execute();

if (!$inserted) {
    error_log('DB execute failed: ' . $stmt->error);
    $stmt->close();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save your enquiry. Please try again.'
    ]);
    exit;
}

$stmt->close();

// ── Build WhatsApp Message ────────────────────────────────────
$whatsapp_number = '917719806088';

$wa_message = "Hello Saagar Enterprises! \xF0\x9F\xA6\x9F\n\n"
            . "New Enquiry from Website:\n"
            . "──────────────────────\n"
            . "Name        : " . $name    . "\n"
            . "Email       : " . $email   . "\n"
            . "Phone       : " . $phone   . "\n"
            . "Requirement : " . $message . "\n"
            . "──────────────────────\n"
            . "\xF0\x9F\x93\x85 Sent on: " . date('d M Y, h:i A');

$wa_url = "https://wa.me/" . $whatsapp_number . "?text=" . rawurlencode($wa_message);

// ── Success Response ─────────────────────────────────────────
echo json_encode([
    'success'      => true,
    'message'      => 'Thank you! Your enquiry has been submitted. Redirecting to WhatsApp...',
    'whatsapp_url' => $wa_url
]);
exit;