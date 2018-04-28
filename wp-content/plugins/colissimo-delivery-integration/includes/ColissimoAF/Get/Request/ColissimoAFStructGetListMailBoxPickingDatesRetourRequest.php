<?php
/**
 * File for class ColissimoAFStructGetListMailBoxPickingDatesRetourRequest
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGetListMailBoxPickingDatesRetourRequest originally named getListMailBoxPickingDatesRetourRequest
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGetListMailBoxPickingDatesRetourRequest extends ColissimoAFWsdlClass
{
    /**
     * The contractNumber
     * @var string
     */
    public $contractNumber;
    /**
     * The password
     * @var string
     */
    public $password;
    /**
     * The sender
     * @var ColissimoAFStructSender
     */
    public $sender;
    /**
     * Constructor method for getListMailBoxPickingDatesRetourRequest
     * @see parent::__construct()
     * @param string $_contractNumber
     * @param string $_password
     * @param ColissimoAFStructSender $_sender
     * @return ColissimoAFStructGetListMailBoxPickingDatesRetourRequest
     */
    public function __construct($_contractNumber = NULL,$_password = NULL,$_sender = NULL)
    {
        parent::__construct(array('contractNumber'=>$_contractNumber,'password'=>$_password,'sender'=>$_sender),false);
    }
    /**
     * Get contractNumber value
     * @return string|null
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }
    /**
     * Set contractNumber value
     * @param string $_contractNumber the contractNumber
     * @return string
     */
    public function setContractNumber($_contractNumber)
    {
        return ($this->contractNumber = $_contractNumber);
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
     * Get sender value
     * @return ColissimoAFStructSender|null
     */
    public function getSender()
    {
        return $this->sender;
    }
    /**
     * Set sender value
     * @param ColissimoAFStructSender $_sender the sender
     * @return ColissimoAFStructSender
     */
    public function setSender($_sender)
    {
        return ($this->sender = $_sender);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGetListMailBoxPickingDatesRetourRequest
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
