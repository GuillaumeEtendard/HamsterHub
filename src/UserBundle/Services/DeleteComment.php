<?php

namespace UserBundle\Services;

class DeleteComment
{
    public function deleteComment()
    {
        $formOk = true;
        $errors = [];

        if (!isset($_POST['commentAnswer']) || !$_POST['commentAnswer']) {
            $errors['commentAnswer'] = 'Veuillez saisir une réponse';
            $formOk = false;
        }
        if (isset($_POST['commentAnswer'])) {
            if ($_POST['commentAnswer'] == 'No') {
                $errors['commentAnswer'] = 'No';
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