# Admin - Configurações Dinâmicas (Cores) + Pontos de Venda com Mapa

## Contexto

O sistema já possui um painel administrativo em:

/admin

É necessário evoluir o admin com:

1. Configuração dinâmica de cores (via CRUD dentro de Configurações)
2. Novo módulo: Pontos de Venda com geolocalização
3. Integração com frontend público

---

## 🎨 CONFIGURAÇÕES - CRUD DE CORES

### Objetivo

Permitir que as cores do sistema sejam gerenciadas via painel administrativo, sem necessidade de alterar código.

---

### Cores padrão

- primary_color → #76877D (cor principal)
- secondary_color → #96958A (títulos / institucional)
- accent_color → #88B8A9 (CTAs / destaques)
- border_color → #B2CBAE (bordas suaves)
- background_color → #F8F6F0 (fundo principal)

---

### Banco de dados

Criar tabela:

configuracoes

Campos:

- id
- primary_color (string)
- secondary_color (string)
- accent_color (string)
- border_color (string)
- background_color (string)
- created_at
- updated_at

---

### Backend

Criar:

- Model: Configuracao
- Controller: ConfiguracaoController

Funcionalidades:

- Editar (single record)
- Atualizar cores

Regra:

- Sempre trabalhar com apenas 1 registro (config global)

---

### Admin UI

Tela:

/admin/configuracoes

Formulário com:

- Input color (type="color") para cada cor
- Preview visual (opcional)
- Botão salvar

---

### Integração com Frontend

No layout principal:

layouts/app.blade.php

Injetar dinamicamente:

```html
<style>
:root {
  --primary: {{ $config->primary_color }};
  --secondary: {{ $config->secondary_color }};
  --accent: {{ $config->accent_color }};
  --border: {{ $config->border_color }};
  --background: {{ $config->background_color }};
}
</style>