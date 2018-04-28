<?php
/**
 * File for the class which returns the class map definition
 * @package ColissimoPR
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * Class which returns the class map definition by the static method ColissimoPRClassMap::classMap()
 * @package ColissimoPR
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRClassMap
{
    /**
     * This method returns the array containing the mapping between WSDL structs and generated classes
     * This array is sent to the SoapClient when calling the WS
     * @return array
     */
    final public static function classMap()
    {
        return array (
  'Conges' => 'ColissimoPRStructConges',
  'PointRetrait' => 'ColissimoPRStructPointRetrait',
  'findInternalPointRetraitAcheminementByID' => 'ColissimoPRStructFindInternalPointRetraitAcheminementByID',
  'findInternalPointRetraitAcheminementByIDResponse' => 'ColissimoPRStructFindInternalPointRetraitAcheminementByIDResponse',
  'findInternalRDVPointRetraitAcheminement' => 'ColissimoPRStructFindInternalRDVPointRetraitAcheminement',
  'findInternalRDVPointRetraitAcheminementByID' => 'ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID',
  'findInternalRDVPointRetraitAcheminementByIDResponse' => 'ColissimoPRStructFindInternalRDVPointRetraitAcheminementByIDResponse',
  'findInternalRDVPointRetraitAcheminementResponse' => 'ColissimoPRStructFindInternalRDVPointRetraitAcheminementResponse',
  'findPointRetraitAcheminementByID' => 'ColissimoPRStructFindPointRetraitAcheminementByID',
  'findPointRetraitAcheminementByIDResponse' => 'ColissimoPRStructFindPointRetraitAcheminementByIDResponse',
  'findRDVPointRetraitAcheminement' => 'ColissimoPRStructFindRDVPointRetraitAcheminement',
  'findRDVPointRetraitAcheminementResponse' => 'ColissimoPRStructFindRDVPointRetraitAcheminementResponse',
  'pointRetraitAcheminement' => 'ColissimoPRStructPointRetraitAcheminement',
  'pointRetraitAcheminementByIDResult' => 'ColissimoPRStructPointRetraitAcheminementByIDResult',
  'pointRetraitAcheminementResult' => 'ColissimoPRStructPointRetraitAcheminementResult',
  'rdvPointRetraitAcheminementByIDResult' => 'ColissimoPRStructRdvPointRetraitAcheminementByIDResult',
  'rdvPointRetraitAcheminementResult' => 'ColissimoPRStructRdvPointRetraitAcheminementResult',
);
    }
}
