<?php
// no direct access
defined( '_JEXEC' ) or die;

class plgProshoppsmsHostiran extends JPlugin
{
    /**
     * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
     * If you want to support 3.0 series you must override the constructor
     *
     * @var    boolean
     * @since  3.1
     */
    protected $autoloadLanguage = true;

    /**
     * Plugin method with the same name as the event will be called automatically.
     */
    function onOrderStatusChange($parameters)
	 {
         return '<li><i class="fa fa-check"></i> SMS</li>';
     }
}
?>