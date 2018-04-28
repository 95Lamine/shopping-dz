<?php
/**
 * File for class ColissimoAFStructArticle
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructArticle originally named article
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructArticle extends ColissimoAFWsdlClass
{
    /**
     * The description
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $description;
    /**
     * The quantity
     * @var int
     */
    public $quantity;
    /**
     * The weight
     * @var float
     */
    public $weight;
    /**
     * The value
     * @var float
     */
    public $value;
    /**
     * The hsCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $hsCode;
    /**
     * The originCountry
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $originCountry;
    /**
     * The currency
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $currency;
    /**
     * The artref
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $artref;
    /**
     * The originalIdent
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $originalIdent;
    /**
     * Constructor method for article
     * @see parent::__construct()
     * @param string $_description
     * @param int $_quantity
     * @param float $_weight
     * @param float $_value
     * @param string $_hsCode
     * @param string $_originCountry
     * @param string $_currency
     * @param string $_artref
     * @param string $_originalIdent
     * @return ColissimoAFStructArticle
     */
    public function __construct($_description = NULL,$_quantity = NULL,$_weight = NULL,$_value = NULL,$_hsCode = NULL,$_originCountry = NULL,$_currency = NULL,$_artref = NULL,$_originalIdent = NULL)
    {
        parent::__construct(array('description'=>$_description,'quantity'=>$_quantity,'weight'=>$_weight,'value'=>$_value,'hsCode'=>$_hsCode,'originCountry'=>$_originCountry,'currency'=>$_currency,'artref'=>$_artref,'originalIdent'=>$_originalIdent),false);
    }
    /**
     * Get description value
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set description value
     * @param string $_description the description
     * @return string
     */
    public function setDescription($_description)
    {
        return ($this->description = $_description);
    }
    /**
     * Get quantity value
     * @return int|null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * Set quantity value
     * @param int $_quantity the quantity
     * @return int
     */
    public function setQuantity($_quantity)
    {
        return ($this->quantity = $_quantity);
    }
    /**
     * Get weight value
     * @return float|null
     */
    public function getWeight()
    {
        return $this->weight;
    }
    /**
     * Set weight value
     * @param float $_weight the weight
     * @return float
     */
    public function setWeight($_weight)
    {
        return ($this->weight = $_weight);
    }
    /**
     * Get value value
     * @return float|null
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * Set value value
     * @param float $_value the value
     * @return float
     */
    public function setValue($_value)
    {
        return ($this->value = $_value);
    }
    /**
     * Get hsCode value
     * @return string|null
     */
    public function getHsCode()
    {
        return $this->hsCode;
    }
    /**
     * Set hsCode value
     * @param string $_hsCode the hsCode
     * @return string
     */
    public function setHsCode($_hsCode)
    {
        return ($this->hsCode = $_hsCode);
    }
    /**
     * Get originCountry value
     * @return string|null
     */
    public function getOriginCountry()
    {
        return $this->originCountry;
    }
    /**
     * Set originCountry value
     * @param string $_originCountry the originCountry
     * @return string
     */
    public function setOriginCountry($_originCountry)
    {
        return ($this->originCountry = $_originCountry);
    }
    /**
     * Get currency value
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
     * Set currency value
     * @param string $_currency the currency
     * @return string
     */
    public function setCurrency($_currency)
    {
        return ($this->currency = $_currency);
    }
    /**
     * Get artref value
     * @return string|null
     */
    public function getArtref()
    {
        return $this->artref;
    }
    /**
     * Set artref value
     * @param string $_artref the artref
     * @return string
     */
    public function setArtref($_artref)
    {
        return ($this->artref = $_artref);
    }
    /**
     * Get originalIdent value
     * @return string|null
     */
    public function getOriginalIdent()
    {
        return $this->originalIdent;
    }
    /**
     * Set originalIdent value
     * @param string $_originalIdent the originalIdent
     * @return string
     */
    public function setOriginalIdent($_originalIdent)
    {
        return ($this->originalIdent = $_originalIdent);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructArticle
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
