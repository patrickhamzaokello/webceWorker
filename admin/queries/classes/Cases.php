<?php


class Cases
{

    private $con;
    private $id;
    private $name;
    private $picture;
    private $title;
    private $description;
    private $location;
    private $longitude;
    private $latitude;
    private $category_id;
    private $reportedby_id;
    private $datecreated;
    private $dateupdated;
    private $status;
    private $TABLE_NAME = "cases";
 


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT `id`, `name`, `picture`,`title`, `description`, `location`, `longitude`, `latitude`, `category_id`, `reportedby_id`, `datecreated`, `dateupdated`, `status` FROM ".$this->TABLE_NAME." WHERE id = $this->id ");
        $case_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->name = null;
            $this->picture = null;
            $this->title = null;
            $this->description = null;
            $this->location = null;
            $this->longitude = null;
            $this->latitude = null;
            $this->category_id = null;
            $this->reportedby_id = null;
            $this->datecreated = null;
            $this->dateupdated = null;
            $this->status = null;
        } else {

            $this->id = $case_fetched['id'];
            $this->name = $case_fetched['name'];
            $this->picture = $case_fetched['picture'];
            $this->title = $case_fetched['title'];
            $this->description = $case_fetched['description'];
            $this->location = $case_fetched['location'];
            $this->longitude = $case_fetched['longitude'];
            $this->latitude = $case_fetched['latitude'];
            $this->category_id = $case_fetched['category_id'];
            $this->reportedby_id = $case_fetched['reportedby_id'];
            $this->datecreated = $case_fetched['datecreated'];
            $this->dateupdated = $case_fetched['dateupdated'];
            $this->status = $case_fetched['status'];

        }
    }


    public function getId()
    {
        return $this->id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getPicture()
    {
        return $this->picture;
    }

    
    public function getTitle()
    {
        return $this->title;
    }



    public function getDescription()
    {
        return $this->description;
    }


    public function getLocation()
    {
        return $this->location;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }


    public function getLatitude()
    {
        return $this->latitude;
    }


    public function getCategoryId()
    {
        return $this->category_id;
    }


    public function getReportedbyId()
    {
        return $this->reportedby_id;
    }

    public function getReportedbyUser(){
        $re_user = new User($this->con, $this->getReportedbyId());
        return $re_user->getFullName();
    }

    public function getDatecreated()
    {

        $phpdate = strtotime($this->datecreated);
        $mysqldate = date('d M Y h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }


    public function getDateupdated()
    {
        $phpdate = strtotime($this->dateupdated);
        $mysqldate = date('d M Y h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }


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

    public  function getStatusID(){
        return $this->status;
    }




}
