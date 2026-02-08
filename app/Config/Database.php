<?php

class Database
{
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $port = DB_PORT;
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            die("<div style='font-family: sans-serif; padding: 20px; border: 1px solid #f87171; background: #fef2f2; color: #991b1b; border-radius: 8px; max-width: 600px; margin: 20px auto;'>
                <h2 style='margin-top: 0;'>Erro de Conexão com o Banco de Dados</h2>
                <p>Não foi possível conectar ao MySQL Local.</p>
                <p><strong>Detalhe Técnico:</strong> " . $exception->getMessage() . "</p>
                <hr style='border: 0; border-top: 1px solid #f87171; margin: 15px 0;'>
                <p><strong>Sugestões:</strong></p>
                <ul style='padding-left: 20px;'>
                    <li>Verifique se o <strong>XAMPP</strong> está aberto e o módulo <strong>MySQL</strong> está iniciado (verde).</li>
                    <li>Verifique se o banco de dados <code>avante_servico</code> foi criado no phpMyAdmin.</li>
                    <li>Verifique se o arquivo <code>app/Config/config.php</code> está correto (usuário root, senha vazia).</li>
                </ul>
            </div>");
        }

        return $this->conn;
    }
}
