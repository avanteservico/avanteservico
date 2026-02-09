#!/bin/bash

# Script de build para Render
echo "🚀 Iniciando build do Avante Serviço..."

# Verificar se o PHP está instalado
php -v

# Criar diretórios necessários se não existirem
mkdir -p tmp
mkdir -p public

echo "✅ Build concluído com sucesso!"
