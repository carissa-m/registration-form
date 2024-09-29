<?php
session_start();
$inputs = $_SESSION["inputs"] ?? null;
if (!$inputs) {
    echo "No form data found.";
} else {
    echo "<h1>Registration Details</h1>";
    echo "Name: " . htmlspecialchars($inputs["name"]) . "<br>";
    echo "Email: " . htmlspecialchars($inputs["email"]) . "<br>";
    echo "Facebook URL: " . htmlspecialchars($inputs["facebook_url"]) . "<br>";
    echo "Phone Number: " . htmlspecialchars($inputs["phone_number"]) . "<br>";
    echo "Gender: " . htmlspecialchars($inputs["gender"]) . "<br>";
    echo "Region: " . htmlspecialchars($inputs["country"]) . "<br>";
    echo "Skills: " . implode(", ", $inputs["skills"]) . "<br>";
    echo "Biography: " . htmlspecialchars($inputs["biography"]) . "<br>";
}
