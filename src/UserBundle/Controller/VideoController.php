<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Services\AddVideo;
use EntitiesBundle\Entity\Comments;
use EntitiesBundle\Entity\Users;
use EntitiesBundle\Entity\Videos;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class VideoController extends Controller
{

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
            $newVideo->setVideoViews(0);
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
        $data = $deleteVideo->deleteVideo();

        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $em = $this->getDoctrine()->getManager();

            $video = $this->getDoctrine()
                ->getRepository('EntitiesBundle:Videos')
                ->findBy(array('id' => $_POST['videoId'], 'users_id' => $userId));

            $em->remove($video[0]);
            $em->flush();

            foreach($video as $value){
                $youtubeIdVideos[] = $value->getYoutubeId();
            }
            $comments = $this->getDoctrine()
                ->getRepository('EntitiesBundle:Comments')
                ->findBy(array('idVideo' => $youtubeIdVideos));
            foreach($comments as $comment){
                $em->remove($comment);
            }
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
            return $this->render('UserBundle:Videos:userVideo.html.twig');
        }
        return $this->render('UserBundle:Videos:userVideo.html.twig', array('videos' => $userConnected, 'nickname' => $nickname));
    }

    public function videoAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $videos = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array('youtube_id' => $id));

        foreach ($videos as $video) {
            $videosViews[] = $video->getVideoViews();
        }

        $videoViews = $videosViews[0] + 1;

        $em = $this->getDoctrine()->getManager();
        $videosAddView = $em->getRepository('EntitiesBundle:Videos')
            ->findBy(array('youtube_id' => $id));

        $videosAddView[0]->setVideoViews($videoViews);

        $em->flush();

        $em = $this->getDoctrine()->getManager();
        $comments = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Comments')
            ->findBy(array('idVideo' => $id), array('id' => 'desc'));

        return $this->render('UserBundle:Videos:video.html.twig', array('videos' => $videos, 'comments' => $comments));
    }

    public function addCommentAction($id, Request $request)
    {

        $session = $request->getSession();
        $idUserConnected = $session->get('userId');

        $addCommentary = $this->container->get('addComment');
        $data = $addCommentary->addComment();
        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $comment = trim(htmlentities($_POST['commentary']));
            $commentAdd = new Comments();

            $em = $this->getDoctrine()->getManager();
            $nicknames = $this->getDoctrine()
                ->getRepository('EntitiesBundle:Users')
                ->findBy(array('id' => $idUserConnected));
            $nickname = $nicknames[0]->getNickname();

            $commentAdd->setContent($comment);
            $commentAdd->setIdUser($idUserConnected);
            $commentAdd->setIdVideo($id);
            $commentAdd->setNickname($nickname);
            $commentAdd->setCommentDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($commentAdd);
            $em->flush();

            return new JsonResponse($data, 200);
        }
    }

    public function deleteCommentAction($id)
    {
        $deleteComment = $this->container->get('deleteComment');
        $data = $deleteComment->deleteComment();

        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $em = $this->getDoctrine()->getManager();
            $commentToDelete = $this->getDoctrine()
                ->getRepository('EntitiesBundle:Comments')
                ->findBy(array('id' => $id));;
            $em->remove($commentToDelete[0]);
            $em->flush();

            return new JsonResponse($data, 200);
        }
    }

}