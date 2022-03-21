<?php
class MenuTypeClass
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



    public function __construct($con, $id)
    {
        $this->conn = $con;
        $this->id = $id;

        $stmt = $this->conn->prepare("SELECT id,name,description,imageCover,created, modified FROM " . $this->itemsTable . " WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->bind_result($this->id, $this->name, $this->description, $this->imageCover, $this->created, $this->modified);

        while ($stmt->fetch()) {
        $this->id = $id;
        $this->name = $this->name;
        $this->description = $this->description;
        $this->imageCover = $this->imageCover;
        $this->created = $this->created;
        $this->modified = $this->modified;

        }
    }


    function getMenuTypeId() {
        return $this->id;
    }

    function getMenuTypeName() {
        return $this->name;
    }

    function getMenuTypeDescription() {
        return $this->description;
    }

    function getMenuTypeImageCover() {
        return $this->imageCover;
    }

    function getMenuTypeCreated() {
        return $this->created;
    }

    function getMenuTypeModified() {
        return $this->modified;
    }

    function getCategoryMenuitems(){

        $categoryMenuItems = array();

        $stmt = $this->conn->prepare("SELECT menu_id,menu_name, price, description, menu_type_id, menu_image,backgroundImage,ingredients, menu_status, created, modified,rating FROM tblmenu WHERE menu_type_id = ? ORDER BY menu_id LIMIT 6");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->bind_result($this->menu_id, $this->menu_name, $this->price, $this->description, $this->menu_type_id, $this->menu_image, $this->backgroundImage, $this->ingredients, $this->menu_status, $this->created, $this->modified, $this->rating);

        while ($stmt->fetch()) {
            $temp = array();

			$temp['menu_id'] = $this->menu_id;
			$temp['menu_name'] = $this->menu_name;
			$temp['price'] = $this->price;
			$temp['description'] = $this->description;
			$temp['menu_type_id'] = $this->menu_type_id;
			$temp['menu_image'] = $this->ImageBasepath.$this->menu_image;
			$temp['backgroundImage'] = $this->ImageBasepath.$this->backgroundImage;
			$temp['ingredients'] = $this->description;
			$temp['menu_status'] = $this->menu_type_id;
			$temp['created'] = $this->created;
			$temp['modified'] = $this->modified;
			$temp['rating'] = $this->rating;


			array_push($categoryMenuItems, $temp);

        }

        return $categoryMenuItems;
    }

}
