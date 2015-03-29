<?php namespace App\Models\Utils;

class Map {

    /**
     * @return mixed
     */
    private function getEndOfUrl(){
        return Route::input('json');
    }

    /**
     * @return bool|string
     */
    public function getJsonFileName(  ){

        $url = $this->getEndOfUrl();

        if( $url )
            return $url.'.json';
        else
            return false;
    }

    /**
     * @param $name
     * @return array
     */
    public function getError( $name ){

        $obj = array( 'code'=>'0xFF', 'error'=>'Unexpected Error! No suggestions' );

        switch( $name ){

            case 'json-missed' : { $obj['code'] = '0x01';
                $obj['error'] = 'Required json file is not located in a file system';
                break; }

            case 'json-not-v' : {  $obj['code'] = '0x02';
                $obj['error'] = 'Json file is not valid.';
                break; }

            case 'table-missed' : { $obj['code'] = '0x03';
                $obj['error'] = 'No such table found.';
                break; }

            case 'columns-mismatch' : { $obj['code'] = '0x04';
                $obj['error'] = 'Table columns not match to any of given.';
                break; }

            case 'model-not-found' : { $obj['code'] = '0x05';
                $obj['error'] = 'Model not created or misspelled.';
                break; }
        }

        return $obj;
    }

    /**
     * @param $target
     * @param $source
     * @return int
     */
    public function getArrayDiff( $target, $source ){

        $diff = 0;

        for( $i = 0,$total = count($target); $i<$total; $i++ ){
            if( in_array( $target[$i]->name, $source ) )
                $diff++;
        }

        if( $diff == $total )
            return $diff;
        else
            return 0;
    }

    /**
     * @param $target
     * @param string $pattern
     * @return bool|string
     */
    private function toCamelCase( $target, $pattern = '-'){

        $result = explode( $pattern, $target ); $target = '';

        foreach( $result as $key=>$value ){
            $target .= ucfirst($value);
        }
        return $target;
    }

    /**
     * @param $obj
     * @param $staff
     * @return mixed
     */
    public function getJoin( $obj, $staff ){
        return $obj->join($staff[0],$staff[1],'=',$staff[2]);
    }

    /**
     * @param $obj
     * @return array|bool
     */
    public function getDependies( $obj, $model ){

        $getAs = array($obj->relatedTable.'.*');

        foreach( $obj->inputs as $key=>$val ){
            if( isset( $val->table ) && isset( $val->value ) ) {
                $b = 'joined_'.$key;
                $getAs[] = $val->table.'.'.$val->value->fields[0].' as '.$b;
                $val->value = $b;
                $model = $this->getJoin( $model, array( $val->table, $obj->relatedTable.'.'.$val->name, $val->table.'.'.$val->name ) );
            }
        }

        return [$model,$getAs];
    }

    /**
     * @return bool
     */
    public function getModel( $str = null ){

        if( !$str ) {
            $str = $this->getEndOfUrl();
        }

        $model = false;
        $class = 'App\\Models\\'.$this->toCamelCase( $str );

        if( class_exists($class) )
            $model = new $class();

        return $model;
    }


}
