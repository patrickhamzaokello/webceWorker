<?php
class Appointments
{

	private $appointments = "appointments";

	public $id;
    public $userid;
	public $purpose;
    public $appointment_time;
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

		$stmt = $this->conn->prepare("INSERT INTO " . $this->appointments . "(`userid`,`purpose`, `appointment_date`,`appointment_time`) VALUES(?,?,?,?)");

		$this->userid = htmlspecialchars(strip_tags($this->userid));
		$this->purpose = htmlspecialchars(strip_tags($this->purpose));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
        $this->appointment_time = htmlspecialchars(strip_tags($this->appointment_time));


        $stmt->bind_param("isss", $this->userid, $this->purpose, $this->appointment_date, $this->appointment_time);

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
