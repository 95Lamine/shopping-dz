<?php
/**
 * File for class ColissimoAFStructPickupLocation
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructPickupLocation originally named pickupLocation
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructPickupLocation extends ColissimoAFWsdlClass
{
    /**
     * The address
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructAddressPickupLocation
     */
    public $address;
    /**
     * The groupRouting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $groupRouting;
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $name;
    /**
     * The netWork
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $netWork;
    /**
     * The pointId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $pointId;
    /**
     * The routingFileVersion
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $routingFileVersion;
    /**
     * The routingZipCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $routingZipCode;
    /**
     * The serviceLabel
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $serviceLabel;
    /**
     * The sortDistribution
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $sortDistribution;
    /**
     * Constructor method for pickupLocation
     * @see parent::__construct()
     * @param ColissimoAFStructAddressPickupLocation $_address
     * @param string $_groupRouting
     * @param string $_name
     * @param string $_netWork
     * @param string $_pointId
     * @param string $_routingFileVersion
     * @param string $_routingZipCode
     * @param string $_serviceLabel
     * @param string $_sortDistribution
     * @return ColissimoAFStructPickupLocation
     */
    public function __construct($_address = NULL,$_groupRouting = NULL,$_name = NULL,$_netWork = NULL,$_pointId = NULL,$_routingFileVersion = NULL,$_routingZipCode = NULL,$_serviceLabel = NULL,$_sortDistribution = NULL)
    {
        parent::__construct(array('address'=>$_address,'groupRouting'=>$_groupRouting,'name'=>$_name,'netWork'=>$_netWork,'pointId'=>$_pointId,'routingFileVersion'=>$_routingFileVersion,'routingZipCode'=>$_routingZipCode,'serviceLabel'=>$_serviceLabel,'sortDistribution'=>$_sortDistribution),false);
    }
    /**
     * Get address value
     * @return ColissimoAFStructAddressPickupLocation|null
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set address value
     * @param ColissimoAFStructAddressPickupLocation $_address the address
     * @return ColissimoAFStructAddressPickupLocation
     */
    public function setAddress($_address)
    {
        return ($this->address = $_address);
    }
    /**
     * Get groupRouting value
     * @return string|null
     */
    public function getGroupRouting()
    {
        return $this->groupRouting;
    }
    /**
     * Set groupRouting value
     * @param string $_groupRouting the groupRouting
     * @return string
     */
    public function setGroupRouting($_groupRouting)
    {
        return ($this->groupRouting = $_groupRouting);
    }
    /**
     * Get name value
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Get netWork value
     * @return string|null
     */
    public function getNetWork()
    {
        return $this->netWork;
    }
    /**
     * Set netWork value
     * @param string $_netWork the netWork
     * @return string
     */
    public function setNetWork($_netWork)
    {
        return ($this->netWork = $_netWork);
    }
    /**
     * Get pointId value
     * @return string|null
     */
    public function getPointId()
    {
        return $this->pointId;
    }
    /**
     * Set pointId value
     * @param string $_pointId the pointId
     * @return string
     */
    public function setPointId($_pointId)
    {
        return ($this->pointId = $_pointId);
    }
    /**
     * Get routingFileVersion value
     * @return string|null
     */
    public function getRoutingFileVersion()
    {
        return $this->routingFileVersion;
    }
    /**
     * Set routingFileVersion value
     * @param string $_routingFileVersion the routingFileVersion
     * @return string
     */
    public function setRoutingFileVersion($_routingFileVersion)
    {
        return ($this->routingFileVersion = $_routingFileVersion);
    }
    /**
     * Get routingZipCode value
     * @return string|null
     */
    public function getRoutingZipCode()
    {
        return $this->routingZipCode;
    }
    /**
     * Set routingZipCode value
     * @param string $_routingZipCode the routingZipCode
     * @return string
     */
    public function setRoutingZipCode($_routingZipCode)
    {
        return ($this->routingZipCode = $_routingZipCode);
    }
    /**
     * Get serviceLabel value
     * @return string|null
     */
    public function getServiceLabel()
    {
        return $this->serviceLabel;
    }
    /**
     * Set serviceLabel value
     * @param string $_serviceLabel the serviceLabel
     * @return string
     */
    public function setServiceLabel($_serviceLabel)
    {
        return ($this->serviceLabel = $_serviceLabel);
    }
    /**
     * Get sortDistribution value
     * @return string|null
     */
    public function getSortDistribution()
    {
        return $this->sortDistribution;
    }
    /**
     * Set sortDistribution value
     * @param string $_sortDistribution the sortDistribution
     * @return string
     */
    public function setSortDistribution($_sortDistribution)
    {
        return ($this->sortDistribution = $_sortDistribution);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructPickupLocation
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
