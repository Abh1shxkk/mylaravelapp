<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code','Barcode','name','Compcode','Compname','Pack','Unit','Location','Expiry','Generic','Saltcode','Strength','saltcode1','Strength1','saltcode2','Strength2','saltcode3','Strength3','Saltcode4','Strength4','Saltcode5','Strength5','Substitute','Saltno','Prate','Tsr','Psc','ptax','Excise','Scm1','scm2','Srate','Sc','Saletype','Stax','Wsrate','Add_sc','Add_tsr','Costrate','opqty','Clqty','status','Vdt','Batchcode','cname_bc','Defqty','BarcodeQty','splrate','Mrp','Ssc','WsNet','SplNet','Hscm','Box','CommonItem','Sscm1','FDis','Sscm2','FDisP','currentScm','ScmFrom','ScmTo','CurrScm1','CurrScm2','TrimName','PresReq','Division','QScm','SconMrp','VAT','Margin','Inclusive','ItemCat','Gdn','PRateCase','PRateBox','Desc1','Desc2','MinQty','MaxQty','ItCase','TRate','Wr','Pic','Mfg','TempOpqty','TempClqty','TempAmt','TempAmt1','TempAmt2','TaxonMrp','ScmPer','IWeight','SubStrenght','ItemRef','MaxInvQty','MaxQtyWr','OpFreeQty','VATonSrate','Exon','ExPer','UnitType','MfgQty','mTag','DisContinue','MfgBy','Vol','VDisP','VDisS','FDisWR','LastYearCost','OpAddQty','SaleLessQty','SplDisQty','SplDisPer','MinGP','LockScm','FullName','RateLock','MinRate','PurExciseAsRate','PurNetRate','CostWFQ','LockBilling','SameBatchCost','EsCode','FdisPWS','ItemType','ItemGroup','HSNCode','CGST','SGST','IGST','GSTCess','IucCode','Flag','miscsettings','SyncMark','is_deleted'
    ];
}


