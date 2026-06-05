# CONTROLE DE EXECUÇÃO DOS PROMPTS (00 → 05)

## Objetivo

Executar os prompts de forma **sequencial, controlada e sem perda de contexto**, evitando que a IA misture etapas ou gere código inconsistente.

---

# Regras Gerais (OBRIGATÓRIO)

1. Executar **APENAS UM arquivo por vez**
2. NÃO antecipar próximas etapas
3. NÃO modificar escopo do arquivo atual
4. NÃO misturar lógica de outros prompts
5. Sempre validar antes de avançar

---

# Ordem de Execução

Executar exatamente nesta ordem:

1. `00-ambiente-e-docker.md`
2. `01-setup-autenticacao-e-libs.md`
3. `02-modelagem-e-migrations.md`
4. `03-backend-painel-admin.md`
5. `04-frontend-vitrine-e-redirecionamento.md`
6. `05-frontend-admin.md`

---

# Fluxo de Execução

Para cada arquivo:

## PASSO 1

Carregar o conteúdo do arquivo atual.

---

## PASSO 2

Executar SOMENTE o que está definido no arquivo.

* Não adicionar funcionalidades extras
* Não antecipar próximas etapas
* Não refatorar partes fora do escopo

---

## PASSO 3

Validar execução:

* Código compila?
* Rotas funcionam?
* Migrations rodaram?
* Views carregam?

---

## PASSO 4

Responder obrigatoriamente:

```text
ETAPA [NOME_DO_ARQUIVO] CONCLUÍDA COM SUCESSO
```

ou

```text
ERRO NA ETAPA [NOME_DO_ARQUIVO]:
[DESCRIÇÃO]
```

---

## PASSO 5

AGUARDAR confirmação para continuar

❗ NÃO avançar automaticamente para o próximo arquivo

---

# Regras de Segurança

* NÃO reescrever código já validado
* NÃO alterar migrations antigas após execução
* NÃO misturar backend com frontend fora da etapa correta
* NÃO criar arquivos fora do escopo atual

---

# Controle de Contexto

Cada arquivo deve ser tratado como:

```text
contexto isolado
```

A IA deve:

* esquecer implementações futuras
* focar apenas no presente arquivo
* manter consistência com o que já foi executado

---

# Exemplo de Execução Correta

Usuário:

> Execute 02-modelagem-e-migrations.md

IA:

* Executa apenas migrations/models
* NÃO cria controllers
* NÃO cria views
* NÃO cria dashboard

---

# Exemplo de Execução Incorreta (PROIBIDO)

* Criar frontend durante backend
* Criar dashboard no passo 02
* Implementar AJAX antes do passo 05

---

# Objetivo Final

Garantir:

* Código limpo
* Execução previsível
* Sem retrabalho
* Sem perda de contexto

---

# Importante

Se houver dúvida:

👉 parar execução
👉 pedir esclarecimento

NUNCA assumir comportamento fora do prompt
