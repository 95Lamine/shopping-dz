<?php
/**
 * File for the class which returns the class map definition
 * @package ColissimoAF
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * Class which returns the class map definition by the static method ColissimoAFClassMap::classMap()
 * @package ColissimoAF
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFClassMap
{
    /**
     * This method returns the array containing the mapping between WSDL structs and generated classes
     * This array is sent to the SoapClient when calling the WS
     * @return array
     */
    final public static function classMap()
    {
        return array (
  'GenerateLabelRequestType' => 'ColissimoAFStructGenerateLabelRequestType',
  'GenerateLabelResponseType' => 'ColissimoAFStructGenerateLabelResponseType',
  'GetListMailBoxPickingDatesResponseType' => 'ColissimoAFStructGetListMailBoxPickingDatesResponseType',
  'GetListMailBoxPickingDatesRetourRequestType' => 'ColissimoAFStructGetListMailBoxPickingDatesRetourRequestType',
  'GetProductInterRequestType' => 'ColissimoAFStructGetProductInterRequestType',
  'GetProductInterResponseType' => 'ColissimoAFStructGetProductInterResponseType',
  'Message' => 'ColissimoAFStructMessage',
  'address' => 'ColissimoAFStructAddress',
  'addressPCH' => 'ColissimoAFStructAddressPCH',
  'addressPickupLocation' => 'ColissimoAFStructAddressPickupLocation',
  'addressee' => 'ColissimoAFStructAddressee',
  'article' => 'ColissimoAFStructArticle',
  'baseResponse' => 'ColissimoAFStructBaseResponse',
  'belgiumLabel' => 'ColissimoAFStructBelgiumLabel',
  'category' => 'ColissimoAFStructCategory',
  'codeVAS' => 'ColissimoAFStructCodeVAS',
  'contents' => 'ColissimoAFStructContents',
  'customsDeclarations' => 'ColissimoAFStructCustomsDeclarations',
  'elementVisual' => 'ColissimoAFStructElementVisual',
  'field' => 'ColissimoAFStructField',
  'fields' => 'ColissimoAFStructFields',
  'generateLabel' => 'ColissimoAFStructGenerateLabel',
  'generateLabelRequest' => 'ColissimoAFStructGenerateLabelRequest',
  'generateLabelResponse' => 'ColissimoAFStructGenerateLabelResponse',
  'getListMailBoxPickingDates' => 'ColissimoAFStructGetListMailBoxPickingDates',
  'getListMailBoxPickingDatesResponse' => 'ColissimoAFStructGetListMailBoxPickingDatesResponse',
  'getListMailBoxPickingDatesRetourRequest' => 'ColissimoAFStructGetListMailBoxPickingDatesRetourRequest',
  'getProductInter' => 'ColissimoAFStructGetProductInter',
  'getProductInterRequest' => 'ColissimoAFStructGetProductInterRequest',
  'getProductInterResponse' => 'ColissimoAFStructGetProductInterResponse',
  'labelResponse' => 'ColissimoAFStructLabelResponse',
  'letter' => 'ColissimoAFStructLetter',
  'original' => 'ColissimoAFStructOriginal',
  'outputFormat' => 'ColissimoAFStructOutputFormat',
  'parcel' => 'ColissimoAFStructParcel',
  'pickupLocation' => 'ColissimoAFStructPickupLocation',
  'planPickup' => 'ColissimoAFStructPlanPickup',
  'planPickupRequest' => 'ColissimoAFStructPlanPickupRequest',
  'planPickupRequestType' => 'ColissimoAFStructPlanPickupRequestType',
  'planPickupResponse' => 'ColissimoAFStructPlanPickupResponse',
  'planPickupResponseType' => 'ColissimoAFStructPlanPickupResponseType',
  'returnAddressBelgium' => 'ColissimoAFStructReturnAddressBelgium',
  'routing' => 'ColissimoAFStructRouting',
  'sender' => 'ColissimoAFStructSender',
  'service' => 'ColissimoAFStructService',
  'site' => 'ColissimoAFStructSite',
  'xmlResponse' => 'ColissimoAFStructXmlResponse',
  'zoneCABRoutage' => 'ColissimoAFStructZoneCABRoutage',
  'zoneInfosRoutage' => 'ColissimoAFStructZoneInfosRoutage',
  'zoneRouting' => 'ColissimoAFStructZoneRouting',
);
    }
}
