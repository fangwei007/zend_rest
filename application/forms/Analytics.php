<?php

class Application_Form_Analytics extends Zend_Form {

    public function init() {
        $this->setMethod('post');

        $this->addElement('text', 'email', array(
            'label' => 'Email:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')
        ));

        $this->addElement('password', 'password', array(
            'label' => 'Password:',
            'required' => true
        ));


        $this->addElement('submit', 'search', array(
            'ignore' => true,
            'label' => 'search'
        ));
    }

}
