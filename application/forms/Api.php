<?php

class Application_Form_Api extends Zend_Form {

    public function init() {
        $this->setMethod('get');

        $this->addElement('text', 'input', array(
            'label' => 'Input:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')
        ));


        $this->addElement('submit', 'search', array(
            'ignore' => true,
            'label' => 'search'
        ));
    }
    

}
