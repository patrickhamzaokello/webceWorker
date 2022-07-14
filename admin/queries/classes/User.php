<?php

class User
{
    private $con;
    private $TABLE_NAME = "users";
    private $id;
    private $full_name;
    private $username;
    private $phone_number;
    private $email;
    private $address;
    private $profile_image;
    private $customer_password;
    private $account_status;
    private $userRole;
    private $created;

    public function __construct($con,$id)
    {

        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT `user_id`, `full_name`, `username`, `email`, `phone_number`, `address`, `profile_image`, `password`, `account_status`, `userRole`, `created` FROM ".$this->TABLE_NAME." WHERE  user_id = $this->id ");
        $user_fetched = mysqli_fetch_array($query);

        if (mysqli_num_rows($query) < 1) {
            $this->id = null;
            $this->full_name = null;
            $this->username = null;
            $this->phone_number = null;
            $this->email = null;
            $this->address = null;
            $this->profile_image = null;
            $this->customer_password;
            $this->account_status = null;
            $this->userRole = null;
            $this->created = null;
        } else {

            $this->id = $user_fetched['user_id'];
            $this->full_name =  $user_fetched['full_name'];
            $this->username =  $user_fetched['username'];
            $this->phone_number =  $user_fetched['phone_number'];
            $this->email =  $user_fetched['email'];
            $this->address =  $user_fetched['address'];
            $this->profile_image =  $user_fetched['profile_image'];
            $this->customer_password =  $user_fetched['password'];
            $this->account_status =  $user_fetched['account_status'];
            $this->userRole =  $user_fetched['userRole'];
            $this->created =  $user_fetched['created'];

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
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @return mixed|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed|null
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed|null
     */
    public function getProfileImage()
    {
        return $this->profile_image;
    }

    /**
     * @return mixed
     */
    public function getCustomerPassword()
    {
        return $this->customer_password;
    }

    /**
     * @return mixed|null
     */
    public function getAccountStatus()
    {

        return $this->account_status;
    }

    /**
     * @return mixed|null
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @return mixed|null
     */
    public function getCreated()
    {
        return $this->created;
    }




}