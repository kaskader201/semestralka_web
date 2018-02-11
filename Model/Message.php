<?php

//value object for Message
class Message
{
    const DANGER = 'danger';
    const INFO = 'info';
    const WARNING = 'warning';
    const SUCCESS = 'success';
    
    public $header;
    public $text;
    public $type;
    
    
    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }
    
    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param $header
     * @return Message
     */
    public function setHeader(string $header): Message
    {
        $this->header = $header;
        return $this;
    }
    
    /**
     * @param $text
     * @return Message
     */
    public function setText(string $text): Message
    {
        $this->text = $text;
        return $this;
    }
    
    /**
     * @param $type
     * @return Message
     */
    public function setType($type): Message
    {
        $this->type = $type;
        return $this;
    }
}