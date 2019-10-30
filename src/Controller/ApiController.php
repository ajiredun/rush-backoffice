<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\RfMessages;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/modify-account", name="api_modify_user_account_detail")
     */
    public function modifyAccountDetail(Request $request, UserManager $userManager, RfMessages $rfMessages, EntityManagerInterface $entityManager)
    {

        $response = [
            'success' => false,
            'message' => ''
        ];

        if (
        $request->isMethod('POST')
        ) {
            $contents = json_decode($request->getContent(), true);

            if (!empty($contents)) {
                if (
                    (isset($contents['input_mobile']) && !empty($contents['input_mobile'])) &&
                    (isset($contents['input_address']) && !empty($contents['input_address'])) &&
                    (isset($contents['input_country']) && !empty($contents['input_country'])) &&
                    (isset($contents['input_zipcode']) && !empty($contents['input_zipcode'])) &&
                    (isset($contents['input_firstname']) && !empty($contents['input_firstname'])) &&
                    (isset($contents['input_lastname']) && !empty($contents['input_lastname']))
                ) {
                    /**
                     * @var User $user
                     */
                    $user = $this->getUser();
                    $user->setMobile($contents['input_mobile']);
                    $user->setAddress($contents['input_address']);
                    $user->setCountry($contents['input_country']);
                    $user->setZipcode($contents['input_zipcode']);
                    $user->setFirstname($contents['input_firstname']);
                    $user->setLastname($contents['input_lastname']);

                    $entityManager->flush();

                    $response['success'] = true;
                    $response['message'] = "User details has been updated";

                } else {
                    $response['message'] = "Please fill in all the details";
                }
            } else {
                $response['message'] = "Invalid information";
            }
        }

        return new JsonResponse($response);
    }
}