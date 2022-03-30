<?php
class Appointments
{

	private $appointments = "appointments";

	public $id;
    public $userid;
    public $name;
    public $email;
    public $phone;
	public $purpose;
	public $appointment_date;
    public $status;
	public $datecreated;
	public $dateupdated;

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

		$stmt = $this->conn->prepare("INSERT INTO " . $this->appointments . "(`userid`, `name`, `email`, `phone`, `purpose`, `appointment_date`) VALUES(?,?,?,?,?,?)");

		$this->userid = htmlspecialchars(strip_tags($this->userid));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->phone = htmlspecialchars(strip_tags($this->phone));
		$this->purpose = htmlspecialchars(strip_tags($this->purpose));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));


        $stmt->bind_param("isssss", $this->userid, $this->name, $this->email, $this->phone, $this->purpose, $this->appointment_date);

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


	function readUserOrders()
	{



		$itemRecords = array();

		$this->userOrderid = htmlspecialchars(strip_tags($_GET["customerId"]));
		$this->userOrderPage = htmlspecialchars(strip_tags($_GET["page"]));

		// echo "working". $this->userOrderid .$this->userOrderPage;


		if ($this->userOrderid) {
			$this->pageno = floatval($this->userOrderPage);
			$no_of_records_per_page = 10;
			$offset = ($this->pageno - 1) * $no_of_records_per_page;


			$sql = "SELECT COUNT(*) as count FROM " . $this->cases . " WHERE customer_id = " . $this->userOrderid . " limit 1";
			$result = mysqli_query($this->conn, $sql);
			$data = mysqli_fetch_assoc($result);
			$total_rows = floatval($data['count']);
			$total_pages = ceil($total_rows / $no_of_records_per_page);


			$itemRecords["page"] = $this->pageno;
			$itemRecords["results"] = array();
			$itemRecords["total_pages"] = $total_pages;
			$itemRecords["total_results"] = $total_rows;


			$stmt = $this->conn->prepare("SELECT `order_id`, `order_address`, `customer_id`, `order_date`, `total_amount`, `order_status`, `processed_by` FROM " . $this->cases . " WHERE customer_id = " . $this->userOrderid . " ORDER BY order_id DESC  LIMIT " . $offset . "," . $no_of_records_per_page);
		} else {
			// echo "working b";
			$stmt = $this->conn->prepare("SELECT `order_id`, `order_address`, `customer_id`, `order_date`, `total_amount`, `order_status`, `processed_by` FROM " . $this->cases." ORDER BY order_id DESC" );
		}


		$stmt->execute();
		$stmt -> store_result();
		$stmt->bind_result($this->order_id, $this->order_address, $this->customer_id, $this->order_date, $this->total_amount, $this->order_status, $this->processed_by);

		$numberofrows = $stmt->num_rows;

		if($numberofrows > 0){
			while ($stmt->fetch()) {

				$temp = array();
	
				$temp['order_id'] = $this->order_id;
				$temp['order_address'] = $this->order_address;
				$temp['customer_id'] = $this->customer_id;
				$temp['order_date'] = $this->order_date;
				$temp['total_amount'] = $this->total_amount;
				$temp['order_status'] = $this->order_status;
				$temp['processed_by'] = $this->processed_by;
	
				array_push($itemRecords["results"], $temp);
			}
		} else {
			$temp = array();
	
				$temp['order_id'] = 0;
				$temp['order_address'] = "null";
				$temp['customer_id'] = 0;
				$temp['order_date'] = "null";
				$temp['total_amount'] = 0;
				$temp['order_status'] = 0;
				$temp['processed_by'] = 0;
	
				array_push($itemRecords["results"], $temp);
		}


		


		return $itemRecords;
	}


}
