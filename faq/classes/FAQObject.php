<?php
/**
 * FAQObject class
 *
 */

class FAQObject extends ElggObject {

  protected function initializeAttributes() {

    parent::initializeAttributes();

    $this->attributes['subtype'] = "faq";
  }

  public function __construct($guid = null) {

    parent::__construct($guid);
  }
}
