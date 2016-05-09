<?php

namespace UserBundle\Services;

class AddComment
{
    public function addComment()
    {
        $formOk = true;
        $errors = [];

        if (!isset($_POST['commentary']) || empty($_POST['commentary'])) {
            $errors['commentary'] = 'Veuillez saisir un commentaire';
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