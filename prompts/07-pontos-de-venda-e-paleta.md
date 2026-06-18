Ah, perfeito! Peço desculpas pelo deslize na interpretação. Entendi perfeitamente agora: não são apenas "endereços próprios", mas sim as lojas parceiras/revendedoras vinculadas que revendem os seus cosméticos naturais.

Ajustei o prompt para focar exatamente nessa proposta de Lojas Vinculadas, mantendo o padrão arquitetural (AJAX, SoftDeletes, Componentes) e aplicando a nova paleta de cores exatamente onde você especificou.

Aqui está o prompt corrigido para você enviar para o Cursor AI:

Contexto: Lojas Vinculadas (Revendedoras) e Nova Identidade Visual
Objetivo
Expandir o sistema adicionando um novo módulo para gestão de Lojas Vinculadas / Parceiras (estabelecimentos físicos físicos que revendem os cosméticos da marca). Além disso, a identidade visual de todo o projeto (Admin e Vitrine Pública) deve ser atualizada para a nova paleta de cores premium, refletindo uma estética off-white e natural.

Tarefa 1: Nova Paleta de Cores (Global)
Atualizar as variáveis CSS (:root) nos arquivos de layout/estilo global (layouts/app.blade.php e layouts/admin.blade.php) com os novos códigos hexadecimais:

CSS
:root {
  --primary: #76877D;       /* Cor principal da marca */
  --secondary: #96958A;     /* Títulos e elementos institucionais */
  --accent: #88B8A9;        /* Destaques e CTAs (Botões de conversão) */
  --border-soft: #B2CBAE;   /* Bordas suaves */
  --light: #F8F6F0;         /* Fundo principal (off-white premium) */
  --dark: #2B2B2B;          /* Textos de leitura */
}

Regras de UX com a Nova Paleta:

O background geral (body) da vitrine e do admin deve adotar o --light.

Os títulos das seções e elementos institucionais devem usar --secondary.

Botões de conversão (WhatsApp, Instagram, links externos) devem usar o --accent com hover suave.

Cards e divisores devem usar --border-soft para marcações sutis.

Tarefa 2: Modelagem e Banco de Dados (LojaVinculada)
Criar a Migration, Model e Factory para a entidade LojaVinculada.

Entidade: LojaVinculada
Campos:

id

nome (string - Ex: "Espaço Boho Cosméticos", "Farmácia Naturalle")

endereco (string)

cidade (string)

estado (string, 2 subcaracteres - Ex: "SP", "RJ")

telefone (string, nullable)

instagram (string, nullable - @ da loja parceira)

link_google_maps (string, nullable)

ativo (boolean, padrão true)

criado_em / atualizado_em (timestamps)

Regras:

Utilizar SoftDeletes no Model.

Criar Factory para gerar dados de teste.

No DatabaseSeeder, incluir a criação de pelo menos 3 lojas vinculadas ativas por padrão.

Tarefa 3: Backend Administrativo (CRUD Assíncrono)
Seguir rigorosamente o padrão dos CRUDs anteriores:

Controller: Criar App\Http\Controllers\Admin\LojaVinculadaController (Resource).

Rotas: Mapear dentro do grupo /admin protegido pelo middleware auth.

Views (Admin):

Criar a estrutura em resources/views/admin/lojas-vinculadas/ (index.blade.php, create.blade.php, edit.blade.php).

Reutilizar os componentes Blade de tabelas, modais e formulários.

Comportamento AJAX:

Toda a persistência (salvar, atualizar, deletar) e paginação deve ser feita via AJAX (fetch/axios) sem reload da página, retornando respostas em JSON com feedbacks de sucesso/erro estilizados na nova paleta.

Tarefa 4: Exibição na Vitrine Pública (Home)
Exibir a rede de lojas parceiras na página inicial para que os clientes saibam onde encontrar os produtos fisicamente.

HomeController:

Atualizar o método index para recuperar as lojas ativas: LojaVinculada::where('ativo', true)->get().

Enviar a coleção para a view da Home.

View (home.blade.php):

Criar uma seção institucional chamada "Onde Nos Encontrar" ou "Lojas Vinculadas".

Estilizar a seção usando a tipografia baseada na cor --secondary.

Exibir as lojas em um grid responsivo (Mobile First) contendo:

Nome da loja parceira.

Endereço completo, Cidade e Estado.

Se houver instagram, exibir o link com o @ estilizado com a cor --primary.

Botão/Link externo "Como Chegar" (usando a cor --accent), abrindo o link_google_maps em nova aba (target="_blank"), caso esteja preenchido.

Regras Gerais
Não afetar ou misturar a lógica de tracking de cliques de produtos (WhatsApp/Instagram) criada nos prompts anteriores com os links externos das lojas vinculadas.

O layout deve se manter minimalista, limpo e focado na nova estética natural trazida pelas cores.