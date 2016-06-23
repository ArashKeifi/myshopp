<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');
JFormHelper::loadFieldClass('imagelist');
jimport('joomla.filesystem.folder');
class JFormFieldProductSkus extends JFormField  {

    protected $type = 'ProductSkus';
    protected $skus;
    protected $id;
    protected $session;

    public function setup(SimpleXMLElement $element, $value, $group = null){
        $this->session = JFactory::getSession();
        $return = parent::setup($element, $value, $group);
        $this->id = JFactory::getApplication()->input->get('id');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.sku,a.pattern,a.name,b.price,a.off_price,a.compare_price,b.date,a.published,a.weight,a.image');
        $query->from($db->quoteName('#__shopp_product_sku', 'a'));
        $query->leftJoin('#__shopp_sku_price AS b ON a.sku = b.skuID');
        $query->where('a.product_id = '.$this->id);
        $query->order('b.date DESC');
        $db->setQuery($query);
        $this->skus = $db->loadObjectList();
        $this->session->set('finalSku',$this->skus);
        return $return;
    }
    protected function getInput(){
        $html[]='<table class="table table-striped skuproduct"><thead><tr><th class="col-lg-1">sku</th><th class="col-lg-2">SKU name</th><th class="col-lg-1">Price</th><th class="col-lg-2">Purchase price</th><th class="col-lg-1"><del>Compare at price</del></th><th class="col-lg-1">Weight</th><th style="text-align: center" class="col-lg-2">Image</th><th style="text-align: center" class="col-lg-1">Status</th><th style="text-align: center">Action</th></tr></thead><tbody>';
        $exist_sku=array();
        foreach($this->skus as $sku )
        {
            if (!in_array($sku->sku, $exist_sku))
            {
                array_push($exist_sku,$sku->sku);
                $html[] = '<tr>';
                $html[] = '<td><input type="hidden" name="skus[' . $sku->id . '][id]" value="' . $sku->id . '" ><input type="hidden" name="skus[' . $sku->id . '][pattern]" value="' . $sku->pattern . '" >';
                $html[] = '<input readonly="readonly" class="form-control input-sm" type="text" name="skus[' . $sku->id . '][skuid]" id="jform_feature_test_sample" value="' . $sku->sku . '" size="20"></td>';
                $html[] = '<td><input readonly="readonly" class="form-control input-sm" type="text" name="skus[' . $sku->id . '][name]" id="jform_feature_test_sample" value="' . $sku->name . '" size="20"></td>';
                $html[] = '<td><input class="form-control input-sm" type="text" name="skus[' . $sku->id . '][price]" id="jform_feature_test_sample" value="' . $sku->price . '" size="20"></td>';
                $html[] = '<td><input class="form-control input-sm" type="text" name="skus[' . $sku->id . '][off_price]" id="jform_feature_test_sample" value="' . $sku->off_price . '" size="20"></td>';
                $html[] = '<td><input class="form-control input-sm" type="text" name="skus[' . $sku->id . '][compare_price]" id="jform_feature_test_sample" value="' . $sku->compare_price . '" size="20"></td>';
                $html[] = '<td><input class="form-control input-sm" type="text" name="skus[' . $sku->id . '][weight]" id="jform_feature_test_sample" value="' . $sku->weight . '" size="20"></td>';

                $html[]    = '<td>';
                $field     = new JFormFieldImageList();
                $directory = JFolder::exists('../images/product/' . $this->id . '/') ? "images/product/" . $this->id : '';
                $field->setup(new SimpleXMLElement('<field class="product_image form-control input-sm" name="skus[' . $sku->id . '][image]" type="imagelist"  directory="' . $directory . '"  hide_default="true" />'), $sku->image);
                $html[] = $field->renderField(array('hiddenLabel' => true));
                $html[] = '</td>';
                $html[] = '<td class="center"><input type="hidden" name="skus[' . $sku->id . '][id]" value="' . $sku->id . '">';
                $field  = new JFormFieldList();
                $field->setup(new SimpleXMLElement('<field name="skus[' . $sku->id . '][published]" type="list" size="1" default="0" class="form-control input-sm"><option value="1">JPUBLISHED</option><option value="0">JUNPUBLISHED</option></field>'), $sku->published);
                $html[] = $field->renderField(array('hiddenLabel' => true));
                $html[] = '</td>';
                $html[] = '<td class="center"><i class="fa fa-trash"></i></td>';
                $html[] = '</tr>';
            }
        }
        $html[]='</tbody></table>';
        $document = JFactory::getDocument();
        $document->addStyleSheet('components/com_proshopp/assets/theme/css/plugins/c3/c3.min.css');
        $document->addScript('components/com_proshopp/assets/theme/js/plugins/c3/c3.min.js');
        $document->addScript('components/com_proshopp/assets/theme/js/plugins/d3/d3.min.js');
        jimport( 'joomla.html.html' );
        $exist_sku=array();
        $i=1;
        $columns='';
        $xs='';
        $types='';
        foreach($this->skus as $sku )
        {
            $culom='';
            $date='';
            if (!in_array($sku->sku, $exist_sku)) {
                array_push($exist_sku, $sku->sku);
                if($i != 1){
                    $culom=",";
                    $date=",";
                }else{
                    $date=",";
                }
                $culom.="['".$sku->name."'";
                $date.="['x".$i."'";
                $xs.="'".$sku->name."':'x".$i."',";
                $types.="'".$sku->name."': 'step',";
                $first=true;
                foreach($this->skus as $skuItem ){
                    if($skuItem->sku == $sku->sku){
                        if($first){
                            $this->session->set($sku->sku,$skuItem->price);
                            $first=false;
                        }
                        $culom.=",".$skuItem->price;
                        $date.=",'".JHtml::date($skuItem->date , 'Y-m-d', true)."'";
                    }
                }
                $culom.="]";
                $date.="]";
                //$script .= ",'".JHtml::date($sku->date , 'Ym-d')."'";
            }
            $columns.= $culom;
            $columns.=$date;
            $i++;
        }
        $script="
        jQuery(function () {
					var chart = c3.generate({
						bindto: '#chart',
						padding: {
        top: 40,
        right: 110,
        bottom: 40,
        left: 60,
    },
						data: {
                            xs: {
                                ".$xs."
                            },
							columns: [
							";
        $script.=$columns."],
        types: {
            ".$types."
        }},
    axis: {
        x: {
        label: {
                text: 'Date',
                position: 'outer-center'
            },
            type: 'timeseries',
            localtime: false,
            tick: {
                format: '%e %b %y'
            }
        },
        y2: {
            show: true,
            label: {
                text: 'Price',
                position: 'outer-center'
            }
        },
        y: {
            label: {
                text: 'Price',
                position: 'outer-middle'
            }
        }
    },
    grid: {
        x: {
            show: true
        },
        y: {
            show: true
        }
    },point: {
            show: true
        }
					});

				});
        ";
        $document->addScriptDeclaration($script);

        $html[]='<div id="chart"></div>';
        return implode($html);
    }


}