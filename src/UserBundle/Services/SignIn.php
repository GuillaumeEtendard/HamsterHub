<?php

namespace UserBundle\Services;

class SignIn
{
    public function SignIn()
    {
        $formOk = true;
        $errors = [];
        if (!isset($_POST['email']) || strlen($_POST['email']) < 4) {
            $errors['email'] = 'Veuillez saisir un pseudo valide';
            $formOk = false;
        }
        if (!isset($_POST['password']) || strlen($_POST['password']) < 6) {
            $errors['password'] = 'Veuillez saisir un mot de passe valide';
            $formOk = false;
        }

        if ($formOk == true) {
            return (array('success' => true, "user" => $_POST));
        } else {
            http_response_code(400);
            return (array('success' => false, "errors" => $errors));
        }

    }
}