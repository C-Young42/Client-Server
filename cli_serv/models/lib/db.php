<?php // database connection file
class db {
    /**
     * @var db
     */
    protected static $_dbInstance = null;
    /**
     * @var PDO
     */
    protected $_dbHandle;
    /**
     * @return db
     */
    public static function getInstance()
    {
        if (self::$_dbInstance === null) {
            //checks if the PDO exists
            $username ='sgb201';
            $password = 'Youngy911';
            $host = 'poseidon.salford.ac.uk';
            $dbName = 'sgb201_cliserv';
            // creates new instance if not, sending in connection info
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }
        return self::$_dbInstance;
    }
    /**
     * @param $username
     * @param $password
     * @param $host
     * @param $database
     */
    private function __construct($username, $password, $host, $database)
    {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database",  $username, $password); // creates the database handle with connection info
            $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_dbHandle->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        catch (PDOException $e) { // catch any failure to connect to the database
            echo $e->getMessage();
        }
    }
    /**
     * @return PDO
     */
    public function getdbConnection()
    {
        return $this->_dbHandle; // returns the PDO handle to be usedelsewhere
    }

    public function __destruct()
    {
        $this->_dbHandle = null; // destroys the PDO handle when nolonger needed
    }

    public static function db()
    {
        return db::getInstance()->getdbConnection();
    }
}