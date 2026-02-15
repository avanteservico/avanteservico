# Guia de Deploy na Vercel - Avante Serviço

Este projeto foi configurado para rodar na Vercel usando o runtime de PHP.

## Requisitos
- Conta na [Vercel](https://vercel.com).
- Banco de dados MySQL externo (Recomendado: PlanetScale, Supabase com extensão MySQL, ou Railway).

## Passo a Passo para Deploy

1. **Conecte o GitHub**: no painel da Vercel, crie um novo projeto e selecione o repositório `avanteservico/avanteservico`.
2. **Configurações de Build**:
   - **Framework Preset**: Other
   - **Build Command**: (Deixe vazio)
   - **Output Directory**: (Deixe vazio)
3. **Variáveis de Ambiente**:
   Adicione as seguintes variáveis no painel da Vercel para que o sistema conecte ao seu banco de dados:

   | Variável | Valor Exemplo |
   | :--- | :--- |
   | `DB_HOST` | `seu-banco.servidor.com` |
   | `DB_NAME` | `avante_servico` |
   | `DB_USER` | `seu_usuario` |
   | `DB_PASS` | `sua_senha` |
   | `DB_PORT` | `3306` |
   | `BASE_URL` | `https://seu-projeto.vercel.app` |
   | `APP_ENV` | `production` |

4. **Deploy**: Clique em "Deploy".

## Notas Importantes
- O arquivo `vercel.json` na raiz cuida de todo o roteamento.
- Arquivos estáticos em `public/` (CSS, JS) são servidos automaticamente.
- Toda requisição é enviada para `api/index.php`, que serve como ponte para o roteador principal do sistema.
