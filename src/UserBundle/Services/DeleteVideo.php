<?php

namespace UserBundle\Services;


class DeleteVideo
{
    public function deleteVideo($id)
    {
        $formOk = true;
        $errors = [];

        if (!isset($_POST['videoName']) ||!$_POST['videoName']) {
                $errors['videoName'] = 'Veuillez saisir une réponse';
                $formOk = false;
        }
        if(isset($_POST['videoName'])){
            if($_POST['videoName'] == 'No'){
                $errors['videoName'] = 'No';
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