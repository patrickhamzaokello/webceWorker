<?php
//getting the database connection
include_once '../../../../admin/config.php';

$database = new Database();
$conn = $database->getConnString();

//an array to display response
$response = array();

//if it is an api call 
//that means a get parameter named api call is set in the URL 
//and with this parameter we are concluding that it is an api call 
if (isset($_GET['apicall'])) {

        switch ($_GET['apicall']) {

                case 'signup':

                        //checking the parameters required are available or not 
                        if (isTheseParametersAvailable(array('full_name', 'email', 'phone_number', 'password', 'location_address'))) {

                                //getting the values 
                                $full_name = $_POST['full_name'];
                                $email = $_POST['email'];
                                $phone_number = $_POST['phone_number'];
                                $password = md5($_POST['password']);
                                $location_address = $_POST['location_address'];
                                $profileimage = "https://media.istockphoto.com/vectors/creative-vector-seamless-pattern-vector-id975589890?k=20&m=975589890&s=612x612&w=0&h=2acWhh0ASGWI7vRqofWthsp2UqagVUCQqdmUQLyAs3Y=";


                                //checking if the user is already exist with this username or email
                                //as the email and username should be unique for every user 
                                $stmt = $conn->prepare("SELECT user_id FROM users WHERE phone_number = ? OR email = ?");
                                $stmt->bind_param("ss", $phone_number, $email);
                                $stmt->execute();
                                $stmt->store_result();


                                //if the user already exist in the database 
                                if ($stmt->num_rows > 0) {
                                        $response['error'] = true;
                                        $response['message'] = 'User already registered';
                                        $stmt->close();
                                } else {

                                        //if user is new creating an insert query 
                                        $stmt = $conn->prepare("INSERT INTO users (`full_name`, `email`, `phone_number`, `address`, `profile_image`,`password`) VALUES (?, ?, ?, ?, ?, ?)");
                                        $stmt->bind_param("ssssss", $full_name, $email, $phone_number, $location_address, $profileimage, $password);

                                        //if the user is successfully added to the database 
                                        if ($stmt->execute()) {

                                                //fetching the user back 
                                                $stmt = $conn->prepare("SELECT `user_id`, `full_name`, `email`, `phone_number`, `address`, `profile_image` FROM users WHERE phone_number = ? OR email = ?");
                                                $stmt->bind_param("ss", $phone_number, $email);
                                                $stmt->execute();
                                            $stmt->bind_result($user_id, $full_name, $email, $phone_number, $address, $profile_image);
                                            $stmt->fetch();

                                            $user = array(
                                                'id' => $user_id,
                                                'fullname' => $full_name,
                                                'email' => $email,
                                                'phone' => $phone_number,
                                                'address' => $address,
                                                'profileimage' => $profile_image
                                            );

                                            $stmt->close();

                                                //adding the user data in response 
                                                $response['error'] = false;
                                                $response['message'] = 'User registered successfully';
                                                $response['user'] = $user;
                                        }
                                }
                        } else {
                                $response['error'] = true;
                                $response['message'] = 'required parameters are not available';
                        }

                        break;

                case 'login':

                        //for login we need the username and password 
                        if (isTheseParametersAvailable(array('username', 'password'))) {
                                //getting values
                                $username = $_POST['username'];
                                $password = md5($_POST['password']);

                                $check_email = Is_email($username);
                                if ($check_email) {
                                        // email & password combination 
                                        $stmt = $conn->prepare("SELECT `user_id`, `full_name`, `email`, `phone_number`, `address`, `profile_image` FROM users WHERE email = ? AND password = ?");
                                } else {
                                        // username & password combination
                                        $stmt = $conn->prepare("SELECT `user_id`, `full_name`, `email`, `phone_number`, `address`, `profile_image` FROM users WHERE phone_number = ? AND password = ?");
                                }

                                //creating the query 
                                $stmt->bind_param("ss", $username, $password);

                                $stmt->execute();

                                $stmt->store_result();

                                //if the user exist with given credentials 
                                if ($stmt->num_rows > 0) {

                                        $stmt->bind_result($user_id, $full_name, $email, $phone_number, $address, $profile_image);
                                        $stmt->fetch();

                                        $user = array(
                                                'id' => $user_id,
                                                'fullname' => $full_name,
                                                'email' => $email,
                                                'phone' => $phone_number,
                                                'address' => $address,
                                                'profileimage' => $profile_image
                                        );

                                        $response['error'] = false;
                                        $response['message'] = 'Login successfull';
                                        $response['user'] = $user;
                                } else {
                                        //if the user not found 
                                        $response['error'] = true;
                                        $response['message'] = 'Invalid username or password';
                                }
                        }else {
                            $response['error'] = true;
                            $response['message'] = 'required parameters are not available';
                        }

                    break;

                default:
                        $response['error'] = true;
                        $response['message'] = 'Invalid Operation Called';
        }
} else {
        //if it is not api call 
        //pushing appropriate values to response array 
        $response['error'] = true;
        $response['message'] = 'Invalid API Call';
}

//displaying the response in json structure 
echo json_encode($response);

//function validating all the paramters are available
//we will pass the required parameters to this function 
function isTheseParametersAvailable($params)
{

        //traversing through all the parameters 
        foreach ($params as $param) {
                //if the paramter is not available
                if (!isset($_POST[$param])) {
                        //return false 
                        return false;
                }
        }
        //return true if every param is available 
        return true;
}

function Is_email($user)
{
        //If the username input string is an e-mail, return true
        if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
                return true;
        } else {
                return false;
        }
}
