# Contexto: Frontend, Vitrine e Conversão (WhatsApp + Interações)

## Objetivo

Desenvolver o frontend público do sistema com foco em:

* Exibição de produtos (vitrine)
* Conteúdo de blog
* Conversão via WhatsApp
* Rastreamento de interações (WhatsApp, Instagram e futuras redes)

⚠️ IMPORTANTE:
Primeiro desenvolver a **estrutura do layout e páginas**.
A lógica avançada e refinamentos visuais podem ser feitos posteriormente.

---

# Tarefa

## 1. Controllers Públicos

Criar:

* HomeController
* CatalogController
* BlogController
* InteracaoController (substitui WhatsappController)

---

## 2. Views (Estrutura Base)

Criar as views com Blade:

* layouts/app.blade.php (layout público)
* home.blade.php
* catalog/index.blade.php
* catalog/show.blade.php
* blog/index.blade.php
* blog/show.blade.php

---

## 3. Layout Público (PRIMEIRA ETAPA)

Criar layout base com:

### Header

* Logo
* Menu:

  * Home
  * Catálogo
  * Blog

### Conteúdo

* `@yield('content')`

### Footer

* Informações básicas
* Links

---

## 4. Conversão com Tracking (WHATSAPP + ESCALÁVEL)

❌ NÃO usar links diretos para WhatsApp

✔ Criar rota:

```php
GET /interacao/{produto}/{tipo}
```

Exemplo:

```bash
/interacao/1/whatsapp
/interacao/1/instagram
```

---

### Controller: InteracaoController

Fluxo:

1. Identificar `tipo_interacao` (whatsapp, instagram, etc)

2. Registrar na tabela `interacoes`:

   * produto_id
   * tipo_interacao_id
   * ip
   * user_agent

3. Redirecionar conforme tipo:

#### WhatsApp:

```text
https://wa.me/55SEUNUMERO?text=Olá! Tenho interesse no produto [NOME]
```

#### Instagram:

* Redirecionar para perfil ou link configurado

---

## 5. SEO DINÂMICO

No `<head>` do layout:

* `<title>` → meta_title ou fallback
* `<meta name="description">` → meta_description
* `<meta property="og:image">` → meta_image ou imagem do produto

---

## 6. Home

Exibir:

* Produtos ativos
* Produtos em destaque
* Link para blog

---

## 7. Catálogo

### Listagem (catalog.index)

* Grid de produtos
* Imagem
* Nome
* Botão "Ver produto"

---

### Detalhe (catalog.show)

* Imagem
* Descrição
* Composição
* Tipo de pele
* Botões de ação:

✔ WhatsApp (com tracking)
✔ Instagram (com tracking)

---

## 8. Blog

### Listagem

* Lista de posts

### Detalhe

* Conteúdo completo

---

# Regras

* Mobile First
* Sem carrinho (venda via WhatsApp)
* Usar imagens via storage
* CTAs devem SEMPRE passar pelo sistema de interações
* Código preparado para múltiplos tipos de conversão
* Separar bem layout e lógica

---

# Importante (Arquitetura)

* NÃO acoplar lógica de tracking na view
* NÃO usar links diretos externos
* Tudo deve passar pelo backend (InteracaoController)

---

# Resultado Esperado

* Vitrine funcional
* Conversão rastreável (WhatsApp + Instagram)
* Estrutura pronta para escalar
* Layout simples inicialmente (refinamento depois)
