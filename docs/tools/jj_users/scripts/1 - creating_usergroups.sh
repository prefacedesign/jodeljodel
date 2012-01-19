<?php
# Creating the groups
./cake jodel_user group_add "Todos os usuários" all_users -no-parent
./cake jodel_user group_add "Administradores" admin all_users
./cake jodel_user group_add "Editores" editors admin
./cake jodel_user group_add "Redatores" redators admin
./cake jodel_user group_add "Técnicos" techies admin
./cake jodel_user group_add "Superusuarios" superusers admin

# Creating the users
./cake jodel_user add "Lucas Vignoli" lucas@preface.com.br "1234" techies
./cake jodel_user add "Daniel Abrahao" lucas@preface.com.br "1234" techies
./cake jodel_user add "Super-usuario" preface@preface.com.br "1234" superusers
./cake jodel_user add "Teste de Redator" redator@preface.com.br "1234" redactors
