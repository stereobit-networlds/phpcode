<?php
//https://soyuka.me/streaming-big-json-files-the-good-way/

/*
~/soyuka.me/streaming-big-json-files-the-good-way/ Jan 5, 2015
Streaming big json files the good way with php

Json is now really popular to share data between components. I’m working on an small EAI (Enterprise Application Integration). It’s basic purpose is to transform and integrate data from an application to another. Original data is transformed to JSON from an SQL instance, parsed by the EAI and backed up in another database with transformations and tests.

The problem

This seems really simple on the first look, but when you work with big files, you can not simply json_decode a file and put it back where you need too. It could work with small files, which sizes aren’t bigger than you’re computer memory. With big files, it’ll eat up memory and might break the server, or worse eat up ressources that other applications might need.

If we want something that’ll work with any files we need to find another way of doing this named “stream”.

A problem within the problem

Streaming a file is easy but it’s json not csv. Take this json sample, this is usually how data will be transformed:

*/

$testfile = __DIR__.'/example.json'; //https://gist.github.com/soyuka/a1d83ff9ff1a6c5cc269

$listener = new ObjectListener(function($obj) {
    var_dump($obj);
});

$stream = fopen($testfile, 'r');
try {
    $parser = new JsonStreamingParser_Parser($stream, $listener);
    $parser->parse();
} catch (Exception $e) {
    fclose($stream);
    throw $e;
}



interface JsonStreamingParser_Listener {
  public function file_position($line, $char);
  //this is called when the document starts
  public function start_document();
  
  //this is called on EOF
  public function end_document();

  //the start/end of an object
  public function start_object();
  public function end_object();
  
  //the start/end of an array
  public function start_array();
  public function end_array();
  
  // Called when a key is found
  public function key($key);
  
  // There it's a value
  public function value($value);
  
  public function whitespace($whitespace);
}


class ArrayMaker implements JsonStreamingParser_Listener {
  private $_json;

  private $_stack;
  private $_key;

  public function get_json() {
    return $this->_json;
  }

  public function start_document() {
    $this->_stack = array();

    $this->_key = null;
  }

  public function start_object() {
    array_push($this->_stack, array());
  }

  public function end_object() {
    $obj = array_pop($this->_stack);
    if (empty($this->_stack)) {
      // doc is DONE!
      $this->_json = $obj;
    } else {
      $this->value($obj);
    }
  }

  public function start_array() {
    $this->start_object();
  }

  public function end_array() {
    $this->end_object();
  }

  // Key will always be a string
  public function key($key) {
    $this->_key = $key;
  }

  // Note that value may be a string, integer, boolean, null
  public function value($value) {
    $obj = array_pop($this->_stack);
    if ($this->_key) {
      $obj[$this->_key] = $value;
      $this->_key = null;
    } else {
      array_push($obj, $value);
    }
    array_push($this->_stack, $obj);
  }

}


require_once './vendor/autoload.php';

/**
 * This implementation allows to process an object at a specific level
 * when it has been fully parsed
 */
class ObjectListener implements JsonStreamingParser_Listener {

    /** @var string Current key **/
    private $_key;

    /** @var int Array deep level **/
    private $array_level = 0;
    /** @var int Object deep level **/
    private $object_level = 0;

    /** @var array Pointer that aliases the current array that represents an object or an array **/
    private $pointer;

    /**
     * @var array $array_pointers Stores different array pointers 
     * according to the deep level
     * @var array $object_pointers Stores different objects pointers 
     * according to the deep level
     * Those are used to track pointers, it's easy to go forward 
     * or backwards by using this as they are only references.
     */
    private $array_pointers, $object_pointers;

    /** @var array Main array that stores the current building object **/
    private $stack = array();

    /**
     * @param function $callback the function called when a json 
     * object has been fully parsed
     *
     * @throws InvalidArgumentException if callback isn't callable
     *
     * @return void
     */
    public function __construct($callback)
    {

        if(!is_callable($callback)) {
            throw new \InvalidArgumentException("Callback should be a callable function");
        }

        $this->callback = $callback;
    }

    public function file_position($line, $char) {
    }

    /**
     * Document start
     * Init every variables and place the pointer on the stack
     *
     * @return void
     */
    public function start_document() {

        $this->stack = array();
        $this->array_pointers = array();
        $this->array_level = 0;
        $this->object_level = 0;
        $this->object_pointers = array();
        $this->keys = array();
        $this->_key = null;

        $this->pointer =& $this->stack;
    }

    /**
     * Document end (EOF)
     *
     * @return void
     */
    public function end_document() {
        // release memory
        $this->start_document();
    }

    /**
     * Start object
     * An object began...
     *
     * @return void
     */
    public function start_object() {
        //Increase the object level
        $this->object_level++;

        //Point on the current array
        $this->pointer =& $this->array_pointers[$this->array_level];

        //Get the current index
        $array_index = isset($this->pointer) ? count($this->pointer) : 0;

        //Build an array on this index
        $this->pointer[$array_index] = array();

        //Pointer is now this new array
        $this->pointer =& $this->pointer[$array_index];

        //Store it
        $this->object_pointers[$this->object_level] =& $this->pointer;
    }

    /**
     * End Object
     * An object ended
     *
     * @return void
     */
    public function end_object() {

        $this->pointer =& $this->array_pointers[$this->array_level];
        
        //We've reach a full object on my root array, callback
        if($this->array_level == 1 && $this->object_level == 1) {
            call_user_func($this->callback, $this->stack);
            array_shift($this->stack[0]); //release this item from memory
        } 

        $this->object_level--;
    }

    /** 
     * Start array
     * An array began...
     *
     * @return void
     */
    public function start_array() {
        $this->array_level++;

        //If we have a key it's our index
        if($this->_key) {
            $index = $this->_key;
            $this->_key = null;
        } else {
            $index = isset($this->pointer) ? count($this->pointer) : 0;
        }

        //This is our array, point on it
        $this->pointer[$index] = array();
        $this->pointer =& $this->pointer[$index];

        //Store the pointer
        $this->array_pointers[$this->array_level] =& $this->pointer;

    }

    /**
     * End array
     *
     * Now it ended...
     * @todo, according to both levels, point to the nearest one array 
     * or object
     * @return void
     */
    public function end_array() {
        //Point on the last known object 
        $this->pointer =& $this->object_pointers[$this->object_level];
        $this->array_level--;
    }

    /**
     * Called when a key is founded
     * @param string $key
     * @return void
     */
    public function key($key) {
        $this->_key = $key;
    }

    /**
     * Called when a value is founded
     * @param mixed $value may be a string, integer, boolean, null
     * @return void
     */
    public function value($value) {

        if($this->_key) {
            $this->pointer[$this->_key] = $value;
        } else {
            $this->pointer[] = $value;
        }
    }

    public function whitespace($whitespace) {
    }
}




?>