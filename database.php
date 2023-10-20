<?php





class db_connect
{
    public $conn;

    function __construct()
    {
        $this->conn = mysqli_connect('localhost', 'root', '', 'alcohol');
    }

    function run_sql($select, $error, $params)
    {
        // Check for a connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            return false;
        }

        $res = mysqli_query($this->conn, $select);

        if (!$res) {
            echo "Error executing query: " . mysqli_error($this->conn);
            return false;
        }

        $result = array();
        while ($fetch = mysqli_fetch_array($res)) {
            $result[] = $fetch;
        }

        mysqli_close($this->conn);

        return $result;
    }
}

// Example usage
$db = new db_connect();
$select_query = "SELECT * FROM flasa";
$error_message = "Error retrieving data";
$params = array(); // You can add parameters if needed
$result = $db->run_sql($select_query, $error_message, $params);

// Now $result should contain the fetched data
// Handle $result as needed
