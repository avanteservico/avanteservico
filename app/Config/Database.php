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

        // Ajuste automático para Supabase: O usuário muitas vezes precisa ser 'postgres.ID_PROJETO'
        // Especialmente ao usar o Connection Pooler (porta 6543)
        $username = $this->username;
        if (strpos($this->host, 'supabase.co') !== false && strpos($username, '.') === false) {
            $parts = explode('.', $this->host);
            // db.rybcmhwcafpzwroyduwz.supabase.co -> ref é o segundo elemento
            if (count($parts) >= 2 && $parts[0] === 'db') {
                $username .= '.' . $parts[1];
            }
        }

        try {
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";sslmode=require";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            die("<div style='font-family: sans-serif; padding: 20px; border: 1px solid #f87171; background: #fef2f2; color: #991b1b; border-radius: 8px; max-width: 600px; margin: 20px auto;'>
                <h2 style='margin-top: 0;'>Erro de Conexão com o Banco de Dados</h2>
                <p>Não foi possível conectar ao Supabase.</p>
                <p><strong>Detalhe Técnico:</strong> " . $exception->getMessage() . "</p>
                <hr style='border: 0; border-top: 1px solid #f87171; margin: 15px 0;'>
                <p><strong>Sugestões:</strong></p>
                <ul style='padding-left: 20px;'>
                    <li>Verifique se as credenciais no arquivo <code>app/Config/config.php</code> estão corretas.</li>
                    <li>Verifique se o seu IP está autorizado no painel do Supabase (Network Restrictions).</li>
                    <li>Certifique-se de que a senha do banco de dados foi configurada corretamente no painel.</li>
                </ul>
            </div>");
        }

        return $this->conn;
    }
}
