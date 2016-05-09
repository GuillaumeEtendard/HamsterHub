<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use EntitiesBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Videos')
            ->findBy(array(), array('id' => 'desc'));

        return $this->render('UserBundle:Base:index.html.twig', array('videos' => $videos));
    }

    public function signInAction()
    {
        $signIn = $this->container->get('SignIn');
        $data = $signIn->SignIn();
        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $email = trim(htmlentities($_POST['email']));
            $salt = "s*m9J[,(m,8q{)@Fd_,K`cSw^Z3-x8,/6KY{'mb)`kEgErH=";
            $password = trim(htmlentities(sha1(sha1($_POST['password']) . $salt)));

            $users = $this->getDoctrine()
                ->getRepository('EntitiesBundle:Users')
                ->findBy(
                    array('email' => $email, 'password' => $password)
                );

            if (empty($users)) {
                $errors['email'] = 'Email and Password doesn\'t match';
                $errors['password'] = 'Email and Password doesn\'t match';
                $data = array('success' => false, "errors" => $errors);
                return new JsonResponse($data, 400);
            }
            $session = new Session();
            $session->clear();
            $session->start();
            $session->set('userId', $users[0]->getId());
            $session->get('userId');

            return new JsonResponse($data, 200);
        }
    }

    public function signUpAction()
    {
        $nicknameVerification = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->findBy(
                array('nickname' => $_POST['nickname'])
            );
        $emailVerification = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->findBy(
                array('email' => $_POST['email'])
            );

        $signUp = $this->container->get('SignUp');
        $data = $signUp->SignUp($nicknameVerification, $emailVerification);
        if ($data['success'] == false) {
            return new JsonResponse($data, 400);
        } else {
            $nickname = trim(htmlentities($_POST['nickname']));
            $email = trim(htmlentities($_POST['email']));
            $birthDate = $_POST['birthDate'];
            $salt = "s*m9J[,(m,8q{)@Fd_,K`cSw^Z3-x8,/6KY{'mb)`kEgErH=";
            $password = trim(htmlentities(sha1(sha1($_POST['password']) . $salt)));
            $imageName = trim(htmlentities($_FILES['profileImage']['name']));

            $newUser = new Users();
            $newUser->setNickname($nickname);
            $newUser->setEmail($email);
            $newUser->setPassword($password);
            $newUser->setBirthDate(new \DateTime($birthDate));
            $newUser->setProfileImageUrl($imageName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();
            return new JsonResponse($data, 200);
        }
    }

    public function logoutAction()
    {
        $session = new Session();
        $session->clear();
        return new JsonResponse($this, 200);
    }

    public function profileAction()
    {
        $session = new Session();
        $id = $session->get('userId');
        $users = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->find($id);
        $nickname = $users->getNickname();
        $email = $users->getEmail();
        $birthDate = $users->getBirthdate();
        $profileImageName = $users->getProfileImageUrl();

        return $this->render('UserBundle:User:profile.html.twig',
            array('nickname' => $nickname,
                'email' => $email,
                'profileImageName' => $profileImageName,
                'birthDate' => $birthDate));
    }

    public function userProfileAction($nickname)
    {
        $users = $this->getDoctrine()
            ->getRepository('EntitiesBundle:Users')
            ->findBy(array('nickname' => $nickname));

        foreach ($users as $usersInfos) {
            $nickname = $usersInfos->getNickname();
            $email = $usersInfos->getEmail();
            $birthDate = $usersInfos->getBirthdate();
            $profileImageName = $usersInfos->getProfileImageUrl();
        }

        return $this->render('UserBundle:User:profile.html.twig',
            array('nickname' => $nickname,
                'email' => $email,
                'profileImageName' => $profileImageName,
                'birthDate' => $birthDate));
    }
}
