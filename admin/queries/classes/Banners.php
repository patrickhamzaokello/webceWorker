<?php 

class Banners {

    private $con;
    private $id;
    private $name;
    private $imageUrl;
    private $category_id;
    private $status;
    private $display_order;
    private $datecreated;
    private $datemodified;
    private $TABLE_NAME = "tblbanner";
 


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT `id`, `name`, `imageUrl`,`category_id`, `status`, `display_order`, `datecreated`, `datemodified` FROM ". $this->TABLE_NAME ." WHERE id ='$this->id'");
        $order_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->name = null;
            $this->imageUrl = null;
            $this->category_id = null;
            $this->status = null;
            $this->display_order = null;
            $this->datecreated = null;
            $this->datemodified = null;
        } else {

            $this->id = $order_fetched['id'];
            $this->name = $order_fetched['name'];
            $this->imageUrl = $order_fetched['imageUrl'];
            $this->category_id = $order_fetched['category_id'];
            $this->status = $order_fetched['status'];
            $this->display_order = $order_fetched['display_order'];
            $this->datecreated = $order_fetched['datecreated'];
            $this->datemodified = $order_fetched['datemodified'];
        }
    }
    


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of imageUrl
     */ 
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

       /**
     * Get the value of category_id
     */ 
    public function getCategory_id()
    {
        $category_name = new MenuType($this->con, $this->category_id);
        return $category_name->getName();
    }


    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of display_order
     */ 
    public function getDisplay_order()
    {
        return $this->display_order;
    }

    /**
     * Get the value of datecreated
     */ 
    public function getDatecreated()
    {
        $phpdate = strtotime($this->datecreated);
        $mysqldate = date('d M Y h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    /**
     * Get the value of datemodified
     */ 
    public function getDatemodified()
    {

        $phpdate = strtotime($this->datemodified);
        $mysqldate = date('d M Y h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}

?>