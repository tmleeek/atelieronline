<?php

class TM_FireCheckout_Block_Adminhtml_Form_Field_Date extends TM_FireCheckout_Block_Adminhtml_Form_Field_Multirow
{
    protected function _toHtml()
    {
        if (!$this->_beforeToHtml()) {
            return '';
        }

        $html = '<select name="' . $this->getName() . '[]" style="width: 90px;">';
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html .= $this->_optionToHtml(array(
                'value' => $month,
                'label' => Mage::app()->getLocale()
                    ->date(mktime(0, 0, 0, $i, 10)) // http://php.net/manual/ru/function.mktime.php#80759
                    ->get(Zend_Date::MONTH_NAME),
                'salt'  => 'month'
            ));
        }
        $html .= '</select>';

        $html .= '&nbsp;<select name="' . $this->getName() . '[]" style="width: 50px;">';
        for ($i = 1; $i <= 31; $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html .= $this->_optionToHtml(array(
                'value' => $day,
                'label' => $day,
                'salt'  => 'day'
            ));
        }
        $html .= '</select>';

        $html .= '&nbsp;<select name="' . $this->getName() . '[]" style="width: 80px;">';
        $html .= $this->_optionToHtml(array(
            'value' => 2, // dirty fix for the XXI century. See the delivery date disableFunc function in delivery_date.phtml ~line35: date.indexOf(exculdedDates[i])
            'label' => Mage::helper('sitemap')->__('Yearly'),
            'salt'  => 'year'
        ));
        $currentYear = Mage::app()->getLocale()->date()->get(Zend_Date::YEAR);
        for ($i = $currentYear, $limit = $i + 3; $i <= $limit; $i++) {
            $html .= $this->_optionToHtml(array(
                'value' => $i,
                'label' => $i,
                'salt'  => 'year'
            ));
        }
        $html .= '</select>';

        $column = $this->getColumn();
        $html = '<div style="' . $column['style'] . '">' . $html . '</div>';
        return $html;
    }
}
