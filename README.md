
# ServiceHub - Gestão de Tickets Corporativos

O **ServiceHub** é uma solução enterprise para gerenciamento de chamados técnicos e triagem de dados, desenvolvida com foco em performance, escalabilidade e experiência do usuário (UX). 

Este projeto foi refatorado seguindo **boas práticas de engenharia de software**, com foco em arquitetura limpa e documentação integrada.

---

## Novas Funcionalidades e Melhorias

* **Documentação Interna:** Código comentado e estruturado para facilitar a manutenção pela equipe técnica.
* **Processamento Assíncrono:** Implementação de **Jobs** e **Queues** para processamento de anexos em segundo plano.
* **Localização Completa:** Validações e mensagens de sistema padronizadas.
* **Fluxo de Autenticação Inteligente:** Redirecionamento automático baseado no status do usuário (Login/Dashboard).
* **Automação de Ambiente:** Seeders avançados que reconstroem o banco de dados com empresas e projetos reais.

---

##  Pré-requisitos de Ambiente (XAMPP)

Para que o **ServiceHub** funcione corretamente no Windows, é necessário garantir que os serviços de servidor e banco de dados estejam ativos:

1. **XAMPP Control Panel:**
   - Inicie o **Apache** (Servidor Web).
   - Inicie o **MySQL** (Banco de Dados).
   
2. **Configuração do Banco:**
   - Certifique-se de que você criou um banco de dados vazio no seu MySQL (via phpMyAdmin ou terminal) com o nome definido no seu arquivo `.env` (ex: `servicehub`).

3. **Execução Simultânea (Obrigatório):**
   Para a experiência completa (Frontend reativo + Filas assíncronas), você deve manter **três instâncias do terminal** abertas na pasta do projeto:
   - `php artisan serve` (Backend)
   - `npm run dev` (Frontend/Vite)
   - `php artisan queue:listen` (Processador de Tickets)


## Guia de Execução 

Siga estes passos:

### 1. Preparação do Ambiente
BASH
composer install
npm install
php artisan key:generate

### 2. Reset e Automação do Banco
Este comando limpa o banco e recria o perfil do Administrador, empresas e projetos automaticamente:

Bash
php artisan migrate:fresh --seed

### 3. Execução em Desenvolvimento
Mantenha os processos ativos para garantir o funcionamento do Vue 3 e das Filas:

Aplicação: php artisan serve

Vite (Frontend): npm run dev

Worker (Processamento): php artisan queue:listen