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


        $query = mysqli_query($this->con, " SELECT `id`, `userid`, `purpose`, `appointment_date`, `status`, `date-created`, `date-updated` FROM ".$this->TABLE_NAME." WHERE id = $this->id ");
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
        $user = new User($this->con, $this->userid);
        $this->name = $user->getFullName();

        return $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getEmail()
    {
        $user = new User($this->con, $this->userid);
        $this->email = $user->getEmail();
        return $this->email;
    }

    /**
     * @return mixed|null
     */
    public function getPhone()
    {
        $format_phone = '';
        $user = new User($this->con, $this->userid);
        $this->phone = $user->getPhoneNumber();
        if( $this->phone[0] == 0){
            $format_phone = $this->phone;
        } elseif ($this->phone[0] != 0) {
            $format_phone = "0".$this->phone;
        }

        return $format_phone;


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

        $phpdate = strtotime($this->appointment_date);
        $mysqldate = date('d M Y ', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    /**
     * @return mixed|null
     */
    public function getStatus()
    {
        $case_status = '';

        if( $this->status == 1){
            $case_status = "New";
        } else if($this->status == 2) {
            $case_status = "Approved";
        }else if($this->status == 3) {
            $case_status = "Complete";
        }

        return $case_status;
    }

    public function getStatusId(){
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