<?php

namespace UserBundle\Services;


class EditVideo
{
    public function editVideo($videoUrlVerification,$videoNameVerification/*,$videoUrlVerificationId, $videoNameVerificationId*/)
    {
        $formOk = true;
        $errors = [];

      /*  if($_POST['videoId'] != $videoUrlVerificationId){*/
            if (!empty($videoUrlVerification)) {
                $errors['videoUrl'] = 'Video is already upload';
                $formOk = false;
            }
            if (!empty($videoNameVerification)) {
                $errors['videoName'] = 'Video Name is already use';
                $formOk = false;
            }

       /* }*/
        if (!isset($_POST['videoUrl']) || strlen($_POST['videoUrl']) < 4) {
            $errors['videoUrl'] = 'Veuillez saisir une url valide';
            $formOk = false;
        }
        $preg_match = preg_match('#https?://(?:www\.)?youtube\.com/watch\?v=([^&]+?)#', $_POST['videoUrl'], $matches);
        if (empty($preg_match)) {
            $errors['videoUrl'] = 'Veuillez saisir une url valide';
            $formOk = false;
        }
        if (!isset($_POST['videoName']) || strlen($_POST['videoName']) < 6) {
            $errors['videoName'] = 'Veuillez saisir un nom de vidéo valide';
            $formOk = false;
        }
        if (!isset($_POST['videoDescription']) || strlen($_POST['videoDescription']) < 6) {
            $errors['videoDescription'] = 'Veuillez saisir une description de vidéo valide';
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