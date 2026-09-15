# Site de Recettes - Projet PHP

Un projet d'application web dynamique développé en PHP, permettant l'affichage de recettes de cuisine et la gestion d'un espace membre. Ce projet s'inscrit dans le cadre du module d'apprentissage web R301.

## Fonctionnalités principales

*   **Architecture dynamique :** Découpage des pages (header, footer, fonctions) pour un code modulaire et maintenable.
*   **Formulaire de contact sécurisé :** Transmission des données via la méthode `POST`, validation des champs (filtres d'emails) et protection contre les failles XSS (`htmlspecialchars`).
*   **Partage de fichiers :** Système d'upload de captures d'écran sécurisé (vérification du type MIME, limitation à 1 Mo, et renommage automatique pour éviter l'écrasement).
*   **Système d'authentification :** Espace de connexion restreignant l'accès aux recettes pour les visiteurs non identifiés (gestion des accès, préparation pour les sessions et cookies).

## Technologies utilisées

*   **Backend :** PHP
*   **Frontend :** HTML5, CSS3 (Framework Bootstrap 5.0.2)
*   **Environnement :** Serveur Apache (optimisé pour UwAmp) / Git pour le versioning

---
*Développé par Noha Rougé - BUT Informatique (2ème année), IUT de Nevers.*
