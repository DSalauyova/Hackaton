pour la connexion a la db, indiquer le chemin complet :
mysql -u root -p -h 127.0.0.1 -P 3306

pour utiliser lse commandes comme make:xxxx : composer require symfony/maker-bundle --dev

obligatoire :
eraseCredentials(), getUserIdentifier() et toutes les methodes de UserInterface;

composer require --dev orm-fixtures
composer require fakerphp/faker

creation d'une contrainte GitHub dans le src/Validator/Constraints/
+entité +fixtures
ajouter la contrainte dans l'entité user
! pas de setter pour les contraintes

composer require symfony/form pour les formulaires  

FORM
npm install bootstrap
npm install bootswatch
creer le fichier CSS : touch assets/css/app.scss  # ou app.css si vous n'utilisez pas SCSS/SASS

Configuration de Webpack Encore pour la partie css
yarn add @symfony/webpack-encore --dev
npm install
ls node_modules/.bin
npm install webpack-notifier@^1.15.0 --save-dev
npm install sass-loader@^14.0.0 sass --save-dev

.enableSassLoader() -> Encore (webpack.config.js)
cmd : npx encore dev

twig : 
autocomplete : activer Emmet 
    "emmet.includeLanguages": {
        "twig": "html"
    },
    "files.associations": {
        "*.twig": "html"
    },

config d Auth :    
in security.yaml : 
providers:
        app_login:
            entity:
                class: App\Entity\User
                property: email
in UserAuthentificatorAuthenticator : 
indiquer identificateur unique => $email = $request->request->get('email');

$request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
        )

make:registration-form : Génère un formulaire d'inscription pour les utilisateurs, y compris le contrôleur et le template.