# Contexto: Banco de Dados e Modelagem

Precisamos criar as tabelas no SQLite para gerenciar o catálogo de cosméticos naturais, blog e **métricas de interação do usuário (WhatsApp, Instagram e futuras redes)**.

---

# Tarefa

Crie as Migrations, Models (com seus relacionamentos) e Factories para as seguintes entidades:

---

## 1. **Categoria (Categorias de Produtos)**

* Campos:

  * `id`
  * `nome`
  * `slug` (único)
  * `descricao` (nullable)

* Relacionamento:

  * Uma categoria possui vários produtos

---

## 2. **Produto (Cosméticos)**

* Campos:

  * `id`
  * `categoria_id`
  * `nome`
  * `slug` (único)
  * `descricao` (text)
  * `composicao` (text)
  * `preco` (decimal, nullable)
  * `caminho_imagem` (string, nullable)
  * `ativo` (boolean, padrão true)
  * `tipo_pele` (string, nullable)

### SEO

* `meta_titulo` (string, nullable)

* `meta_descricao` (text, nullable)

* `meta_imagem` (string, nullable)

* Relacionamento:

  * Pertence a uma categoria
  * Possui várias interações

---

## 3. **Postagem (Artigos do Blog)**

* Campos:

  * `id`
  * `titulo`
  * `slug` (único)
  * `resumo` (text)
  * `conteudo` (longtext)
  * `caminho_imagem` (string, nullable)
  * `publicado_em` (timestamp, nullable)

### SEO

* `meta_titulo` (string, nullable)
* `meta_descricao` (text, nullable)
* `meta_imagem` (string, nullable)

---

## 4. **TipoInteracao (Tipos de Interação / Redes)**

Tabela responsável por definir os tipos de interação disponíveis no sistema.

* Campos:

  * `id`
  * `nome` (ex: whatsapp, instagram, clique_site, telefone)
  * `descricao` (nullable)

* Relacionamento:

  * Um tipo possui várias interações

---

## 5. **Interacao (Registro de Interações do Usuário)**

Tabela principal de métricas (substitui WhatsappClick).

* Campos:

  * `id`
  * `produto_id` (nullable)
  * `tipo_interacao_id`
  * `ip`
  * `user_agent`
  * `criado_em`

* Relacionamentos:

  * Pertence a Produto (opcional)
  * Pertence a TipoInteracao

---

# Regras

* Utilize `SoftDeletes` nos models `Produto` e `Postagem`
* Os slugs devem ser únicos com verificação incremental automática
* Criar factories para todas as entidades
* Estrutura deve permitir adicionar novas redes sem alterar o banco

---

# Seeder

Criar dados iniciais:

### Usuário

* 1 usuário admin (senha: password)

### Categorias

* 3 categorias

### Produtos

* 10 produtos

### Postagens

* 3 postagens

### Tipos de Interação

Inserir:

* whatsapp
* instagram

---

# Observações

* Campos de SEO devem ser usados no frontend para meta tags dinâmicas
* A tabela `interacoes` será usada no dashboard para métricas
* O sistema deve permitir facilmente adicionar novas interações futuramente sem necessidade de migration

---

# Objetivo da Modelagem

Essa estrutura deve permitir:

* Contar cliques por produto
* Separar métricas por origem (WhatsApp, Instagram, etc)
* Gerar rankings de conversão
* Escalar facilmente para novas integrações
