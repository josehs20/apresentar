# Contexto: Painel Administrativo (CRUDs, Imagens Assíncronas e Métricas)

## Objetivo

Desenvolver um painel administrativo completo para gestão de produtos, categorias, blog e **métricas de interações (WhatsApp, Instagram e futuras redes)**, com foco em:

* Performance (AJAX)
* Escalabilidade
* Boas práticas
* Processamento assíncrono

---

# Tarefa

## 1. Controllers Admin

Criar controllers Resource em:

`App\Http\Controllers\Admin`

* ProductController
* PostController
* CategoryController

Criar também:

* DashboardController
* InteracaoController (opcional para visualização de logs)

---

## 2. Rotas

* Prefixo: `/admin`
* Middleware: `auth`
* Name: `admin.*`

Utilizar:

```php
Route::resource()
```

Adicionar rota para dashboard:

```php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
```

---

## 3. CRUD com AJAX (SEM RELOAD)

Todos os CRUDs devem funcionar de forma assíncrona:

### Requisitos:

* Criar, editar e deletar via AJAX (fetch ou axios)
* Paginação sem reload
* Atualização parcial da tabela
* Feedback visual:

  * loading
  * sucesso
  * erro

### Interações:

* Botões de ação devem atualizar dados em tempo real
* Atualizar métricas sem reload (ex: contador de cliques)

---

## 4. Upload de Imagens (ASSÍNCRONO)

### Regra obrigatória:

**NÃO processar imagens no controller**

### Fluxo:

1. Controller:

   * Upload temporário
   * Disparo do Job:

```php
ProcessarImagem::dispatch($caminho);
```

2. Job `ProcessarImagem`:

* Redimensionar (máx 1200px)
* Converter para WebP (80%)
* Salvar no disk `public`
* Atualizar o registro no banco

---

## 5. SEO no Admin

Adicionar nos formulários:

* meta_title
* meta_description
* meta_image

---

## 6. Dashboard (ATUALIZADO)

Criar dashboard com métricas baseadas na tabela `interacoes`:

### Cards principais:

* Total de interações
* Total de cliques WhatsApp
* Total de cliques Instagram

### Gráficos:

* Interações por tipo (WhatsApp vs Instagram)
* Interações por dia

### Rankings:

* Produtos mais clicados (geral)
* Produtos mais clicados por tipo:

  * WhatsApp
  * Instagram

---

## 7. Gestão de Tipos de Interação (NOVO)

Criar gestão opcional para:

**TipoInteracao**

Permitir:

* Criar novos tipos (ex: facebook, telefone, email)
* Ativar/desativar tipos
* Evitar necessidade de novas migrations

---

## 8. Views (IMPORTANTE)

* Blade + Bootstrap
* Componentização obrigatória

### Estrutura sugerida:

* dashboard.blade.php
* products/
* categories/
* posts/

### Componentes:

* modais
* tabelas
* alerts
* loaders

⚠️ IMPORTANTE:

👉 Primeiro implementar toda lógica (backend + AJAX)
👉 Layout final e design refinado ficam por último

---

# Regras

* Usar FormRequest para validação
* Respostas devem ser JSON (para AJAX)
* Controllers devem ser leves
* Separar lógica em Services/Jobs
* NÃO processar imagens no controller
* Código escalável e organizado

---

# Diferenciais (Opcional)

* Alpine.js ou Vue para interatividade
* Filtros dinâmicos no dashboard
* Busca em tempo real (AJAX)
* Cache de métricas (opcional)
* Atualização em tempo real (polling ou websocket)

---

# Resultado Esperado

* CRUDs rápidos e sem reload
* Upload de imagem desacoplado
* Dashboard completo com métricas por tipo (WhatsApp, Instagram, etc)
* Sistema preparado para novas redes sem alterar estrutura
* Código limpo e pronto para escalar
