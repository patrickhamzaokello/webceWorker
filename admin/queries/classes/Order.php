<?php


class Order
{

    private $con;
    private $order_id;
    private $order_address;
    private $customer_id;
    private $order_date;
    private $total_amount;
    private $order_status;
    private $processed_by;
    private $TABLE_NAME = "tblorder";
 


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->order_id = $id;

        $query = mysqli_query($this->con, "SELECT `order_id`, `order_address`, `customer_id`, `order_date`, `total_amount`, `order_status`, `processed_by` FROM ". $this->TABLE_NAME ." WHERE order_id ='$this->order_id'");
        $order_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->order_id = null;
            $this->order_address = null;
            $this->customer_id = null;
            $this->order_date = null;
            $this->total_amount = null;
            $this->order_status = null;
            $this->processed_by = null;
        } else {

            $this->order_id = $order_fetched['order_id'];
            $this->order_address = $order_fetched['order_address'];
            $this->customer_id = $order_fetched['customer_id'];
            $this->order_date = $order_fetched['order_date'];
            $this->total_amount = $order_fetched['total_amount'];
            $this->order_status = $order_fetched['order_status'];
            $this->processed_by = $order_fetched['processed_by'];
        }
    }



    /**
     * Get the value of order_id
     */ 
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Get the value of order_address
     */ 
    public function getOrder_address()
    {
        return explode("-",$this->order_address);
    }

    /**
     * Get the value of customer_id
     */ 
    public function getCustomer_id()
    {
        return $this->customer_id;
    }

    /**
     * Get the value of order_date
     */ 
    public function getOrder_date()
    {
        $phpdate = strtotime($this->order_date);
        $mysqldate = date('d M Y h:i A', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    /**
     * Get the value of total_amount
     */ 
    public function getTotal_amount()
    {
        return $this->total_amount;
    }

    /**
     * Get the value of order_status
     */ 
    public function getOrder_status()
    {
        $orderstatus = '';

        if( $this->order_status == 1){
            $orderstatus = "New";
        } else if($this->order_status == 2) {
            $orderstatus = "Preparing";
        }else if($this->order_status == 3) {
            $orderstatus = "Delivered";
        }

        return $orderstatus;
    }

    public function getOrder_statusID() {
        return $this->order_status;
    }

    /**
     * Get the value of processed_by
     */ 
    public function getProcessed_by()
    {

        $proccessor = '';

        if( $this->processed_by == 1){
            $proccessor = "Mobile";
        } else {
            $proccessor = "Web";
        }

        return $proccessor;
       
    }
}
