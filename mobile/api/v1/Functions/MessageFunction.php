<?php
class MessageFunction
{
    private $order_table = "messages";
    private $exe_status;
    // order private
    private $userID;

    private $id;
    private $userid;
    private $message;
    private $created_date;

    private $conn;


    public function __construct($con)
    {
        $this->conn = $con;
        $this->exe_status = "failure";
    }


    function readFeedbacks()
    {


        $itemRecords = array();

        $this->userID = htmlspecialchars(strip_tags($_GET["userID"]));
        $this->userOrderPage = htmlspecialchars(strip_tags($_GET["page"]));

        if (htmlspecialchars(strip_tags($_GET["userID"])) != null) {
            $this->pageno = floatval($this->userOrderPage);
            $no_of_records_per_page = 20;
            $offset = ($this->pageno - 1) * $no_of_records_per_page;


            $sql = "SELECT COUNT(*) as count FROM " . $this->order_table . " WHERE userid = " . $this->userID . " limit 1";
            $result = mysqli_query($this->conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $total_rows = floatval($data['count']);
            $total_pages = ceil($total_rows / $no_of_records_per_page);


            $itemRecords["page"] = $this->pageno;
            $itemRecords["Message"] = array();
            $itemRecords["total_pages"] = $total_pages;
            $itemRecords["total_results"] = $total_rows;


            $stmt = $this->conn->prepare("SELECT `id`, `userid`, `message`, `created_date` FROM " . $this->order_table . " WHERE userid = " . $this->userID . " ORDER BY id DESC  LIMIT " . $offset . "," . $no_of_records_per_page);


            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($this->id, $this->userid, $this->message, $this->created_date);

            $numberofrows = $stmt->num_rows;

            if ($numberofrows > 0) {
                while ($stmt->fetch()) {

                    $temp = array();

                    $phpdate = strtotime($this->created_date);
                    $mysqldate = date('d M Y h:i A', $phpdate);

                    $temp['id'] = $this->id;
                    $temp['userid'] = $this->userid;
                    $temp['message'] = $this->message;
                    $temp['created_date'] = $mysqldate;

                    array_push($itemRecords["Message"], $temp);
                }
            } else {
                $temp = array();

                $temp['id'] = null;
                $temp['userid'] = null;
                $temp['message'] = null;
                $temp['created_date'] = null;

                array_push($itemRecords["Message"], $temp);
            }

        }

        return $itemRecords;
    }

}