<?php

namespace UserBundle\Services;

class SignUp
{
    public function SignUp($nicknameVerification, $emailVerification)
    {
        $errors = [];
        $formOk = true;
        if (!empty($nicknameVerification)) {
            $errors['nickname'] = 'Nickname is already use';
            $formOk = false;
        }
        if (!empty($emailVerification)) {
            $errors['email'] = 'Email is already use';
            $formOk = false;
        }
        if (!isset($_POST['nickname']) || !$_POST['nickname'] || strlen($_POST['nickname']) < 4) {
            $formOk = false;
            $errors['nickname'] = 'Nickname is not defined or not valid';
        }
        if (!isset($_POST['email']) || !$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $formOk = false;
            $errors['email'] = 'Email is not defined or not valid';
        }
        if (!isset($_POST['birthDate']) || !($_POST['birthDate'])) {
            $formOk = false;
            $errors['birthDate'] = 'Birth date is not defined or not valid';
        }

        if (!isset($_POST['password']) || !($_POST['password']) || strlen($_POST['password']) < 6 || $_POST['password'] != $_POST['passwordVerification']) {
            $formOk = false;
            $errors['password'] = 'Password is not defined or not valid';
        }
        if (!isset($_POST['passwordVerification']) || !($_POST['passwordVerification']) || strlen($_POST['passwordVerification']) < 6 || $_POST['passwordVerification'] != $_POST['password']) {
            $formOk = false;
            $errors['passwordVerification'] = 'Password Verification is not defined or not valid';
        }

        $target_dir = "assets/uploads/";
        $target_file = $target_dir . basename($_FILES["profileImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $errors['profileImage'] = "File is not an image.";
                $uploadOk = 0;
            }
        }
        if (file_exists($target_file)) {
            $errors['profileImage'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if ($_FILES["profileImage"]["size"] > 500000) {
            $errors['profileImage'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $errors['profileImage'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if (($uploadOk == 0 && $formOk == false) || ($uploadOk == 1 && $formOk == false)) {
            $formOk = false;
        } else {
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
                $formOk = true;
            } else {
                $errors['profileImage'] = "Sorry, there was an error uploading your file.";
                $formOk = false;
            }
        }

        if ($formOk == true) {
            return (array('success' => true, "user" => $_POST));
        } else {
            http_response_code(400);
            return (array('success' => false, "errors" => $errors));
        }
    }
}