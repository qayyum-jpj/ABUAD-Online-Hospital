<?php
session_start();
include './src/admin/inc/config.php';

$errors = [];
$smsg = $emsg = '';

if (isset($_POST['register'])) {
    $fName    = trim(mysqli_real_escape_string($conn, $_POST['fName']));
    $lName    = trim(mysqli_real_escape_string($conn, $_POST['lName']));
    $email    = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $phone    = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    // Validate
    if (empty($fName))   $errors[] = $fNameError   = "First name is required.";
    if (empty($lName))   $errors[] = $lNameError   = "Last name is required.";
    if (empty($email))   $errors[] = $emailError   = "Email is required.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = $emailError = "Invalid email format.";
    if (empty($password))  $errors[] = $passwordError  = "Password is required.";
    elseif (strlen($password) < 6) $errors[] = $passwordError = "Password must be at least 6 characters.";
    if ($password !== $confirm) $errors[] = $confirmError = "Passwords do not match.";

    // Check duplicate email
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = $emailError = "An account with this email already exists.";
        }
        mysqli_stmt_close($stmt);
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $userID = 'PAT-' . random_int(100, 999);
        $role   = 'patient';
        $status = 'pending';

        $stmt = mysqli_prepare($conn, "INSERT INTO users (userID, fName, lName, email, phone, password, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssssss', $userID, $fName, $lName, $email, $phone, $hashed, $role, $status);

        if (mysqli_stmt_execute($stmt)) {
            $smsg = "Registration successful! Your account is pending approval. <a href='/my/ABUAD-Online-Hospital/login'>Login here</a>.";
        } else {
            $emsg = "Something went wrong. Please try again.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $emsg = "Please fix the " . count($errors) . " error(s) below.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ABUAD Online Hospital</title>
    <link rel="icon" type="image/x-icon" href="/my/ABUAD-Online-Hospital/public/img/fljn.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: url('/my/ABUAD-Online-Hospital/public/img/281a0c583d07293807f9580ad4c26717.jpg') no-repeat center center/cover;
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: inherit;
            filter: brightness(40%);
            z-index: -1;
        }

        .register-container {
            background: #ffffff2e;
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            width: 600px;
            max-width: 90vw;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-container h2 {
            margin-bottom: 25px;
            color: #0066cc;
            font-size: 26px;
            text-align: center;
            letter-spacing: 1px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #50b8e7;
            box-shadow: 0 0 8px rgba(0, 102, 204, 0.3);
        }

        .register-btn {
            width: 100%;
            padding: 14px;
            border: none;
            background: #00264d;
            color: #fff;
            font-size: 17px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .register-btn:hover {
            background: #0066cc;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
        }

        .extra-links {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        .extra-links a {
            color: #004080;
            font-weight: bold;
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2><i class="bi bi-person-plus"></i> Patient Registration</h2>

        <?php if (!empty($smsg)): ?>
            <div class="alert alert-success"><?= $smsg ?></div>
        <?php endif; ?>
        <?php if (!empty($emsg)): ?>
            <div class="alert alert-danger"><?= $emsg ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="fName" class="form-control" placeholder="First name" value="<?= htmlspecialchars($_POST['fName'] ?? '') ?>" required>
                    <?php if (isset($fNameError)): ?><span class="error-text"><?= $fNameError ?></span><?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lName" class="form-control" placeholder="Last name" value="<?= htmlspecialchars($_POST['lName'] ?? '') ?>" required>
                    <?php if (isset($lNameError)): ?><span class="error-text"><?= $lNameError ?></span><?php endif; ?>
                </div>
                <div class="col-12">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    <?php if (isset($emailError)): ?><span class="error-text"><?= $emailError ?></span><?php endif; ?>
                </div>
                <div class="col-12">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" placeholder="e.g. 08012345678" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
                    <?php if (isset($passwordError)): ?><span class="error-text"><?= $passwordError ?></span><?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required>
                    <?php if (isset($confirmError)): ?><span class="error-text"><?= $confirmError ?></span><?php endif; ?>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" name="register" class="register-btn">Create Account</button>
                </div>
            </div>
        </form>

        <div class="extra-links">
            <p>Already have an account? <a href="/my/ABUAD-Online-Hospital/src/patient/login">Login</a></p>
        </div>
    </div>
</body>

</html>