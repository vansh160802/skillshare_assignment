<?php

class Login
{
    /**
     * @var object the database connection
     */
    private $db_connection = null;
    /**
     * @var array collection of error messages
     */
    public $errors = array();
    /**
     * @var array collection of other messages
     */
    public $messages = array();

    public function __construct()
    {
        session_start();

        if (isset($_GET["logout"])) {
            $this->doLogout(); // if user tried to logout
        }
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData(); // if user submitted login form
        }
    }

    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty."; // if username is empty
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty."; // if password is empty
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {  // if both are not empty

            // creating a database connection, using the constants from config/db.php 
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // getting all the info of the selected user from database
                $sql = "SELECT user_name, user_password_hash FROM 'users data'";     

                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {    

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // the hash of that user's password
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // write user data into PHP SESSION so user would be logged in even after refreshing page 
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

   
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a feeedback message
        $this->messages[] = "You have been logged out.";

    }

    /**
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
}