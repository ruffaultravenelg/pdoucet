# Site Web de M. Pascal Doucet

Ce projet utilise le framework Symfony.

## Guide d'installation

1. **Créer la base de données :**
    ```sh
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
    ```

2. **(Facultatif) Importer les fixtures pour les tests :**
    ```sh
    php bin/console doctrine:fixtures:load
    ```

3. **Mettre à jour le contenu (textes statique) et les paramètres du site :**
    ```sh
    php bin/console refresh:content
    php bin/console refresh:settings
    ```
    Cette opération conserve les valeurs existantes.

4. **Configurer le fichier `.env` :**
    ```sh
    # "dev" ou "prod"
    APP_ENV=
    
    # Mot de passe administrateur principal
    ADMIN_PASS=
    ```