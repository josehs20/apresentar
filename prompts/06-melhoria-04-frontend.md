# Frontend Público - Vitrine Profissional e Conversão

## Contexto

Desenvolver o frontend público com foco em:

* Conversão (WhatsApp e redes sociais)
* Experiência do usuário (UX)
* Design moderno e agradável
* Identidade visual artesanal (tons naturais e elegantes)

IMPORTANTE:

* Priorizar layout, estética e experiência
* Código limpo e preparado para evolução

---

## Objetivo

Criar uma vitrine digital profissional que:

* Destaque os produtos
* Gere desejo
* Converta cliques em contato (WhatsApp)
* Seja visualmente agradável e confiável

---

## Stack

* Laravel Blade
* Bootstrap 5
* CSS customizado
* Bootstrap Icons

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

---

### Tipografia

* Fonte: Inter
* Textos leves, espaçados e legíveis

---

## Layout Base

Criar:

layouts/app.blade.php

### Estrutura

* Header fixo (com leve transparência ou sombra)
* Conteúdo principal
* Footer elegante

---

## Header

### Deve conter:

* Logo
* Menu:

  * Home
  * Catálogo
  * Blog
* Botão de destaque:

  * "Fale no WhatsApp"

### Comportamento:

* Fixo no topo
* Efeito ao scroll (reduz tamanho ou adiciona sombra)

---

## Home (FOCO EM CONVERSÃO)

Criar:

home.blade.php

---

### Seções obrigatórias:

#### Hero (primeira dobra)

* Imagem forte (produto ou lifestyle)
* Texto curto e emocional
* Botão:

  * "Ver produtos"
  * "Falar no WhatsApp"

---

#### Produtos em destaque

* Grid moderno
* Cards com:

  * Imagem
  * Nome
  * Botão "Ver produto"

---

#### Sobre a marca

* Texto curto
* Foco artesanal / natural

---

#### CTA forte

* Bloco visual chamativo
* Botão WhatsApp

---

## Catálogo

catalog/index.blade.php

---

### Layout:

* Grid responsivo
* Cards com:

  * Hover (leve zoom na imagem)
  * Sombra suave
  * Transição

---

## Produto (DETALHE)

catalog/show.blade.php

---

### Estrutura:

* Imagem grande
* Nome
* Descrição
* Informações (ex: tipo de pele)

---

### Ações (PRINCIPAL FOCO)

* Botão WhatsApp (primário)
* Botão Instagram

IMPORTANTE:

* TODOS os botões devem usar rota:

/interacao/{produto}/{tipo}

---

## Blog

### Listagem

* Cards com imagem
* Título
* Resumo

---

### Detalhe

* Conteúdo limpo
* Tipografia confortável
* Espaçamento generoso

---

## Interação (Tracking)

Criar rota:

/interacao/{produto}/{tipo}

Controller deve:

* Registrar interação
* Redirecionar corretamente

---

## SEO

Implementar no layout:

* title dinâmico
* meta description
* og:image

---

## UX (DIFERENCIAL)

Aplicar:

* Hover suave em botões
* Transições (0.2s)
* Espaçamento consistente
* Bordas arredondadas
* Sombras leves

---

## Microinterações

* Botões com efeito hover
* Cards com leve animação
* Feedback visual ao clicar

---

## Responsividade

* Mobile first
* Grid adaptável
* Botões grandes no mobile

---

## Regras

* NÃO usar links diretos externos
* NÃO acoplar tracking na view
* Código limpo e organizado

---

## Resultado Esperado

* Site moderno e agradável
* Visual alinhado com marca artesanal
* Alta conversão via WhatsApp
* Estrutura pronta para escalar
