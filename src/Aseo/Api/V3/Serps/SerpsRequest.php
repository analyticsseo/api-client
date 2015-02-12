<?php
namespace Aseo\Api\V3\Serps;

/**
* Search Engine Results Page Request.
*
* This class emulates the api request you can make, it will try to validate as much of the data as possible
* before the request is sent to the api
*
* @version 3
*
* @author Nuno Franco da Costa <nuno@francodacosta.com>
* @copyright 2014 Analytics SEO ltd
* @license http://www.opensource.org/licenses/mit-license.php MIT
* @link https://github.com/analyticsseo/api-client/
*/

class SerpsRequest
{
    /**
     * Internal search engine name
     * @var string
     * @read-only
     */
    private $search_engine;

    /**
     * Region code
     * @var string
     * @read-only
     */
    private $region;

    /**
     * town name
     * @var string
     * @read-only
     */
    private $town;

    /**
     * The search type
     * @var string
     * @read-only
     */
    private $search_type ;

    /**
     * Language code
     * @var string
     * @read-only
     */
    private $language;

    /**
     * Maximun number of results to return
     * @var integer
     * @read-only
     */
    private $max_results;

    /**
     * The phrase to search for.
     * @var string
     * @read-only
     */
    private $phrase;

    /**
     * return universal search results
     * @var boolean
     * @read-only
     */
    private $universal;

    /**
     * Set to use a specific strategy
     * @var string
     * @read-only
     */
    private $strategy;

    /**
     * strategy configuration
     * @var array
     * @read-only
     */
    private $parameters;

    /**
     * list of supported search engines
     *
     * @var string[]
     * @private
     */
    private $supportedSearchEngines = array('bing', 'google', 'yahoo', 'yandex');

    public function __construct(array $data)
    {
        $this->populate($data);
    }

    /**
     * Populates this class with the values provided in the associative array.
     * the key must match one of the class properties
     *
     * @param  string[]  $data
     *
     * @return void
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            $this->populateField($key, $value);
        }
    }

    /**
     * Populates a class propertie.
     * This is done by calling the appropriate class setter
     *
     * @param string $field
     * @param mixed $value
     *
     * @return void
     */
    private function populateField($field, $value)
    {

        if ("search_engine" == $field) {
            return $this->setSearchEngine($value);
        }

        if ("region" == $field) {
            return $this->setRegion($value);
        }

        if ("town" == $field) {
            return $this->setTown($value);
        }

        if ("search_type" == $field) {
            return $this->setSearchType($value);
        }

        if ("language" == $field) {
            return $this->setLanguage($value);
        }

        if ("max_results" == $field) {
            return $this->setMaxResults($value);
        }

        if ("phrase" == $field) {
            return $this->setPhrase($value);
        }

        if ("universal" == $field) {
            return $this->setUniversal($value);
        }

        if ("strategy" == $field) {
            return $this->setStrategy($value);
        }

        if ("parameters" == $field) {
            return $this->setParameters($value);
        }

        throw new \OutOfBoundsException('SERPS call does not support the parameter ' . $field);

    }

    public function __toString()
    {
        $json = array();

        foreach (get_object_vars($this) as $variable => $value) {
            // supportedSearchEngines is internal, should not be present in the request
            if ("supportedSearchEngines" == $variable) {
                continue;
            }

            if (null != $value) {
                $json[$variable] = $value;
            }
        }
        return json_encode($json);
    }


    /**
     * Get the value of Internal search engine name
     *
     * @return string
     */
    public function getSearchEngine()
    {
        return $this->search_engine;
    }

    /**
     * Set the value of Internal search engine name
     *
     * @param string search_engine
     *
     * @return self
     */
    private function setSearchEngine($search_engine)
    {
        if (false === in_array($search_engine, $this->getSupportedSearchEngines())) {
            throw new \InvalidArgumentException('Search Engine is not supported');
        }

        $this->search_engine = $search_engine;

        return $this;
    }

    /**
     * Get the value of Region code
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set the value of Region code
     *
     * @param string region
     *
     * @return self
     */
    private function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get the value of town name
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set the value of town name
     *
     * @param string town
     *
     * @return self
     */
    private function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get the value of The search type
     *
     * @return string
     */
    public function getSearchType()
    {
        return $this->search_type;
    }

    /**
     * Set the value of The search type
     *
     * @param string search_type
     *
     * @return self
     */
    private function setSearchType($search_type)
    {
        $this->search_type = $search_type;

        return $this;
    }

    /**
     * Get the value of Language code
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set the value of Language code
     *
     * @param string language
     *
     * @return self
     */
    private function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get the value of Maximun number of results to return
     *
     * @return integer
     */
    public function getMaxResults()
    {
        return $this->max_results;
    }

    /**
     * Set the value of Maximun number of results to return
     *
     * @param integer max_results
     *
     * @return self
     */
    private function setMaxResults($max_results)
    {
        $this->max_results = $max_results;

        return $this;
    }

    /**
     * Get the value of The phrase to search for.
     *
     * @return string
     */
    public function getPhrase()
    {
        return $this->phrase;
    }

    /**
     * Set the value of The phrase to search for.
     *
     * @param string phrase
     *
     * @return self
     */
    private function setPhrase($phrase)
    {
        $this->phrase = $phrase;

        return $this;
    }

    /**
     * Get the value of return universal search results
     *
     * @return boolean
     */
    public function getUniversal()
    {
        return $this->universal;
    }

    /**
     * Set the value of return universal search results
     *
     * @param boolean universal
     *
     * @return self
     */
    private function setUniversal($universal)
    {
        $this->universal = $universal;

        return $this;
    }

    /**
     * Get the value of Set to use a specific strategy
     *
     * @return string
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * Set the value of Set to use a specific strategy
     *
     * @param string strategy
     *
     * @return self
     */
    private function setStrategy($strategy)
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * Get the value of strategy configuration
     *
     * @return object
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set the value of strategy configuration
     *
     * @param object parameters
     *
     * @return self
     */
    private function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get the value of list of supported search engines
     *
     * @return string[]
     */
    private function getSupportedSearchEngines()
    {
        return $this->supportedSearchEngines;
    }
}
