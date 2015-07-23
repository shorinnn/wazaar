<?php
use LaravelBook\Ardent\Ardent;

abstract class CocoriumArdent extends Ardent {
    protected $transientSet = [];
    
    public function setTransient($name, $val){
        $this->$name = $this->attributes[$name] = $val;
        $this->transientSet[$name] = $name;
    }
    
    public function clearTransient(){
        if( count( $this->transientSet) > 0){
            foreach($this->transientSet as $attr){
                if( isset( $this->attributes[$attr] ) ){
                    $this->$attr = $this->attributes[$attr];
                    unset( $this->attributes[$attr] );
                }
            }
        }
    }
    
    
    /**
     * SORIN: Extended this to make it work with unique_with https://github.com/felixkiss/uniquewith-validator
     * @param int   $id
     * @param array $rules
     *
     * @return array Rules with exclusions applied
     */
    protected function buildUniqueExclusionRules(array $rules = array()) {
      
        if (!count($rules))
          $rules = static::$rules;

        foreach ($rules as $field => &$ruleset) {
            // If $ruleset is a pipe-separated string, switch it to array
            $ruleset = (is_string($ruleset))? explode('|', $ruleset) : $ruleset;

            foreach ($ruleset as &$rule) {
              if (strpos($rule, 'unique_with') === 0) {
                $params = explode(',', $rule);

                $uniqueRules = array();
                
                // Append table name if needed
                $table = explode(':', $params[0]);
                if (count($table) == 1)
                  $uniqueRules[1] = $this->table;
                else
                  $uniqueRules[1] = $table[1];
               
                // Append field name if needed
                if (count($params) == 1)
                  $uniqueRules[2] = $field;
                else
                  $uniqueRules[2] = $params[1];

                if (isset($this->primaryKey)) {
                  $uniqueRules[3] = $this->{$this->primaryKey};
                  $uniqueRules[4] = $this->primaryKey;
                }
                else {
                  $uniqueRules[3] = $this->id;
                }
                if( isset($uniqueRules[4]) ){
                    $pk_field = array_pop($uniqueRules);
                }
                $rule = 'unique_with:' . implode(',', $uniqueRules) .' = '.  $pk_field;  
                
              } // end if strpos unique_with
              else if (strpos($rule, 'unique') === 0) {
                $params = explode(',', $rule);

                $uniqueRules = array();
                
                // Append table name if needed
                $table = explode(':', $params[0]);
                if (count($table) == 1)
                  $uniqueRules[1] = $this->table;
                else
                  $uniqueRules[1] = $table[1];
               
                // Append field name if needed
                if (count($params) == 1)
                  $uniqueRules[2] = $field;
                else
                  $uniqueRules[2] = $params[1];

                if (isset($this->primaryKey)) {
                  $uniqueRules[3] = $this->{$this->primaryKey};
                  $uniqueRules[4] = $this->primaryKey;
                }
                else {
                  $uniqueRules[3] = $this->id;
                }
       
                $rule = 'unique:' . implode(',', $uniqueRules);  
              } // end if strpos unique
              else{}
              
            } // end foreach ruleset
        }
        
        return $rules;
    }
    
    public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    {
        $model = new $related;
        $table = $model->getTable();
        $throughModel = new $through;
        $pivot = $throughModel->getTable();

        return $model
            ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
            ->select($table . '.*')
            ->where($pivot . '.' . $firstKey, '=', $this->id);
    }
    
}