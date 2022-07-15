<?php
class Appointments
{

	private $appointments = "appointments";

	public $id;
    public $userid;
	public $purpose;
	public $appointment_date;
    public $status;
	public $datecreated;

	// order private
    private $exe_status;

	private $conn;


	public function __construct($con)
	{
		$this->conn = $con;
		$this->exe_status = "failure";
	}

	function create()
	{

		$stmt = $this->conn->prepare("INSERT INTO " . $this->appointments . "(`userid`,`purpose`, `appointment_date`) VALUES(?,?,?)");

		$this->userid = htmlspecialchars(strip_tags($this->userid));
		$this->purpose = htmlspecialchars(strip_tags($this->purpose));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));


        $stmt->bind_param("iss", $this->userid, $this->purpose, $this->appointment_date);

		if ($stmt->execute()) {
			$this->exe_status = "success";
		} else {
			$this->exe_status = "failure";
		}


		if ($this->exe_status == "success") {
			return true;
		}

		return false;
	}





}
