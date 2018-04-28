<?php
/**
 * File for class ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID originally named findInternalRDVPointRetraitAcheminementByID
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID extends ColissimoPRWsdlClass
{
    /**
     * The accountNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $accountNumber;
    /**
     * The password
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $password;
    /**
     * The id
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $id;
    /**
     * The reseau
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $reseau;
    /**
     * The langue
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $langue;
    /**
     * The date
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $date;
    /**
     * The weight
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $weight;
    /**
     * The filterRelay
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $filterRelay;
    /**
     * Constructor method for findInternalRDVPointRetraitAcheminementByID
     * @see parent::__construct()
     * @param string $_accountNumber
     * @param string $_password
     * @param string $_id
     * @param string $_reseau
     * @param string $_langue
     * @param string $_date
     * @param string $_weight
     * @param string $_filterRelay
     * @return ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID
     */
    public function __construct($_accountNumber = NULL,$_password = NULL,$_id = NULL,$_reseau = NULL,$_langue = NULL,$_date = NULL,$_weight = NULL,$_filterRelay = NULL)
    {
        parent::__construct(array('accountNumber'=>$_accountNumber,'password'=>$_password,'id'=>$_id,'reseau'=>$_reseau,'langue'=>$_langue,'date'=>$_date,'weight'=>$_weight,'filterRelay'=>$_filterRelay),false);
    }
    /**
     * Get accountNumber value
     * @return string|null
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    /**
     * Set accountNumber value
     * @param string $_accountNumber the accountNumber
     * @return string
     */
    public function setAccountNumber($_accountNumber)
    {
        return ($this->accountNumber = $_accountNumber);
    }
    /**
     * Get password value
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set password value
     * @param string $_password the password
     * @return string
     */
    public function setPassword($_password)
    {
        return ($this->password = $_password);
    }
    /**
     * Get id value
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id value
     * @param string $_id the id
     * @return string
     */
    public function setId($_id)
    {
        return ($this->id = $_id);
    }
    /**
     * Get reseau value
     * @return string|null
     */
    public function getReseau()
    {
        return $this->reseau;
    }
    /**
     * Set reseau value
     * @param string $_reseau the reseau
     * @return string
     */
    public function setReseau($_reseau)
    {
        return ($this->reseau = $_reseau);
    }
    /**
     * Get langue value
     * @return string|null
     */
    public function getLangue()
    {
        return $this->langue;
    }
    /**
     * Set langue value
     * @param string $_langue the langue
     * @return string
     */
    public function setLangue($_langue)
    {
        return ($this->langue = $_langue);
    }
    /**
     * Get date value
     * @return string|null
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Set date value
     * @param string $_date the date
     * @return string
     */
    public function setDate($_date)
    {
        return ($this->date = $_date);
    }
    /**
     * Get weight value
     * @return string|null
     */
    public function getWeight()
    {
        return $this->weight;
    }
    /**
     * Set weight value
     * @param string $_weight the weight
     * @return string
     */
    public function setWeight($_weight)
    {
        return ($this->weight = $_weight);
    }
    /**
     * Get filterRelay value
     * @return string|null
     */
    public function getFilterRelay()
    {
        return $this->filterRelay;
    }
    /**
     * Set filterRelay value
     * @param string $_filterRelay the filterRelay
     * @return string
     */
    public function setFilterRelay($_filterRelay)
    {
        return ($this->filterRelay = $_filterRelay);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
