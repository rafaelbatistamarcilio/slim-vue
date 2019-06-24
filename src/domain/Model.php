<?php namespace App;
abstract class Model {
   
   public function toArray() {
        return $this->processArray(get_object_vars($this));
    }
    
    private function processArray($array) {
        foreach($array as $key => $value) {
            if (is_object($value)) {
                $array[$key] = $value->toArray();
            }
            if (is_array($value)) {
                $array[$key] = $this->processArray($value);
            }
        }
        return $array;
    }
    
    public function json() {
        return json_encode($this->toArray());
    }
   
}
?>