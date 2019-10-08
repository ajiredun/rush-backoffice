<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\Roles;
use App\Repository\PageRepository;
use App\Repository\UserRepository;
use App\Service\RfMessages;
use App\Service\SystemManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractController
{

    /**
     * @Route("/", name="rf_dashboard")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function dashboard(UserRepository $userRepository, PageRepository $pageRepository )
    {
        $users = $userRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            15
        );



        $usersOnline = $userRepository->findOnlineUsers();
        $usersCreatedThisMonth = $userRepository->findUsersCreatedByMonth();
        $totalActiveUsers = $userRepository->findTotalActiveUsers(true);

        $pagesPublished = $pageRepository->findBy(['published'=>true]);
        $pagesCreatedThisMonth = $pageRepository->findPagesCreatedByMonth();
        $totalPages = $pageRepository->findAll();

        $last5PublishedPages = $pageRepository->findBy(['published'=>true],['lastModifiedAt'=>'DESC']);
        $last5DraftPages =  $pageRepository->findBy(['published'=>false],['lastModifiedAt'=>'DESC']);

        return $this->render('dashboard/dashboard.html.twig', [
            'users' => $users,
            'usersOnline' => $usersOnline,
            'usersCreatedThisMonth' => $usersCreatedThisMonth,
            'totalUsers' => $totalActiveUsers,
            'totalPages' => $totalPages,
            'pagesCreatedThisMonth' => $pagesCreatedThisMonth,
            'pagesPublished' => $pagesPublished,
            'last5PublishedPages' => $last5PublishedPages,
            'last5DraftPages' => $last5DraftPages
        ]);
    }

    /**
     * @Route("/ai", name="rf_ai")
     * @IsGranted(Roles::ROLE_VIEWER)
     *
     *
     *
     * @param Request $request
     * @param RfMessages $rfMessages
     * @return mixed
     *
     */
    public function ai(Request $request, RfMessages $rfMessages)
    {

        if ($search = $request->get('search', false)) {
            $route = $this->processSearchTerm($search);

            return $this->redirectToRoute($route['path'], array_merge($route['params'],$rfMessages->getMessages()));
        } else {
            $rfMessages->addInfo('Rush AI: Nothing found.');
            return $this->redirectToRoute('rf_dashboard', $rfMessages->getMessages());
        }
    }

    /**
     * @Route("/settings", name="rf_settings")
     * @IsGranted(Roles::ROLE_BO_SETTINGS)
     */
    public function settings(Request $request, RfMessages $rfMessages, SystemManager $systemManager)
    {
        $settings = $systemManager->getSettings();

        if (
            $request->isMethod('POST')
        ) {
            $params = $request->request->all();

            $systemManager->saveSettings($params);

            $rfMessages->addSuccess("System settings modified.");

            return $this->redirectToRoute('rf_settings', $rfMessages->getMessages());
        }

            return $this->render('dashboard/settings.html.twig', [
            'settings' => $settings
        ]);
    }

    /**
     * @param $term
     * @param $string
     * @return bool
     */
    protected function contains($term, $string)
    {
        if (strpos($string, $term) !== false) {
            return true;
        }

        return false;
    }

    protected function processSearchTerm($string)
    {
        $route = ['path'=> 'rf_dashboard', 'params' => []];

        $entities = [
            'page' => [
                'path' => 'rf_page',
                'param_name' => 'rfsearch_pagelist_name',
                'param_status' => 'rfsearch_pagelist_status',
            ],
            'user' => [
                'path' => 'rf_user_list',
                'param_name' => 'rfsearch_userlist_name',
                'param_status' => 'rfsearch_userlist_status'
            ],
        ];

        $string = strtolower(trim($string));

        foreach ($entities as $entity => $params) {
            if ($this->startsWith($entity, $string)) {
                $finalParams = [];
                $route['path'] = $params['path'];

                $broken = explode(' ', $string);


                if (isset($broken[1]) && $broken[1] !== 'status') {
                    $finalParams[$params['param_name']] = $broken[1];
                }

                $this->setIfExist($finalParams,$params['param_status'],'status' , $string, $broken);


                $route['params'] = $finalParams;
            }
        }

        return $route;
    }

    protected function setIfExist(&$finalParams, $param, $property, $string, $broken)
    {
        if ($this->contains($property, $string)) {
            foreach ($broken as $key => $part) {
                if ($part == $property) {
                    if (isset($broken[$key+1])) {
                        $finalParams[$param] = $broken[$key+1];
                    }
                }
            }
        }
    }

    /**
     * @param $term
     * @param $string
     * @return bool
     */
    protected function startsWith($term, $string)
    {
        if (strpos($string, $term) === 0) {
            return true;
        }

        return false;
    }
}
