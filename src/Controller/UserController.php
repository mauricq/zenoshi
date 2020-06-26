<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Catalogue;
use App\Entity\Constants;
use App\Entity\Person;
use App\Entity\User;
use App\Service\CatalogueService;
use App\Service\UserService;
use App\Service\PersonService;
use App\Utils\UserUtil;
use ErrorException;
use Exception;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("user")
 * Class UserController
 * @package App\Controller
 */
class UserController extends ControllerProvider
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @var PersonService
     */
    private PersonService $personService;

    /**
     * @var CatalogueService
     */
    private CatalogueService $catalogueService;
    /**
     * @var UserUtil
     */
    private UserUtil $userUtil;

    /**
     * User constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param UserService $service
     * @param PersonService $personService
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param CatalogueService $catalogueService
     * @param UserUtil $userUtil
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer, SerializerInterface $serializer, UserService $service, PersonService $personService, UserPasswordEncoderInterface $passwordEncoder, CatalogueService $catalogueService, UserUtil $userUtil)
    {
        parent::__construct($arrayTransformer, $serializer, $service);
        $this->passwordEncoder = $passwordEncoder;
        $this->personService = $personService;
        $this->catalogueService = $catalogueService;
        $this->userUtil = $userUtil;
    }


    /**
     * @Route("/{id}", name="getUserInfo", methods={"GET"})
     * @param string $articleNumber
     * @return JsonResponse
     */
    public function getUserInfo(string $articleNumber): JsonResponse
    {
        try {
            $result = array('data' => 'test');
        } catch (ErrorException $error) {
            $message = sprintf("Fatal error: (%d) %s", $error->getCode(), $error->getMessage());
            return new JsonResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return empty($result) ? new JsonResponse([], Response::HTTP_NOT_FOUND) : new JsonResponse($result, Response::HTTP_OK);
    }


    /**
     * @Route("/", name="createUser", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $body = $request->getContent();
            $personObject = $this->serializer->deserialize($body, Person::class, Constants::REQUEST_FORMAT_JSON);
            $personObject->setMobile(str_replace("+", "", $personObject->getMobile()));

            $userObject = $this->serializer->deserialize($body, User::class, Constants::REQUEST_FORMAT_JSON);

            $duplicated = $this->service->searchDuplicated(
                empty($userObject->getUsername()) ? "" : $userObject->getUsername(), $userObject->getEmail(), $personObject->getMobile());

            if (!empty($duplicated)) {
                $data = "";
                foreach ($duplicated as $dup) {
                    if ($dup['duplicated'] === "email") $data = $data . Constants::RESULT_MESSAGE_DUPLICATED_EMAIL;
                    if ($dup['duplicated'] === "mobile") $data = $data . Constants::RESULT_MESSAGE_DUPLICATED_MOBILE;
                    if ($dup['duplicated'] === "username") $data = $data . Constants::RESULT_MESSAGE_DUPLICATED_USERNAME;
                }
                return new JsonResponse(
                    array(
                        Constants::RESULT_LABEL_STATUS => Constants::RESULT_DUPLICATED,
                        Constants::RESULT_LABEL_DATA => $data
                    ),
                    Response::HTTP_CREATED
                );
            }

            $person = $this->personService->save($personObject);

            $userObject->setUsername(empty($userObject->getUserName()) ? $userObject->getEmail() : $userObject->getUserName());
            $userObject->setPassword($this->passwordEncoder->encodePassword($userObject, $request->get("password")));
            $userObject->setRoles(array('ROLE_USER'));
            $userObject->setAppKey($this->util->generateUid()); //TODO analyst AppKey
            $userObject->setCreatedAt(date_create());
            $userObject->setUpdatedAt(date_create());
            $userObject->setUniqueId($this->userUtil->generateCodRef()[1]);
            $userObject->setIdPerson($person);

            $usesStatus = new Catalogue();
            $usesStatus->setIdCatalog(empty($request->get("user_status")) ? 0 : $request->get("user_status"));
            $userObject->setIdUserStatus(empty($request->get("user_status")) ? null : $usesStatus);

            $userType = new Catalogue();
            $userType->setIdCatalog(empty($request->get("user_type")) ? 0 : $request->get("user_type"));
            $userObject->setIdUserType(empty($request->get("user_type")) ? null : $userType);

            $userObjectResult = $this->service->save($userObject);

            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->arrayTransformer->toArray($userObjectResult)
                ),
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            $error = join('-', [$e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode(), $e->getTraceAsString()]);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_ERROR,
                    Constants::RESULT_LABEL_DATA => $error
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return $result;
    }
}