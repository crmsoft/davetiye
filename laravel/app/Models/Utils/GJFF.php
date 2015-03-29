<?php namespace App\Models\Utils;


class GJFF {

    private $fileName = '';
    private $path = '';

    /**
     * @param $input
     * @param string $path
     * @return bool
     */
    public function init( $input, $path = '/assets/custom-els/form-layout/' ){

        $ext = explode( '.', $input );
        $this->path = public_path() . $path;

        if( end($ext) == 'json' ){
            $this->fileName = $input;
            if( File::exists( $this->path . $this->fileName ) ){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getContent(){

        try{
            $cnt = json_decode( File::get( $this->path . $this->fileName ) );
        }catch (FileNotFoundException $e){
            return false;
        }

        if( !isset($cnt->relatedTable) )
            return false;

        if (isset($cnt->inputs)){
            if(!count($cnt->inputs) > 0)
                return false;
        }else {
            return false;
        }

        return $cnt;
    }

}
