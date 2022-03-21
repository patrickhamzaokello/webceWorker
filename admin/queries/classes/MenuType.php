<?php 

class MenuType {

    private $con;
    private $id;
    private $name;
    private $description;
    private $imageCover;
    private $created;
    private $modified;
    private $TABLE_NAME = "tblmenutype";
 


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT `id`, `name`, `description`, `imageCover`, `created`, `modified` FROM ". $this->TABLE_NAME ." WHERE id ='$this->id'");
        $order_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->name = null;
            $this->description = null;
            $this->imageCover = null;
            $this->created = null;
            $this->modified = null;
        } else {

            $this->id = $order_fetched['id'];
            $this->name = $order_fetched['name'];
            $this->description = $order_fetched['description'];
            $this->imageCover = $order_fetched['imageCover'];
            $this->created = $order_fetched['created'];
            $this->modified = $order_fetched['modified'];
        }
    }
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of imageCover
     */ 
    public function getImageCover()
    {
        return $this->imageCover;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated()
    {
        $phpdate = strtotime($this->created);
        $mysqldate = date('d M Y h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    /**
     * Get the value of modified
     */ 
    public function getModified()
    {
        $phpdate = strtotime($this->modified);
        $mysqldate = date('d M Y h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }
}

?>