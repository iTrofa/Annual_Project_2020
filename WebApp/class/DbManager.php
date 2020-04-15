<?php


require_once 'vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

class DbManager
{
    private PDO $db;

    /**
     * @return PDO
     */
    public function getDb(): PDO
    {
        return $this->db;
    }
    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env');

       $this->db = new PDO(($_ENV['DSN']), $_ENV['DBUSER'], $_ENV['DBPASSWORD']);
       $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    }

    public function query( string  $query, ?array $params = null):?PDOStatement{
        if ($params){
            $q = $this->getDb()->prepare($query);
            $q->execute($params);
            return $q;
        }
        return $this->getDb()->query($query);
    }
    
    public static function v4(): ?string
    {
            return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

                // 32 bits for "time_low"
                random_int(0, 0xffff), random_int(0, 0xffff),

                // 16 bits for "time_mid"
                random_int(0, 0xffff),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                random_int(0, 0x0fff) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                random_int(0, 0x3fff) | 0x8000,

                // 48 bits for "node"
                random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
            );

    }
}
