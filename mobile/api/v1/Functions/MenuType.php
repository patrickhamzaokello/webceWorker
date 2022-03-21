<?php
class MenuType
{

	private $itemsTable = "tblmenutype";
	private $ImageBasepath = "https://zodongofoods.com/admin/pages/";
	public $id;
	public $name;
	public $description;
	public $imageCover;
	public $created;
	public $modified;
	private $conn;



	public function __construct($con)
	{
		$this->conn = $con;
	}

	function read()
	{
		$categoryids = array();
		$itemRecords = array();


		if ($this->id) {
			$stmt = $this->conn->prepare("SELECT id,name,description,imageCover,created, modified FROM " . $this->itemsTable . " WHERE id = ?");
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$stmt->bind_result($this->id, $this->name, $this->description, $this->imageCover, $this->created, $this->modified);


			while ($stmt->fetch()) {

				$temp = array();

				$temp['id'] = $this->id;
				$temp['name'] = $this->name;
				$temp['description'] = $this->description;
				$temp['imageCover'] = $this->imageCover;
				$temp['created'] = $this->created;
				$temp['modified'] = $this->modified;

				array_push($itemRecords, $temp);
			}
		} else {


			$category_stmt = "SELECT DISTINCT(menu_type_id) FROM tblmenu ";
			$menu_type_id_result = mysqli_query($this->conn, $category_stmt);

			while ($row = mysqli_fetch_array($menu_type_id_result)) {

				array_push($categoryids, $row);
			}

			foreach ($categoryids as $row) {
				$menu = new MenuTypeClass($this->conn, intval($row['menu_type_id']));

				$temp = array();

				$temp['id'] = $menu->getMenuTypeId();
				$temp['name'] = $menu->getMenuTypeName();
				$temp['description'] = $menu->getMenuTypeDescription();
				$temp['imageCover'] = $this->ImageBasepath.$menu->getMenuTypeImageCover();
				$temp['created'] = $menu->getMenuTypeCreated();
				$temp['modified'] = $menu->getMenuTypeModified();

				array_push($itemRecords, $temp);
			}
		}

		return $itemRecords;
	}

}
