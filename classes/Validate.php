<?php
class Validate {

    private $_passed = false,
            $_errors = array(),
            $_db = null;

    // make instance of DB, it's required to contact with DB
    public function __construct() {
        $this->_db = DB::getInstance();
    }

    // source - inserted data (like username, password), items - conditions/rules to check the source
    public function check($source, $items = array()) {

        // list rules we defined to check, cause each rule is an array ( item = 'name', rules = array() )
        foreach ($items as $item => $rules) {

            // list of values of rules we set, example rule = 'required', rule_value = 'true'
            foreach ($rules as $rule => $rule_value) {
                // example of two foreach's
                //echo "{$item} {$rule} must be {$rule_value}<br>";

                // trim value if have spaces
                $value = trim($source[$item]);
                $item = escape($item);

                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } elseif(!empty($value)){

                    // after made sure that data inserted, check each rule is performed
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));

                            // if count is possible so username already exists in DB
                            if ($check->count()) {
                                $this->addError("{$item} already exists.");
                            }
                            break;
                    }
                }
            }
        }

        // if no errors (all fields are good) change passed to true
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    // collect errors to on errors array
    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public  function passed() {
        return $this->_passed;
    }


}