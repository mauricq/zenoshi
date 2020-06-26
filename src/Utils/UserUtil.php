<?php


namespace App\Utils;


use App\Entity\Constants;
use App\Repository\UserEntityRepository;


/**
 * Class UserUtil
 * @package App\Utils
 */
class UserUtil
{

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $repository;
    /**
     * @var Utils
     */
    protected Utils $utilUuid;

    /**
     * UserUtil constructor.
     * @param UserEntityRepository $repository
     * @param Utils $utilUuid
     */
    public function __construct(UserEntityRepository $repository, Utils $utilUuid)
    {
        $this->repository = $repository;
        $this->utilUuid = $utilUuid;
    }

    public function generateCodRef(): array
    {
        $keyVal = null;
        do {
            $generatedUniqueIds = $this->generateCodRefGroup();
            $resultVerification = $this->repository->searchUniqueIdDuplicated($generatedUniqueIds);
            foreach ($generatedUniqueIds as $key => $code) {
                if (array_key_exists($key, $resultVerification)) continue;
                else {
                    $keyVal = $key;
                    break;
                }
            }
        } while (!isset($keyVal));

        return $generatedUniqueIds[$keyVal];
    }

    public function generateCodRefGroup()
    {
        $tmpCodeRef = [];
        for ($i = 0; $i < Constants::UNIQUE_ID_GROUP_GENERATION; $tmpCodeRef[] = $this->utilUuid->generateCodRef(), $i++) ;
        return $tmpCodeRef;
    }

    public function generateCodRefGroupTest()
    {
        $codRef = [];
        try {
            $random = 'd131';
            $codRef[] = [hex2bin($random),$random];
            $random = '1cc4';
            $codRef[] = [hex2bin($random),$random];
            $random = random_bytes(3);
            $codRef[] = [$random, bin2hex($random)];
            $random = random_bytes(3);
            $codRef[] = [$random, bin2hex($random)];
            $random = 'fae762';
            $codRef[] = [hex2bin($random),$random];

        } catch (\Exception $e) {
        }

        return $codRef;
    }
}