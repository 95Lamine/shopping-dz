<?php
/**
 * File for class ColissimoAFStructGetListMailBoxPickingDatesResponseType
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGetListMailBoxPickingDatesResponseType originally named GetListMailBoxPickingDatesResponseType
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGetListMailBoxPickingDatesResponseType extends ColissimoAFStructBaseResponse
{
    /**
     * The mailBoxPickingDateMaxHour
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $mailBoxPickingDateMaxHour;
    /**
     * The mailBoxPickingDates
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var dateTime
     */
    public $mailBoxPickingDates;
    /**
     * The validityTime
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $validityTime;
    /**
     * Constructor method for GetListMailBoxPickingDatesResponseType
     * @see parent::__construct()
     * @param string $_mailBoxPickingDateMaxHour
     * @param dateTime $_mailBoxPickingDates
     * @param string $_validityTime
     * @return ColissimoAFStructGetListMailBoxPickingDatesResponseType
     */
    public function __construct($_mailBoxPickingDateMaxHour = NULL,$_mailBoxPickingDates = NULL,$_validityTime = NULL)
    {
        ColissimoAFWsdlClass::__construct(array('mailBoxPickingDateMaxHour'=>$_mailBoxPickingDateMaxHour,'mailBoxPickingDates'=>$_mailBoxPickingDates,'validityTime'=>$_validityTime),false);
    }
    /**
     * Get mailBoxPickingDateMaxHour value
     * @return string|null
     */
    public function getMailBoxPickingDateMaxHour()
    {
        return $this->mailBoxPickingDateMaxHour;
    }
    /**
     * Set mailBoxPickingDateMaxHour value
     * @param string $_mailBoxPickingDateMaxHour the mailBoxPickingDateMaxHour
     * @return string
     */
    public function setMailBoxPickingDateMaxHour($_mailBoxPickingDateMaxHour)
    {
        return ($this->mailBoxPickingDateMaxHour = $_mailBoxPickingDateMaxHour);
    }
    /**
     * Get mailBoxPickingDates value
     * @return dateTime|null
     */
    public function getMailBoxPickingDates()
    {
        return $this->mailBoxPickingDates;
    }
    /**
     * Set mailBoxPickingDates value
     * @param dateTime $_mailBoxPickingDates the mailBoxPickingDates
     * @return dateTime
     */
    public function setMailBoxPickingDates($_mailBoxPickingDates)
    {
        return ($this->mailBoxPickingDates = $_mailBoxPickingDates);
    }
    /**
     * Get validityTime value
     * @return string|null
     */
    public function getValidityTime()
    {
        return $this->validityTime;
    }
    /**
     * Set validityTime value
     * @param string $_validityTime the validityTime
     * @return string
     */
    public function setValidityTime($_validityTime)
    {
        return ($this->validityTime = $_validityTime);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGetListMailBoxPickingDatesResponseType
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
