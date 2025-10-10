<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code','Barcode','name','Compcode','Compname','Pack','Unit','Location','Expiry','Generic','Saltcode','Strength','saltcode1','Strength1','saltcode2','Strength2','saltcode3','Strength3','Saltcode4','Strength4','Saltcode5','Strength5','Substitute','Saltno','Prate','Tsr','Psc','ptax','Excise','Scm1','scm2','Srate','Sc','Saletype','Stax','Wsrate','Add_sc','Add_tsr','Costrate','opqty','Clqty','status','Vdt','Batchcode','cname_bc','Defqty','BarcodeQty','splrate','Mrp','Ssc','WsNet','SplNet','Hscm','Box','CommonItem','Sscm1','FDis','Sscm2','FDisP','currentScm','ScmFrom','ScmTo','CurrScm1','CurrScm2','TrimName','PresReq','Division','QScm','SconMrp','VAT','Margin','Inclusive','ItemCat','Gdn','PRateCase','PRateBox','Desc1','Desc2','MinQty','MaxQty','ItCase','TRate','Wr','Pic','Mfg','TempOpqty','TempClqty','TempAmt','TempAmt1','TempAmt2','TaxonMrp','ScmPer','IWeight','SubStrenght','ItemRef','MaxInvQty','MaxQtyWr','OpFreeQty','VATonSrate','Exon','ExPer','UnitType','MfgQty','mTag','DisContinue','MfgBy','Vol','VDisP','VDisS','FDisWR','LastYearCost','OpAddQty','SaleLessQty','SplDisQty','SplDisPer','MinGP','LockScm','FullName','RateLock','MinRate','PurExciseAsRate','PurNetRate','CostWFQ','LockBilling','SameBatchCost','EsCode','FdisPWS','ItemType','ItemGroup','HSNCode','CGST','SGST','IGST','GSTCess','IucCode','Flag','miscsettings','SyncMark','is_deleted','discount_amount','discount_percent'
    ];

    protected $casts = [
        // All fields are now VARCHAR to accept various data formats
        'Expiry' => 'string',
        'ScmFrom' => 'string',
        'ScmTo' => 'string',
        'status' => 'string',
        'is_deleted' => 'string',
        'DisContinue' => 'string',
        'LockScm' => 'string',
        'RateLock' => 'string',
        'Add_sc' => 'string',
        'Add_tsr' => 'string',
        'Vdt' => 'string',
        'Defqty' => 'string',
        'WsNet' => 'string',
        'SplNet' => 'string',
        'CommonItem' => 'string',
        'FDis' => 'string',
        'PresReq' => 'string',
        'discount',
        'Inclusive' => 'string',
        'Wr' => 'string',
        'TaxonMrp' => 'string',
        'VATonSrate' => 'string',
        'Exon' => 'string',
        'LockBilling' => 'string',
        'SameBatchCost' => 'string',
        'splrate' => 'string',
        'Mrp' => 'string',
        'FDisWR' => 'string',
    ];

    // Accessor methods to convert string values to float for calculations
    public function getPrateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getTsrAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getPtaxAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getExciseAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSrateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getStaxAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getWsrateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getAddScAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getAddTsrAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getCostrateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getOpqtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getClqtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getDefqtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSplrateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMrpAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getWsNetAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSplNetAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getFDisAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getFDisPAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getScmPerAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getWrAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSconMrpAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getVATAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMarginAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getPRateCaseAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getPRateBoxAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMinQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMaxQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getTRateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getTempOpqtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getTempClqtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getTempAmtAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getTempAmt1Attribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getTempAmt2Attribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getIWeightAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMaxInvQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMaxQtyWrAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getOpFreeQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getExPerAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMfgQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getVolAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getVDisPAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getVDisSAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getFDisWRAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getLastYearCostAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getOpAddQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSaleLessQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSplDisQtyAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSplDisPerAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMinGPAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getMinRateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getPurExciseAsRateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getPurNetRateAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getCostWFQAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getFdisPWSAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getCGSTAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getSGSTAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getIGSTAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    public function getGSTCessAttribute($value)
    {
        return $this->cleanNumericValue($value);
    }

    // Helper method to clean numeric values
    private function cleanNumericValue($value)
    {
        if (is_null($value) || $value === '') {
            return 0;
        }
        
        // Remove $ symbol and other non-numeric characters except decimal point and minus
        $cleaned = preg_replace('/[^0-9.-]/', '', $value);
        
        return floatval($cleaned);
    }
}


