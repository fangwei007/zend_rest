<?php

class Application_Form_Register extends Zend_Form {

    public function init() {
        $this->setMethod('post');
//        $this->setAction('success');

        $this->addElement('text', 'Email', array(
            'label' => 'Email:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress')
        ));
        

        $this->addElement('password', 'Password', array(
            'label' => 'Password:',
            'required' => true
        ));
        
         $this->addElement('password', 'pwd_conf', array(
            'label' => 'Password confirm:',
            'required' => true
        ));

        $this->addElement('submit', 'signup', array(
            'ignore' => true,
            'label' => 'Signup'
        ));
    }

}
