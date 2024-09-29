<?php
session_start();

// Error messages array
$errors = [];
$inputs = [];

// Function to sanitize inputs
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Validate the form on submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty($_POST["name"])) {
        $errors["name"] = "Name is required.";
    } else {
        $name = sanitize_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors["name"] = "Only letters and spaces allowed.";
        }
        $inputs["name"] = $name;
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $errors["email"] = "Email is required.";
    } else {
        $email = sanitize_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format.";
        }
        $inputs["email"] = $email;
    }

    // Validate Facebook URL
    if (empty($_POST["facebook_url"])) {
        $errors["facebook_url"] = "Facebook URL is required.";
    } else {
        $facebook_url = sanitize_input($_POST["facebook_url"]);
        if (!filter_var($facebook_url, FILTER_VALIDATE_URL)) {
            $errors["facebook_url"] = "Invalid URL format.";
        }
        $inputs["facebook_url"] = $facebook_url;
    }

    // Validate Phone Number
    if (empty($_POST['phone_number']) || !preg_match('/^\d{11}$/', $_POST['phone_number'])) {
        $errors['phone_number'] = "Phone number is required and must be 11 digits.";
    } else {
        $inputs['phone_number'] = $_POST['phone_number'];
    }

    // Validate Password
    if (empty($_POST["password"])) {
        $errors["password"] = "Password is required.";
    } else {
        $password = $_POST["password"];
        if (!preg_match("/^(?=.*[A-Z]).{5,}$/", $password)) {
            $errors["password"] = "Password must be at least 5 characters long and include one uppercase letter.";
        }
    }

    // Validate Confirm Password
    if (empty($_POST["confirm_password"])) {
        $errors["confirm_password"] = "Confirm password is required.";
    } elseif ($_POST["confirm_password"] !== $_POST["password"]) {
        $errors["confirm_password"] = "Passwords do not match.";
    }

    // Validate Gender
    if (empty($_POST["gender"])) {
        $errors["gender"] = "Gender is required.";
    } else {
        $inputs["gender"] = sanitize_input($_POST["gender"]);
    }

    // Validate Country
    if (empty($_POST["country"])) {
        $errors["country"] = "Country is required.";
    } else {
        $inputs["country"] = sanitize_input($_POST["country"]);
    }

    // Validate Skills
    if (empty($_POST["skills"])) {
        $errors["skills"] = "At least one skill must be selected.";
    } else {
        $inputs["skills"] = $_POST["skills"];
    }

    // Validate Biography
    if (empty($_POST["biography"])) {
        $errors["biography"] = "Biography is required.";
    } elseif (strlen($_POST["biography"]) > 200) {
        $errors["biography"] = "Biography must not exceed 200 characters.";
    } else {
        $inputs["biography"] = sanitize_input($_POST["biography"]);
    }

    // Redirect if no errors
    if (empty($errors)) {
        $_SESSION["inputs"] = $inputs;
        header("Location: about.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Registration Form</h2>
    <form method="post" action="reg.php">
        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" placeholder="First Name, MI, Last Name" id="name" name="name" value="<?= htmlspecialchars($inputs['name'] ?? '') ?>">
            <div class="text-danger"><?= $errors["name"] ?? '' ?></div>
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="juandc@gmail.com" id="email" name="email" value="<?= htmlspecialchars($inputs['email'] ?? '') ?>">
            <div class="text-danger"><?= $errors["email"] ?? '' ?></div>
        </div>

        <!-- Facebook URL Field -->
        <div class="mb-3">
            <label for="facebook_url" class="form-label">Facebook URL</label>
            <input type="url" class="form-control" placeholder="facebook.com/juandc" id="facebook_url" name="facebook_url" value="<?= htmlspecialchars($inputs['facebook_url'] ?? '') ?>">
            <div class="text-danger"><?= $errors["facebook_url"] ?? '' ?></div>
        </div>

        <!-- Phone Number Field -->
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" placeholder="09123456789" id="phone_number" name="phone_number" value="<?= htmlspecialchars($inputs['phone_number'] ?? '') ?>">
            <div class="text-danger"><?= $errors["phone_number"] ?? '' ?></div>
        </div>

        <!-- Password Fields -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Password must be at least 5 characters long and include one uppercase letter." id="password" name="password">
            <div class="text-danger"><?= $errors["password"] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            <div class="text-danger"><?= $errors["confirm_password"] ?? '' ?></div>
        </div>

        <!-- Gender Radio Buttons -->
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <div>
                <input type="radio" id="male" name="gender" value="Male" <?= isset($inputs['gender']) && $inputs['gender'] == 'Male' ? 'checked' : '' ?>>
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="Female" <?= isset($inputs['gender']) && $inputs['gender'] == 'Female' ? 'checked' : '' ?>>
                <label for="female">Female</label>
            </div>
            <div class="text-danger"><?= $errors["gender"] ?? '' ?></div>
        </div>

        <!-- Country Dropdown -->
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" id="country" name="country">
                <option value="">Select</option>
                <option value="USA" <?= isset($inputs['country']) && $inputs['country'] == 'USA' ? 'selected' : '' ?>>USA</option>
                <option value="Dubai" <?= isset($inputs['country']) && $inputs['country'] == 'Dubai' ? 'selected' : '' ?>>Dubai</option>
                <option value="France" <?= isset($inputs['country']) && $inputs['country'] == 'France' ? 'selected' : '' ?>>France</option>
                <option value="Philippines" <?= isset($inputs['country']) && $inputs['country'] == 'Philippines' ? 'selected' : '' ?>>Philippines</option>
                <option value="Japan" <?= isset($inputs['country']) && $inputs['country'] == 'Japan' ? 'selected' : '' ?>>Japan</option>
            </select>
            <div class="text-danger"><?= $errors["country"] ?? '' ?></div>
        </div>

        <!-- Skills Checkboxes -->
        <div class="mb-3">
            <label for="skills" class="form-label">Skills</label>
            <div>
                <input type="checkbox" id="ct" name="skills[]" value="CriticalThinking" <?= isset($inputs['skills']) && in_array('ct', $inputs['skills']) ? 'checked' : '' ?>>
                <label for="ct">Critical Thinking</label>
                <input type="checkbox" id="css" name="skills[]" value="Adaptability" <?= isset($inputs['skills']) && in_array('adapt', $inputs['skills']) ? 'checked' : '' ?>>
                <label for="adapt">Adaptability</label>
                <input type="checkbox" id="js" name="skills[]" value="Interpersonal" <?= isset($inputs['skills']) && in_array('inter', $inputs['skills']) ? 'checked' : '' ?>>
                <label for="inter">Interpersonal</label>
            </div>
            <div class="text-danger"><?= $errors["skills"] ?? '' ?></div>
        </div>

        <!-- Biography Textarea -->
        <div class="mb-3">
            <label for="biography" class="form-label">Biography</label>
            <textarea class="form-control" id="biography" name="biography" maxlength="200"><?= htmlspecialchars($inputs['biography'] ?? '') ?></textarea>
            <div class="text-danger"><?= $errors["biography"] ?? '' ?></div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>
