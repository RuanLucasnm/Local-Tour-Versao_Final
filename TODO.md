# TODO
- [x] Implementar detecção automática de banco no `config/database.php`: se `database/database.sqlite` existir e `DB_CONNECTION` não estiver definido no `.env`, usar `sqlite`.
- [ ] (Opcional) Atualizar `SETUP.md` com nota sobre uso automático do SQLite quando `database.sqlite` existir.
- [x] Rodar testes locais: `php artisan config:clear` e `php artisan migrate:fresh --seed`.


# Features do usuário (implementação total, organizada)
- [x] (1) Catálogo: siglas universais (Niterói - RJ) + filtro/ordenação por sigla (RJ) e não por nome.
- [x] (2) Pacotes: suporte a múltiplas imagens (upload + persistência) e renderização no catálogo e detalhes.
- [x] (3) Catálogo: animação leve e lenta de transição horizontal automática quando houver mais de 1 imagem.
- [x] (4) Admin: sessão completa para CRUD de Cidades e Transportes.
- [x] (5) Promoções + Cupons: criar cupons com desconto percentual/valor fixo, associar a pacotes específicos e aplicar no carrinho.
- [x] (6) Avaliações: moderação admin (tela funcional + ações) e validações/checagens.



- [x] (7) Revisões finais: validações, consistência de rotas, rodar `migrate:fresh --seed` e garantir que tudo sobe.



