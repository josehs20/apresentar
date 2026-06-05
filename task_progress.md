# Setup de Autenticação e Libs - Checklist

- [x] Verificar versões do composer.json (PHP 8.4, Laravel 13.8) — confirmado no composer.json
- [x] Criar arquivo database/database.sqlite — já existe
- [ ] Instalar Laravel Breeze (Blade stack)
- [ ] Publicar views/assets do Breeze
- [ ] Instalar Intervention Image v3
- [ ] Publicar configurações do Intervention Image
- [ ] Executar php artisan storage:link
- [ ] Gerar tabela de filas (queue:table) e migrar
- [ ] Configurar bloqueio da rota /register (após primeiro admin)
- [ ] Criar seeder para criar primeiro usuário administrador
- [ ] Verificar funcionamento final do setup
