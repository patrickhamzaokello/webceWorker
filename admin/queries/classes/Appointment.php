<?php

class Appointment
{
    private $con;
    private $id;
    private $userid;
    private $name;
    private $email;
    private $phone;
    private $purpose;
    private $appointment_date;
    private $status;
    private $date_created;
    private $date_updated;

    private $TABLE_NAME = "appointments";

    /**
     * @param $con
     * @param $id
     */
    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;


        $query = mysqli_query($this->con, " SELECT `id`, `userid`, `name`, `email`, `phone`, `purpose`, `appointment_date`, `status`, `date-created`, `date-updated` FROM ".$this->TABLE_NAME." WHERE id = $this->id ");
        $appointment_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->userid = null;
            $this->name = null;
            $this->email = null;
            $this->phone = null;
            $this->purpose = null;
            $this->appointment_date = null;
            $this->status = null;
            $this->date_created = null;
            $this->date_updated = null;
        } else {

            $this->id = $appointment_fetched['id'];
            $this->userid = $appointment_fetched['userid'];
            $this->name = $appointment_fetched['name'];
            $this->email = $appointment_fetched['email'];
            $this->phone = $appointment_fetched['phone'];
            $this->purpose = $appointment_fetched['purpose'];
            $this->appointment_date = $appointment_fetched['appointment_date'];
            $this->status = $appointment_fetched['status'];
            $this->date_created = $appointment_fetched['date-created'];
            $this->date_updated = $appointment_fetched['date-updated'];

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed|null
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @return mixed|null
     */
    public function getAppointmentDate()
    {
        return $this->appointment_date;
    }

    /**
     * @return mixed|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed|null
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @return mixed|null
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }




}