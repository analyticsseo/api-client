<?php
namespace Aseo\Api\Auth;

/**
* Analytics SEO API Authentication
*
* @version 1
*
* @author Nuno Franco da Costa <nuno@francodacosta.com>
* @copyright 2014 Analytics SEO ltd
* @license http://www.opensource.org/licenses/mit-license.php MIT
* @link https://github.com/analyticsseo/api-client/
*/

class KeyAuth
{
    /**
     * Api salt
     * @var string
     */
    private $salt;

    /**
     * Api secret
     * @var string
     */
    private $apiSecret;

    /**
     * Api Key
     * @var string
     */
    private $apiKey;

    public function computeHash()
    {
        $time = $this->getTimestamp();

        $hashSource = $time . $this->getApiKey() . $this->getSalt();
        $hash = hash_hmac('sha256', $hashSource, $this->getApiSecret());

        $header = 'Authorization: KeyAuth';
        $header .= ' publicKey=' . $this->getApiKey();
        $header .= ' hash=' . $hash;
        $header .= ' ts=' . $time;

        return $header;
    }

    /**
     * Get the value of Api salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set the value of Api salt
     *
     * @param string salt
     *
     * @return self
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get the value of Api secret
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * Set the value of Api secret
     *
     * @param string apiSecret
     *
     * @return self
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;

        return $this;
    }

    /**
     * Get the value of Api Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the value of Api Key
     *
     * @param string apiKey
     *
     * @return self
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get the value of current timestamp
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return time();
    }
}
