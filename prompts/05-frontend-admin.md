# Admin Dashboard Layout - Profissional

## Contexto

Criar um painel administrativo profissional com identidade visual moderna, inspirado em marcas artesanais com estética natural (tons terrosos, minimalismo e elegância).

O foco desta etapa é exclusivamente:

* Layout
* Estrutura visual
* Componentização

NÃO implementar:

* AJAX
* lógica de CRUD
* integração com backend

---

## Objetivo

Construir uma base sólida de interface para:

* Dashboard com métricas
* CRUDs (estrutura visual)
* Perfil do usuário
* Layout reutilizável e escalável

---

## Stack

* Laravel Blade
* Bootstrap 5
* Bootstrap Icons
* CSS customizado

---

## Identidade Visual

### Cores

:root {
--primary: #6B4F3A;
--secondary: #A67C52;
--accent: #2E5E4E;
--light: #F5F1EB;
--dark: #2B2B2B;
}

### Tipografia

* Fonte: Inter
* Visual limpo, moderno e espaçado

---

## Estrutura de Layout

Criar:

resources/views/layouts/admin.blade.php

### Layout deve conter:

* Sidebar fixa à esquerda
* Topbar superior
* Área de conteúdo
* Responsividade

---

## Sidebar

### Requisitos

* Fixa
* Colapsável
* Ícones (Bootstrap Icons)
* Estado ativo
* Hover suave

### Menu

* Dashboard
* Produtos
* Categorias
* Blog
* Perfil

---

## Topbar

### Elementos

* Nome do usuário
* Avatar
* Dropdown com:

  * Perfil
  * Logout

---

## Página de Perfil

Criar:

admin/profile.blade.php

### Campos

* Nome
* Email
* Senha
* Foto (preview)

### Layout

* Card centralizado
* Botão salvar
* Feedback visual

---

## Dashboard

Criar:

admin/dashboard.blade.php

### Estrutura

#### Cards de métricas

* Total de interações
* Cliques WhatsApp
* Cliques Instagram

#### Requisitos dos cards

* Ícones
* Sombras leves
* Bordas arredondadas
* Hover suave

---

### Ranking

Tabela com:

* Nome do produto
* Total de interações

---

### Gráfico

* Placeholder visual
* Não implementar lógica

---

## CRUDs (Estrutura)

Criar:

* admin/products
* admin/categories
* admin/posts

### Arquivos

* index.blade.php
* create.blade.php
* edit.blade.php

---

## Listagem (index)

Tabela com:

* Nome
* Status
* Ações (editar / excluir)

Botão:

* Novo (destaque visual)

---

## Formulários

Campos base:

* Nome
* Categoria
* Descrição
* Preço
* Imagem

SEO:

* meta_title
* meta_description

---

## Componentização

Criar componentes:

* components/card.blade.php
* components/table.blade.php
* components/modal.blade.php
* components/alert.blade.php
* components/button.blade.php
* components/sidebar.blade.php
* components/topbar.blade.php

Formulários:

* components/form/input.blade.php
* components/form/textarea.blade.php

---

## UX e Design

* Espaçamento consistente (padding e gap)
* Bordas arredondadas (rounded-3)
* Sombras leves
* Transições suaves (0.2s)
* Layout limpo e organizado

---

## Responsividade

* Sidebar colapsável em mobile
* Grid adaptável
* Tabelas responsivas

---

## Boas Práticas

* Separar layout, partials e components
* Evitar duplicação de código
* Preparar HTML para futura integração com AJAX (data attributes, IDs)

---

## Resultado Esperado

* Dashboard moderno e profissional
* Layout reutilizável
* Interface consistente
* Base pronta para evolução com AJAX e lógica backend
