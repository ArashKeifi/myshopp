<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

class JFormFieldProductStock extends JFormField  {

    protected $type = 'ProductStock';
    protected $id;
    protected $stocks;
    protected $skuLogs;

    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        $return = parent::setup($element, $value, $group);
        $this->id = JFactory::getApplication()->input->get('id');
        $db = JFactory::getDbo();
        $subquery = $db->getQuery(true);
        $subquery->select('s.id,s.name AS stockName,s.low_count,s.critical_count');
        $subquery->from($db->quoteName('#__shopp_stock','s'));
        $subquery->where('s.published = 1');
        $db->setQuery($subquery);
        $this->stocks = $db->loadObjectList();

        if($this->stocks){
            $query = $db->getQuery(true);
            $query->select('a.id,a.skuID,a.after_count,a.befor_count,a.datetime,a.order_id,a.stockID,b.name AS skuName');
            $query->from($db->quoteName('#__shopp_stock_log', 'a'));
            $query->join('RIGHT', $db->quoteName('#__shopp_product_sku', 'b') . ' ON (' . $db->quoteName('a.skuID') . ' = ' . $db->quoteName('b.sku') . ')');
            $query->where('a.product_id = '.$this->id);
            $query->order('a.datetime DESC');
            $db->setQuery($query);
            $this->skuLogs = $db->loadObjectList();
        }

        return $return;
    }
    protected function getInput()
    {
        if($this->stocks) {
            $this->session = JFactory::getSession();
            $html[] = JHtml::_('bootstrap.startTabSet', 'stock', array('active' => 'info'));
            $html[] = JHtml::_('bootstrap.addTab', 'stock', 'info', JText::_('JGLOBAL_FIELDSET_STOCK_INFO', true));
            $html[]='<div class="panel-body">';
            $html[]='<table class="table"><thead><tr><th class="col-lg-1">#</th><th class="col-lg-3">SKU name</th><th class="col-lg-8">Stocks Details</th></tr></thead><tbody>';
            $exist_sku=array();
            foreach($this->session->get('finalSku') AS $sku){
                if (!in_array($sku->sku, $exist_sku))
                {
                    array_push($exist_sku,$sku->sku);
                    $html[] = '<tr><td><span class="fa fa-th-large"></span></td>';
                    $html[] = '<td>' . $sku->name . '</td>';
                    $html[] = '<td>
                                ';
                    $stockAdd = array();
                    foreach ($this->stocks AS $stock) {
                        $html[] = '<div class="row"><div class="col-lg-4"><span style="color:#ccc">@</span>  '. $stock->stockName.'</div>';
                        $val='∞';
                            foreach ($this->skuLogs as $log){
                                if($log->stockID == $stock->id && $log->skuID == $sku->sku && !in_array($log->stockID, $stockAdd)){
                                    array_push($stockAdd,$log->stockID);
                                    $val= $log->after_count;
                                }
                            }
                        if($val == '∞'){
                            $ico='<span class="fa fa-battery-full text-navy" aria-hidden="true"></span>';
                        }elseif($val == 0 ){
                            $ico='<span class="fa fa-battery-empty text-muted" aria-hidden="true"></span>';
                        }elseif ($val <= $stock->critical_count){
                            $ico='<span class="fa fa-battery-quarter text-danger" aria-hidden="true"></span>';
                        }elseif ($val <= $stock->low_count){
                            $ico='<span class="fa fa-battery-half text-warning" aria-hidden="true"></span>';
                        }else{
                            $ico='<span class="fa fa-battery-three-quarters text-success" aria-hidden="true"></span>';
                        }
                        $html[] = '<div class="col-lg-1">'.$ico.'</div>';
                        $html[]='<div class="col-lg-2 m-b"><input type="hidden" value="'.$val.'" name="stock['.$sku->sku.']['.$stock->id.'][]"/><input style="padding: 2px; font-size: 11px; height: 20px;" class="form-control input-sm" type="text" placeholder="'.$val.'" name="stock['.$sku->sku.']['.$stock->id.'][]"/></div><div class="col-lg-5"></div></div>';
                    }
                    $html[] = '</td>';
                    $html[] = '</tr>';
                }
            }
            $html[]='</tbody></table>';
            $html[]='</div>';
            $html[] = JHtml::_('bootstrap.endTab');
            $html[] = JHtml::_('bootstrap.addTab', 'stock', 'update', JText::_('JGLOBAL_FIELDSET_STOCK_UPDATES', true));
            $html[]='<div class="panel-body">';
            $html[]='<table class="table"><thead><tr><th class="col-lg-2">SKU name</th>';
            foreach ($this->stocks AS $stock) {
                $html[] = '<th class="col-lg-1">'.$stock->stockName.'</th>';
            }
            $html[] = '<th class="col-lg-1">Date</th>';
            $html[]='</tr></thead><tbody>';
            foreach($this->skuLogs AS $skuLog){
                    $html[] = '<tr>';
                    $html[] = '<td>' . $skuLog->skuName .'</td>';

                    foreach ($this->stocks AS $stock) {
                        if($stock->id == $skuLog->stockID){
                            ($skuLog->after_count == '∞')? $skuLog->after_count = 0 : $skuLog->after_count = $skuLog->after_count;
                            $html[]='<th class="col-lg-1">'.($skuLog->after_count-$skuLog->befor_count).'</th>';
                        }else{
                            $html[]='<th class="col-lg-1"> </th>';
                        }
                    }
                    $html[] = '<td style="font-size: 10px">'.JHtml::date($skuLog->datetime,'D F n, Y g:i a',true).'</td>';
                    $html[] = '</tr>';
            }
            $html[]='</tbody></table>';
            $html[]='</div>';
            $html[] = JHtml::_('bootstrap.endTab');
            $html[] = JHtml::_('bootstrap.endTabSet');
        }else{
            $html[]='<div class="panel-body">';
            $html[]=JText::_('COM_PROSHOPP_NO_STOCK');
            $html[]='</div>';
        }
        return implode($html);
    }
}