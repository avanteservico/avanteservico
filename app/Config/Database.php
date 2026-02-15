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

        // Ajuste automático para Supabase: O usuário PRECISA ser 'usuario.ID_PROJETO' no Connection Pooler
        $username = $this->username;
        $isSupabase = (strpos($this->host, 'supabase.co') !== false || strpos($this->host, 'supabase.com') !== false);

        if ($isSupabase && strpos($username, '.') === false) {
            // Só anexar o ID do projeto se estivermos usando o Pooler (Porta 6543)
            if ($this->port == '6543' || strpos($this->host, 'pooler.supabase.com') !== false) {
                $projectRef = getenv('DB_PROJECT_REF') ?: (defined('DB_PROJECT_REF') ? DB_PROJECT_REF : '');

                if (empty($projectRef)) {
                    preg_match('/([a-z0-9]{20})/', $this->host, $matches);
                    $projectRef = $matches[1] ?? '';
                }

                if (!empty($projectRef)) {
                    $username .= '.' . $projectRef;
                }
            }
        }

        try {
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";sslmode=require";
            $this->conn = new PDO($dsn, $username, $this->password);
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
                    <li><strong>Dica para Vercel:</strong> Use o <b>Connection Pooler</b> do Supabase (Porta <b>6543</b> e host <code>pooler.supabase.com</code>) para evitar erros de rede em ambientes serverless.</li>
                    <li>Verifique se o seu IP está autorizado no painel do Supabase (Network Restrictions).</li>
                    <li>Certifique-se de que a senha do banco de dados foi configurada corretamente no painel.</li>
                </ul>
            </div>");
        }

        return $this->conn;
    }
}
