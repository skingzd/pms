<?php
class BaseClass
{
    private $unaccessed = array();
    private $hidden = 1;

    public function __set($name,$value)
    {
        echo "Setting {$name}={$value}.<br />";
        $this->unaccessed[$name]=$value;
    }

    public function __get($name)
    {
        echo "Getting {$name}.<br />";
        if(array_key_exists($name, $this->unaccessed)){
            return $this->unaccessed[$name];
        }

        $trace = debug_backtrace();
        trigger_error("Can't find the property: ".$name." of Class:".__CLASS__.".<br />");
        return null;
    }

    public function __isset($name)
    {
        return isset($this->unaccessed[$name]);
    }

    public function __unset($name)
    {
        echo "Unsetting The property : {$name}.<br />";
        unset($this->unaccessed[$name]);
    }

    public function __call($name,$argument){
        echo "Calling the undefined {$name}(".
        implode(",", $argument).")";
    }

    public function listAllUnaccessed(){
        var_dump($this->unaccessed);
    }
}

$fl = new BaseClass;
$fl->show("all",12,33,2,1);
?>