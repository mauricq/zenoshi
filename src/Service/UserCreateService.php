<?php


namespace App\Service;


use App\Entity\Catalogue;
use App\Entity\Constants;
use App\Entity\EntityProvider;
use App\Entity\Person;
use App\Entity\User;
use App\Entity\UserFacebook;
use App\Errors\DuplicatedException;
use App\Service\Share\IServiceProviderInterface;
use App\Utils\UserUtil;
use App\Utils\Utils;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCreateService
{
    /**
     * @var ArrayTransformerInterface
     */
    protected ArrayTransformerInterface $arrayTransformer;
    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;
    /**
     * @var IServiceProviderInterface
     */
    protected IServiceProviderInterface $service;
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
     * @var Utils
     */
    public Utils $util;

    /**
     * @required
     * @param Utils $util
     */
    public function setUtil(Utils $util): void
    {
        $this->util = $util;
    }

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
    public function __construct(ArrayTransformerInterface $arrayTransformer,
                                SerializerInterface $serializer,
                                UserService $service,
                                PersonService $personService,
                                UserPasswordEncoderInterface $passwordEncoder,
                                CatalogueService $catalogueService,
                                UserUtil $userUtil)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer = $serializer;
        $this->service = $service;
        $this->passwordEncoder = $passwordEncoder;
        $this->personService = $personService;
        $this->catalogueService = $catalogueService;
        $this->userUtil = $userUtil;
    }

    /**
     * @param Request $request
     * @return EntityProvider|UserInterface|null
     * @throws DuplicatedException
     */
    public function create(Request $request)
    {
        $body = $request->getContent();
        $personObject = $this->serializer->deserialize($body, Person::class, Constants::REQUEST_FORMAT_JSON);
        $personObject->setMobile(str_replace("+", "", $personObject->getMobile()));

        $userObject = $this->serializer->deserialize($body, User::class, Constants::REQUEST_FORMAT_JSON);
        $userObject->setUsername(empty($userObject->getUserName()) ? $userObject->getEmail() : $userObject->getUserName());

        $duplicated = $this->service->searchDuplicated(
            empty($userObject->getUsername()) ? "" : $userObject->getUsername(), $userObject->getEmail(), $personObject->getMobile());

        if (!empty($duplicated)) {
            $data = "";
            foreach ($duplicated as $dup) {
                if ($dup['duplicated'] === "email") $data = $data . Constants::RESULT_MESSAGE_DUPLICATED_EMAIL;
                if ($dup['duplicated'] === "mobile") $data = $data . Constants::RESULT_MESSAGE_DUPLICATED_MOBILE;
                if ($dup['duplicated'] === "username") $data = $data . Constants::RESULT_MESSAGE_DUPLICATED_USERNAME;
            }
            $exception = new DuplicatedException(Constants::RESULT_DUPLICATED . "Data ");
            $exception->setMessage($data);
            throw $exception;
        }

        $person = $this->personService->save($personObject);

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

        return $this->service->save($userObject);
    }

    /**
     * @param Request $request
     * @return EntityProvider|UserInterface|null
     */
    public function createByFacebook(Request $request)
    {
        $body = $request->getContent();
        $facebookObject = $this->serializer->deserialize($body, UserFacebook::class, Constants::REQUEST_FORMAT_JSON);

        $personObject = new Person();
        $personObject->setMobile("");
        $personObject->setName($facebookObject->getFirstName());
        $personObject->setLastName($facebookObject->getLastName());
        $personObject->setIdentificationNumber($facebookObject->getId());
        $personObject->setIdentificationType("FACEBOOK_ID");

        $userObject = new User();
        $userObject->setUsername($facebookObject->getEmail());
        $userObject->setPassword($facebookObject->getId());
        $userObject->setEmail($facebookObject->getEmail());

        $duplicated = $this->service->searchDuplicated(
            $userObject->getUsername(), $userObject->getEmail(), null);

        $alreadyRegistered = empty($duplicated);
        if ($alreadyRegistered) {
//            $criteria = [
//                "identificationType" => $personObject->getIdentificationType(),
//                "identificationNumber" => $personObject->getIdentificationNumber()
//            ];
            //$person = $this->personService->saveAndSearchBy($personObject, $criteria);

            $userObject->setPassword($this->passwordEncoder->encodePassword($userObject, $userObject->getPassword()));
            $userObject->setRoles(array('ROLE_USER'));
            $userObject->setAppKey($this->util->generateUid()); //TODO analyst AppKey
            $userObject->setCreatedAt(date_create());
            $userObject->setUpdatedAt(date_create());
            $userObject->setUniqueId($this->userUtil->generateCodRef()[1]);
            $userObject->setIdPerson($personObject);

            $usesStatus = new Catalogue();
            $usesStatus->setIdCatalog(2);
            $userObject->setIdUserStatus($usesStatus);

            $userType = new Catalogue();
            $userType->setIdCatalog(65);// TODO including facebook user type
            $userObject->setIdUserType($userType);

            $userObject->setIdPerson($personObject);
            $this->service->save($userObject);
            $userObject->setStatusFacebook("CREATED");
        } else {
            $criteria = [
                "email" => $userObject->getEmail(),
                "username" => $userObject->getEmail()
            ];
            $userObject = $this->service->filterBy($criteria)[0];
            $userObject->setStatusFacebook("LOGGED");
        }
        return $userObject;
    }

}