<?php


namespace App\Controller;

use App\Controller\Share\ControllerProvider;
use App\Entity\Constants;
use App\Entity\Person;
use App\Entity\User;
use App\Service\UserService;
use App\Service\PersonService;
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
 * Class ArticleController
 * @package App\Controller
 */
class UserController extends ControllerProvider
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var PersonService
     */
    private $personService;

    /**
     * User constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param UserService $userService
     * @param PersonService $personService
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                UserService $userService,
                                PersonService $personService,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($arrayTransformer, $serializer, $userService);
        $this->passwordEncoder = $passwordEncoder;
        $this->personService = $personService;
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
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $body = $request->getContent();
            $personObject = $this->serializer->deserialize($body, Person::class, Constants::REQUEST_FORMAT_JSON);
            $userObject = $this->serializer->deserialize($body, User::class, Constants::REQUEST_FORMAT_JSON);

            $personExist = $this->personService->filterBy(['mobile' => $personObject->getMobile()]);
            $userExist = $this->service->filterBy(['email' => $userObject->getEmail()]);
            if (!empty($userExist) or !empty($personExist)) {
                $data = "";
                $data = !empty($userExist) ? $data . Constants::RESULT_MESSAGE_DUPLICATED_EMAIL : $data;
                $data = !empty($personExist) ? $data . Constants::RESULT_MESSAGE_DUPLICATED_MOBILE : $data;
                return new JsonResponse(
                    array(
                        Constants::RESULT_LABEL_STATUS => Constants::RESULT_DUPLICATED,
                        Constants::RESULT_LABEL_DATA => $data
                    ),
                    Response::HTTP_CREATED
                );
            }

            $person = $this->personService->save($personObject);

            $userObject->setUsername($userObject->getEmail());
            $userObject->setPlainPassword($userObject->getPassword());
            $userObject->setPassword($this->passwordEncoder->encodePassword($userObject, $userObject->getPlainPassword()));
            $userObject->setRoles(array('ROLE_USER'));
            $userObject->setAppKey($this->util->generateUid()); //TODO analyst AppKey
            $userObject->setCreatedAt(date_create());
            $userObject->setUpdatedAt(date_create());
            $userObject->setUniqueId($userObject->getAppKey());
            $userObject->setIdPerson($person);
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