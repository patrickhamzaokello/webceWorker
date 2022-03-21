<?php


class Menu
{

    private $con;
    private $menu_id;
    private $menu_name;
    private $price;
    private $description;
    private $menu_type_id;
    private $menu_image;
    private $backgroundImage;
    private $ingredients;   
    private $menu_status;   
    private $created;   
    private $modified;   
    private $rating;
    private $TABLE_NAME = "tblmenu";
 


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->menu_id = $id;

        $query = mysqli_query($this->con, "SELECT `menu_id`, `menu_name`, `price`, `description`, `menu_type_id`, `menu_image`, `backgroundImage`, `ingredients`, `menu_status`, `created`, `modified`, `rating` FROM ". $this->TABLE_NAME ." WHERE menu_id ='$this->menu_id'");
        $order_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->menu_id = null;
            $this->menu_name = null;
            $this->price = null;
            $this->description = null;
            $this->menu_type_id = null;
            $this->menu_image = null;
            $this->backgroundImage = null;
            $this->ingredients = null;
            $this->menu_status = null;
            $this->created = null;
            $this->modified = null;
            $this->rating = null;
        
        } else {

            $this->menu_id = $order_fetched['menu_id'];
            $this->menu_name = $order_fetched['menu_name'];
            $this->price = $order_fetched['price'];
            $this->description = $order_fetched['description'];
            $this->menu_type_id = $order_fetched['menu_type_id'];
            $this->menu_image = $order_fetched['menu_image'];
            $this->backgroundImage = $order_fetched['backgroundImage'];
            $this->ingredients = $order_fetched['ingredients'];
            $this->menu_status = $order_fetched['menu_status'];
            $this->created = $order_fetched['created'];
            $this->modified = $order_fetched['modified'];
            $this->rating = $order_fetched['rating'];
     
        }
    }




    /**
     * Get the value of menu_id
     */ 
    public function getMenu_id()
    {
        return $this->menu_id;
    }

    /**
     * Get the value of menu_name
     */ 
    public function getMenu_name()
    {
        return $this->menu_name;
    }

    /**
     * Get the value of menu_image
     */ 
    public function getMenu_image()
    {
        return $this->menu_image;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return number_format($this->price);
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of menu_type_id
     */ 
    public function getMenu_type_id()
    {

        $menutype = new MenuType($this->con,$this->menu_type_id);
        return $menutype->getName();

    }

    /**
     * Get the value of backgroundImage
     */ 
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * Get the value of ingredients
     */ 
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Get the value of menu_status
     */ 
    public function getMenu_status()
    {

        $status = "";
        if($this->menu_status == 2)
        {
            $status = "Online";
        } else {
            $status = "Offline";
        }
        return $status;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated()
    {
        $phpdate = strtotime($this->created);
        $mysqldate = date('d/n/y  h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    /**
     * Get the value of modified
     */ 
    public function getModified()
    {
        $phpdate = strtotime($this->modified);
        $mysqldate = date('d/n/y  h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    /**
     * Get the value of rating
     */ 
    public function getRating()
    {
        return $this->rating;
    }
}
