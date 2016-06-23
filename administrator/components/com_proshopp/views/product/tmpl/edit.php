<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
include_once JPATH_BASE.DS."components".DS."com_proshopp".DS."views".DS."main.php";
JHtml::_('behavior.formvalidator');
?>
<script>
    Joomla.submitbutton = function(task)
    {
        if (task == '')
        {
            return false;
        }
        else
        {
            var isValid=true;
            var action = task.split('.');
            if (action[1] != 'cancel' && action[1] != 'close')
            {
                var forms = $$('form.form-validate');
                for (var i=0;i<forms.length;i++)
                {
                    if (!document.formvalidator.isValid(forms[i]))
                    {
                        isValid = false;
                        break;
                    }
                }
            }

            if (isValid)
            {
                Joomla.submitform(task);
                return true;
            }
            else
            {
                alert(Joomla.JText._('COM_PROSHOPP_ERROR_UNACCEPTABLE'));
                return false;
            }
        }
    };
</script>


