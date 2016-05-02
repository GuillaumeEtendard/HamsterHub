<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Services\AddVideo;
use EntitiesBundle\Entity\Videos;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class VideoController extends Controller
{
    /*public function addVideoAction(Request $request)
    {

        $session = $request->getSession();
        $idUserConnected = $session->get('userId');


        $em = $this->getDoctrine()->getManager();
        $userConnected = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->findBy(array('id' => $idUserConnected));

        $addVideoServices = $this->container->get('addVideo');
        $resAddVideoServices = $addVideoServices->addVideo();

        //validate format youtube URL avant ....
        $url = $resAddVideoServices;
        $test_url = preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);

        // test_url = 1 true || 0 == false

        foreach ($userConnected as $objectUserConnected) {
            $idUser = $objectUserConnected->getId();
            $nicknameUser = $objectUserConnected->getNickname();
        }

        if ($resAddVideoServices == "error" || $test_url == 0) {
            $resAddVideoServices = "";
            $msgError = "url vide ou format youtube invalide, réessayer !";

        } elseif ($resAddVideoServices != "error" || $test_url == 1) {
            $embed = explode("watch?v=", $resAddVideoServices);
            $videoEmbed = implode('embed/', $embed);
            $videosUrl = $videoEmbed;
            $youtubeId = $embed[1];
            $newVideo = new Videos();
            $newVideo->setYoutubeId($youtubeId);
            $newVideo->setDescription($_POST['description']);
            $newVideo->setVideoName($_POST['video_name']);
            $newVideo->setUrl($videosUrl); // url rentrer par l'utilisateur
            $newVideo->setUsersId($objectUserConnected);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newVideo);
            $em->flush();

            $msgError = "";
        }

        return $this->render('UserBundle:Videos:addVideo.html.twig', array('url' => $resAddVideoServices, 'msgError' => $msgError));
    }*/
    public function addVideoAction(Request $request)
    {
        $session = $request->getSession();
        $idUserConnected = $session->get('userId');


        $em = $this->getDoctrine()->getManager();
        $userConnected = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->findBy(array('id' => $idUserConnected));

        foreach ($userConnected as $objectUserConnected) {
            $idUser = $objectUserConnected->getId();
        }

        $videoName = trim(htmlentities($_POST['videoName']));
        $videoUrl = trim(htmlentities($_POST['videoUrl']));
        $videoDescription = trim(htmlentities($_POST['videoDescription']));

        $embed = explode("watch?v=", $videoUrl);
        $videoEmbed = implode('embed/', $embed);

        $em = $this->getDoctrine()->getManager();
        $videoUrlVerification = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('url' => $videoEmbed));

        $em = $this->getDoctrine()->getManager();
        $videoNameVerification = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('video_name' => $videoName));


        $addVideo = $this->container->get('addVideo');
        $data = $addVideo->addVideo($videoUrlVerification, $videoNameVerification);

        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $videosUrl = $videoEmbed;
            $youtubeId = $embed[1];

            $newVideo = new Videos();
            $newVideo->setYoutubeId($youtubeId);
            $newVideo->setVideoName($videoName);
            $newVideo->setVideoDate(new \DateTime(date('d-m-Y')));
            $newVideo->setUrl($videosUrl);
            $newVideo->setDescription($videoDescription);
            $newVideo->setUsersId($objectUserConnected);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newVideo);
            $em->flush();
            return new JsonResponse($data, 200);
        }
    }

    public function editVideoAction(Request $request)
    {
        $session = $request->getSession();
        $idUserConnected = $session->get('userId');


        $em = $this->getDoctrine()->getManager();
        $userConnected = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->findBy(array('id' => $idUserConnected));

        foreach ($userConnected as $objectUserConnected) {
            $idUser = $objectUserConnected->getId();
        }

        $videoName = trim(htmlentities($_POST['videoName']));
        $videoUrl = trim(htmlentities($_POST['videoUrl']));
        $videoDescription = trim(htmlentities($_POST['videoDescription']));

        $embed = explode("watch?v=", $videoUrl);
        $videoEmbed = implode('embed/', $embed);

        $em = $this->getDoctrine()->getManager();
        $videosUrlVerification = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('url' => $videoEmbed));

        $em = $this->getDoctrine()->getManager();
        $videosNameVerification = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('video_name' => $videoName));
/*
        foreach ($videosNameVerification as $videoNameVerification) {
            $videoNameVerificationId = $videoNameVerification->getId();
        }

        foreach ($videosUrlVerification as $videoUrlVerification) {
            $videoUrlVerificationId = $videoUrlVerification->getId();
        }*/

        $editVideo = $this->container->get('editVideo');
        $data = $editVideo->editVideo($videosUrlVerification, $videosNameVerification/*,$videoUrlVerificationId, $videoNameVerificationId*/);

        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $videosUrl = $videoEmbed;
            $youtubeId = $embed[1];

            $em = $this->getDoctrine()->getManager();
            $updateVideo = $em->getRepository('EntitiesBundle:Videos')->find($_POST['videoId']);

            $updateVideo->setYoutubeId($youtubeId);
            $updateVideo->setVideoName($videoName);
            $updateVideo->setVideoDate(new \DateTime(date('d-m-Y')));
            $updateVideo->setUrl($videosUrl);
            $updateVideo->setDescription($videoDescription);
            $updateVideo->setUsersId($objectUserConnected);
            $em->flush();
            return new JsonResponse($data, 200);
        }
    }

    public function deleteVideoAction($id)
    {
        $session = new Session();
        $userId = $session->get('userId');

        if ($id != $_POST['videoId']) {
            return new JsonResponse('Error', 400);
        }

        $deleteVideo = $this->container->get('deleteVideo');
        $data = $deleteVideo->deleteVideo($id);

        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $em = $this->getDoctrine()->getManager();

            $video = $this->getDoctrine()
                ->getRepository('EntitiesBundle:Videos')
                ->findBy(array('id' => $_POST['videoId'], 'users_id' => $userId));

            $em->remove($video[0]);
            $em->flush();

            return new JsonResponse($data, 200);
        }
    }

    public function myVideoAction(Request $request)
    {
        $session = $request->getSession();
        $idUserConnected = $session->get('userId');

        $em = $this->getDoctrine()->getManager();
        $userConnected = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('users_id' => $idUserConnected), array('id' => 'desc'));

        foreach ($userConnected as $objetUser) {
            $myUrl[] = $objetUser->getUrl();
            $videosId[] = $objetUser->getId();
        }
        return $this->render('UserBundle:Videos:myVideo.html.twig', array('videos' => $userConnected));
    }

    public function userVideoAction($nickname)
    {

        $em = $this->getDoctrine()->getManager();
        $users = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->findBy(array('nickname' => $nickname));

        foreach ($users as $objetUser) {
            $usersId[] = $objetUser->getId();
        }
        if (!isset($usersId) || !$usersId) {
            $undefinedUser = 'No user';
            throw $this->createNotFoundException('The user ' . $nickname . ' does not exist');
        }
        $em = $this->getDoctrine()->getManager();
        $userConnected = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('users_id' => $usersId), array('id' => 'desc'));

        foreach ($userConnected as $objetUser) {
            $myUrl[] = $objetUser->getUrl();
            $myUser_id = $objetUser->getUsersId();
        }
        if (!isset($usersId) || !$usersId) {
            $myUrl = 'No video';
            return $this->render('UserBundle:Videos:userVideo.html.twig', array('allURL' => $myUrl));
        }
        return $this->render('UserBundle:Videos:userVideo.html.twig', array('videos' => $userConnected, 'nickname' => $nickname));
    }

    public function videoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('youtube_id' => $id));

        return $this->render('UserBundle:Videos:video.html.twig', array('videos' => $videos));
    }
}
