#!/bin/bash

# Creating the permissions
./cake jodel_new_user permission_add "Ver rascunhos" view_drafts
./cake jodel_new_user permission_add "Dashboard" dashboard
./cake jodel_new_user permission_add "Bastidores" backstage
./cake jodel_new_user permission_add "Visualizacao de itens" backstage_view_item
./cake jodel_new_user permission_add "Edicao de itens em rascunho" backstage_edit_draft
./cake jodel_new_user permission_add "Exclusao de itens" backstage_delete_item
./cake jodel_new_user permission_add "Mudar status (rascunho/publicado)" backstage_edit_publishing_status
./cake jodel_new_user permission_add "Edicao de itens publicados" backstage_edit_published
./cake jodel_new_user permission_add "Lista de usuarios" user_list
./cake jodel_new_user permission_add "Adicao de usuarios" user_add
./cake jodel_new_user permission_add "Edicao de usuarios" user_edit
./cake jodel_new_user permission_add "Exclusao de usuarios" user_delete
./cake jodel_new_user permission_add "Arvore de permissoes" user_permission_tree


# Creating the profiles
./cake jodel_new_user profile_add "Tecnico" techie

# Creating the relations
./cake jodel_new_user profile_permission techie view_drafts dashboard backstage backstage_view_item backstage_edit_draft backstage_delete_item backstage_edit_publishing_status backstage_edit_published user_list user_add user_edit user_delete user_permission_tree

# Creating the users
./cake jodel_new_user add "Super-usuario" preface@preface.com.br "123456" techie


# Adding permission to profiles
# ./cake jodel_new_user profile_permission_add "profile_wanted" new_permission_to_add

# Adding profiles to users
# ./cake jodel_new_user user_profile_add "preface@preface.com.br" profile_wanted