<?php


class OrderDetails
{

    private $con;
    private $order_details_id;
    private $order_id;
    private $menu_id;
    private $amount;
    private $no_of_serving;
    private $total_amount;
    private $TABLE_NAME = "tblorderdetails";
 


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->order_details_id = $id;

        $query = mysqli_query($this->con, "SELECT `order_details_id`, `order_id`, `menu_id`, `amount`, `no_of_serving`, `total_amount` FROM ". $this->TABLE_NAME ." WHERE order_details_id ='$this->order_details_id'");
        $order_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->order_details_id = null;
            $this->order_id = null;
            $this->menu_id = null;
            $this->amount = null;
            $this->no_of_serving = null;
            $this->total_amount = null;
        } else {

            $this->order_details_id = $order_fetched['order_details_id'];
            $this->order_id = $order_fetched['order_id'];
            $this->menu_id = $order_fetched['menu_id'];
            $this->amount = $order_fetched['amount'];
            $this->no_of_serving = $order_fetched['no_of_serving'];
            $this->total_amount = $order_fetched['total_amount'];
        }
    }




    /**
     * Get the value of order_details_id
     */ 
    public function getOrder_details_id()
    {
        return $this->order_details_id;
    }

    /**
     * Get the value of order_id
     */ 
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Get the value of menu_id
     */ 
    public function getMenu_id()
    {
        return $this->menu_id;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return number_format($this->amount);
    }

    /**
     * Get the value of no_of_serving
     */ 
    public function getNo_of_serving()
    {
        return $this->no_of_serving;
    }

    /**
     * Get the value of total_amount
     */ 
    public function getTotal_amount()
    {
        return number_format($this->total_amount);
    }


    public function getMenuName(){
        $name = new Menu($this->con, $this->menu_id);
        return $name->getMenu_name();
    }

    public function getMenuImage(){
        $name = new Menu($this->con, $this->menu_id);
        return $name->getMenu_image();
    }

    
}
