<?php
/**
 * Account Repository
 *
 *
 * @author          Eddie Jaoude
 * @package       Auth Module
 *
 */

use Doctrine\ORM\EntityRepository;
class Auth_Model_AccountRepository extends EntityRepository
{
    /**
     * Authenticate user
     *
     * @author          Eddie Jaoude
     * @param           string $hash
     * @param           array $data
     * @return           void
     *
     */
    public function authenticate($hash, $data)
    {
        # filter data
        if (empty($hash)) {
            throw new Exception('Hash required to Authenticate');
        }
        if (empty($data['email']) || empty($data['password'])) {
            throw new Exception('Email & Password required. You only supplied ' . $data);
        }

        # get data
        $result = $this->findOneBy(array(
                            'email' => (string)$data['email'],
                            'password' => (string)hash('SHA256', $hash . $data['password'])
                         ));

        return $result;
    }



    /**
     * One place to generate a new password
     * The length of the password is pass from the configuration of the module.
     *
     * @author Koen Huybrechts
     * @param int $length The length of the new password
     * @return string $password
     */

    public function generatePassword($length)
    {
        return substr(md5(rand().rand()), 0, $length);
    }

}