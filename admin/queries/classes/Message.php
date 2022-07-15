<?php

class Message
{
    private $con;
    private $id;
    private $userid;
    private $message;
    private $created_date;

    private $TABLE_NAME = "messages";

    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, " SELECT `id`, `userid`, `message`, `created_date` FROM ".$this->TABLE_NAME." WHERE id = $this->id ");
        $message_fetched = mysqli_fetch_array($query);

        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->userid = null;
            $this->message = null;
            $this->created_date = null;

        } else {

            $this->id = $message_fetched['id'];
            $this->userid = $message_fetched['userid'];
            $this->message = $message_fetched['message'];
            $this->created_date = $message_fetched['created_date'];

        }

    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed|null
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @return mixed|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed|null
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }



}