<?php 
// Définition de la classe Database pour gérer la connexion à la base de données via PDO
class Database {
    private static $instance = null;
    // Stocke la connexion PDO
    private $connection;
     // Informations de connexion 
    private $host = 'localhost';
    private $dbname = 'nfe';
    private $username = 'root';
    private $password = '';

    // Constructeur privé pour empêcher l'instanciation directe depuis l'extérieur
    private function __construct() {
        try {
            // Création d'une nouvelle connexion PDO avec les informations fournies
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            
            // Définir le mode d'erreur de PDO sur Exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // En cas d'erreur, arrêt du script et affichage du message d'erreur
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode statique pour obtenir l'instance unique de la classe (Singleton)
    public static function getInstance() {
        // Si aucune instance n'existe, en créer une
        if (!self::$instance) {
            self::$instance = new Database();
        }
        // Retourner l'instance existante
        return self::$instance;
    }

    // Retourner l'objet PDO (connexion à la base de données)
    public function getConnection() {
        return $this->connection;
    }
}

?>