## CPE – Techniques de l’Internet Dynamique et

## Architecture Logicielle

# Travaux pratiques : sujet « fil

- Yannick Joly – 21 mars rouge »
- 1 Résumé des instructions Table des matières
   - 1.1 Approche guidée
   - 1.2 Approche libre
   - 1.3 Règle pour tous
- 2 Cahier des charges des TPs
   - 2.1 Motivations pédagogiques sur le choix du sujet d’étude
   - 2.2 Présentation générale du sujet d’étude
   - 2.3 Contraintes techniques
   - 2.4 Contraintes de réalisation
   - 2.5 Fonctionnalités à implémenter
- 3 Première ébauche statique du site
   - 3.1 Méthodologie
   - 3.2 Travail à réaliser
   - 3.3 Ne pas oublier...
- 4 Réalisation du site dynamique avec PHP
   - 4.1 Rendu côté serveur : templating
   - 4.2 Formulaire : filtres et connexion
   - 4.3 Accès à la base de données avec PDO
   - 4.4 Architectures de code
   - 4.5 API REST


## 1 Résumé des instructions Table des matières

### 1.1 Approche guidée

1. **Ébauche du site (maximum 4h)** : lecture du cahier des charges, réalisation de
    **maquettes** en dessin puis ébauche en HTML/CSS (sera peaufiné au fur et à mesure
    par la suite).
2. **Dynamisation du site (au moins 12h)** :
    2.1 accès aux données en BDD;
    2.2 mise en place d’une architecture de code (SEP/routage, MVC);
    2.3 utilisation du templating : transformation des maquettes HTML en templates.
3. **Mise en place d’une API REST (au moins 4h)** : côté serveur et consommation
    côté client (JavaScript).

### 1.2 Approche libre

Si vous avez des bases en web dynamique, sentez-vous libres d’aborder le sujet dans
l’ordre que vous voulez. L’objectif est d’apprendre et de progresser tout en renforçant les
bases que vous avez. Mais ça ne vous dispense pas de **lire l’ensemble du sujet**!

Dans tous les cas, discutez d’abord de votre organisation avec un enseignant, qui
pourra vous aider à déterminer quels objectifs et quelle organisation vous fixer et que ce
soit en rapport avec les objectifs pédagogiques (cf fiche d’auto-évaluation).

Pour les plus à l’aise, il faudra par exemple essayer de concevoir et réaliser une API
RESTful, et de reposer l’intégralité des interfaces utilisateurs sur cette API.

### 1.3 Règle pour tous

1. Aucune bibliothèque, aucun framework n’est autorisé (ni en JavaScript, ni côté Ser-
    veur en PHP), en dehors du moteur de template.
2. Pour le moteur de template : Smarty ou Twig sont fortement conseillés. Pour tout
    autre moteur, demander la validation d’un enseignant.
3. Pas d’attente forte côté HTML/CSS : vous êtes autorisés à utiliser des bibliothèques
    externes (Bootstrap, etc.), pas besoin de faire quelque chose de joli. Il faut juste
    respecter les standards et fournir un code **valide et accessible** (utilisez des vali-
    dateurs de HTML, de CSS et d’accessibilité!)


## 2 Cahier des charges des TPs

### 2.1 Motivations pédagogiques sur le choix du sujet d’étude

Le sujet d’étude que nous vous proposons pourra vous sembler étrange : il s’agira
en effet de travailler pour une association d’acupuncteurs en médecine traditionnelle
chinoise.

Dans votre vie professionnelle, il vous sera très souvent demandé en tant qu’informa-
ticien de proposer des solutions pour des sujets d’étude dont vous ignorez complètement
les périmètres. Aussi, il nous a semblé pertinent de vous confronter à un problème dont
le sujet d’étude sera pour la très grande majorité (voire la totalité) d’entre vous complè-
tement nouveau.

Sachez toutefois que les données que vous utiliserez sont des données réelles.
Certains aspects de la base de connaissance ont toutefois été simplifiés, afin de ne
pas complexifier outre mesure la prise en main du contexte d’étude.

Un autre intérêt est que ce problème a réellement été posé : même si le cahier des
charges a été (très) allégé, il correspond à une vraie demande de la part de vrais acu-
puncteurs.

Enfin, que l’on y croit ou non, de nombreux symptômes ainsi que leurs associations
sont plutôt amusants voire parfois déroutants. Cela vous encouragera à vérifier l’exhaus-
tivité de vos requêtes... et sera peut-être un moyen de vous faire sourire en TP et/ou de
détendre l’atmosphère!

### 2.2 Présentation générale du sujet d’étude

L’association des acupuncteurs soucieux de l’accessibilité (AAA...) vous a sollicité pour
la conception et la réalisation d’une plateforme en ligne dont les principales fonctionna-
lités seraient·

1. de disposer d’un service en ligne leur permettant de consulter la liste des symp-
    tômes des principales pathologies en acupuncture (voir table 2.1);
2. de pouvoir n’afficher que certaines des pathologies en fonction de différents critères
    (type de pathologie, choix des méridiens^1 , etc., voir la table 2.2);
3. de rechercher les pathologies comportant certains symptômes.
1. un méridien en acupuncture est un chemin composé de différentes branches lié à un organe, à un
viscère ou à un « merveilleux vaisseau ». Sa partie superficielle contient les fameux « points » d’acupuncture
que les praticiens poncturent, chauffent ou massent. Les différentes branches des chemins n’empruntent
pas forcément des trajets anatomiques ou physiologiques, ce qui est l’un des mystères que la médecine
occidentale n’a pas encore pu expliquer scientifiquement.


```
Catégorie de pathologie Caractéristiques pos-
sibles
```
```
exemple
Pathologies de méridien
```
- interne
- externe
    - méridien du poumon interne
    - méridien du rein externe

```
Pathologies d’organe/viscère (tsang/fu)
```
- plein
- vide
- chaud
- froid
    - poumon vide
    - poumon froid
    - rate vide et froid
    - foie chaud

```
Pathologies des tendino–musculaires (jing jin) néant jing jin du rein
Pathologie des branches (voies luo)
```
- vide
- plein
    - voie luo du poumon vide
    - voie luo du rein pleine

```
Pathologies des merveilleux vaisseaux néant pathologie du Ren Mai
```
Table 2.1 – _Types de pathologies en acupuncture. Il existe d’autres types de pathologies
qui ne seront pas utilisées dans l’application, et qui ne figurent pas dans la base de
connaissances fournie._

```
Critère valeurs possibles exemple
Méridien Nom du méridien (20 méridiens en tout) Poumon, Ren Mai, rein, Yanq Qiao Mai
Type de pathologie méridien, organe/viscère, luo, mer-
veilleux vaisseaux, jing jin
```
```
sélectionner les pathologies voie luo
```
```
Caractéristiques plein, chaud, vide, froid, interne, externe sélectionner les pathologies de vide
```
Table 2.2 – _Critères pour les filtres. Les filtres peuvent se combiner : sélectionner les
pathologies de méridien, interne, pour poumon et foie_

### 2.3 Contraintes techniques

```
2.3.1 Accessibilité et versions HTML
```
- L’ensemble du site respectera les normes d’accessibilité de niveau AAA.
- Il sera écrit en HTML 5.
- De plus, toute page du site devra être accessible de la page d’accueil en 3 interac-
    tions au maximum (clic, raccourci, etc.).
- La navigation devra être possible sans souris ou sans clavier.

```
2.3.2 Environnement d’exécution
```
Le site devra être affichable et utilisable à partir d’une version de Firefox de moins de
deux ans.


La partie dynamique (serveur) devra fonctionner sur une architecture **Linux/Apache/-
PHP/PostgreSQL**.

Toutefois, vous restez libres des outils et environnements de développement que vous
souhaitez utiliser pour arriver à ce résultat.

```
2.3.3 Base de connaissances
```
La base de connaissances vous est fournie sous la forme d’un script SQL de génération
de base de données.

Vous ne pouvez en aucun cas modifier les tables de cette base, mais vous êtes libres
d’ajouter de nouvelles tables si vous en avez besoin.

La base de connaissance a été réalisée à partir du Vademecum d’acupuncture tradi-
tionnelle de Jean Motte.

```
2.3.4 Graphisme
```
La partie graphique doit avant tout éviter les erreurs d’accessibilité et d’ergonomie.
Il ne vous est pas demandé de faire un site esthétiquement joli, mais simple et fonc-
tionnel. Vous pourrez améliorer cet aspect en fin de module s’il vous reste du temps.

### 2.4 Contraintes de réalisation

```
Toutes les pages doivent être consultables en basse résolution.
```
```
2.4.1 Page d’accueil
```
```
Elle doit disposer d’un menu et d’un formulaire d’identification pour les utilisateurs.
```
```
2.4.2 Autres pages
```
L’organisation des autres pages (nombre, architecture, etc...) dépendra des fonction-
nalités à implémenter et de l’interprétation que vous en aurez.

Pensez à inclure à votre projet un **README**. **md** présentant les développements que
vous avez réalisés, vos sources, les auteurs, ainsi que les ressources bibliographiques et
la webographie que vous avez utilisé.


### 2.5 Fonctionnalités à implémenter

C’est à vous de **concevoir la liste des pages de votre application, la navigation
et les interactions entre elles**. Ce qui suit vise à guider votre approche et s’assurer
que vous couvriez le plus important, mais ça ne doit en rien limiter votre travail.

```
2.5.1 Consultation des pathologies
```
Vous réaliserez une première interface permettant d’afficher la liste des pathologies.
Déterminez les infos pertinentes à afficher : il ne faut pas trop charger l’interface.

```
2.5.2 Détails d’une pathologie et symptômes associés
```
Dans un second temps, il faut pouvoir afficher les détails d’une pathologie ainsi que la
liste de symptômes qui lui sont liés.

```
Commment faire le lien entre cette nouvelle interface et la précédente?
```
```
2.5.3 Critères de filtrage des pathologies
```
La liste de pathologies pourra faire l’objet de filtrages comme indiqué en 2.2 Présen-
tation générale du sujet d’étude.

Vous vous efforcerez d’optimiser au maximum votre solution en limitant autant que
possible les requêtes sur le serveur de base de données. Mais le filtrage devra tout de
même être **réalisé côté serveur** , pas en JavaScript.

```
Vous êtes totalement libres dans le choix de l’interface graphique.
```
```
2.5.4 Recherche de pathologies par mot–clef
```
Vous implémenterez une fonctionnalité de recherche de pathologie par mot–clef. Les
mot–clefs sont associés aux symptômes dans la base de connaissance.

```
Cette fonctionnalité ne sera accessible qu’aux utilisateurs authentifiés.
```
```
2.5.5 Compte utilisateur
```
Vous proposerez un système de gestion des utilisateurs (connexion, session, etc.).
Un utilisateur connecté aura la possibilité d’accéder à la fonctionnalité de recherche
de pathologies par mot–clef (cf. 2.5.4).

```
Les plus avancés pourront implémenter aussi l’inscription, mais ça n’est pas prioritaire.
```

## 3 Première ébauche statique du site

```
Durée maximale : 3h, il faut passer à la suite avant la 2èmeséance.
```
### 3.1 Méthodologie

La méthodologie a été présentée en cours. Vous pouvez si vous le souhaitez l’adapter
à vos besoins, en imaginer une qui vous parle plus, etc.

### 3.2 Travail à réaliser

1. **Constituez–vos équipes**
2. **Lisez le cahier des charges** et appropriez-vous le **modèle de données** (voir
    schéma de la base de données)!
3. **Réalisez les maquettes « papier–crayon » des pages du site** en appliquant
    la méthode vue en cours, ou une méthode équivalente.
    Vous penserez à prévoir les réactions aux événements, et prendrez soin de découvrir
    les fonctionnalités nécessaires mais non exprimées directement par le client^2
4. **Réalisez les maquettes statiques (en HTML et CSS) de vos pages.** Vous
    réaliserez notamment les formulaires, qui seront pour le moment passifs (il n’y aura
    pas d’action côté serveur lorsqu’ils seront validés).
5. **Associez les feuilles css demandées**
   . **Attention aux pertes de temps!**

```
HTML et CSS ont été acquis en TLW. Ce n’est pas l’objectif du module TIDAL!
Le temps passe souvent vite quand on cherche à régler de petits détails. C’est
formateur, mais il ne faut pas oublier que vous êtes en temps limité.
```
### 3.3 Ne pas oublier...

- de citer vos sources
- de vérifier que vous avez le droit d’utiliser telle ou telle ressources
- de bien respecter TOUS les termes des licences (citation explicite, etc.)
- de maintenir votre webographie...
2. Ce point, très fréquent, doit normalement faire l’objet d’allers–retours du cahier des charge entre le
demandeur et le réalisateur, puis de validations par le client. Dans le cadre du TP, vous prendrez les initiatives
qui vous semblent pertinentes pour que les fonctionnalités souhaitées soient exhaustivement traitées.


## 4 Réalisation du site dynamique avec PHP

À partir de ce point, il n’y a pas d’ordre « fixe » dans lequel réaliser les choses. C’est
à vous de vous organiser. Certains travaux pourront être parallélisés, mais une mise en
commun finira toujours par être nécessaire.

. **Travail d’équipe**

```
À termes, chaque membre de l’équipe devra comprendre et maîtriser l’inté-
gralité du projet.
Privilégiez des mises en commun fréquentes et du pair programming plutôt
que de travailler chacun dans son coin, au risque de vous rendre compte à la toute
fin que le projet n’est pas fonctionnel!
```
Chacune des sous-parties ci-dessous fera l’objet d’un point de cours ou d’une discus-
sion avec les enseignants.

### 4.1 Rendu côté serveur : templating

L’objectif ici est de convertir les maquettes réalisées avec du HTML pur en des modèles
( _templates_ ) de **vues** dynamiques qui seront générées à la volée par PHP lors de chaque
appel HTTP.

```
Vous allez pour cela vous baser sur un moteur de templates (Twig ou Smarty).
```
. **Dynamise limité**

```
Assurez-vous que le code de vos vues ne comporte que du code dynamique dont
la vocation est l’affichage.
Pas d’accès à la base de données ni de règles métiers ici : ça n’est pas le rôle
d’une vue!
```
### 4.2 Formulaire : filtres et connexion

Il vous faudra réaliser **au moins deux formulaires HTML** destinés à choisir les fil-
trages et recherche sur les pathologies pour l’un, et à la connexion utilisateurs pour
l’autre.

```
Les enjeux ici :
```
1. définir « proprement » les formulaire en HTML, dans le respect des standards et de
    l’accessibilité;
2. déterminer _comment_ les données seront transmises (en suivant la norme HTML);
3. lors de leur soumission, effectuer côté serveur les contrôles nécessaires sur les don-
    nées soumises;


4. pour chaque formulaire : faire le lien avec les données (voir partie ci-dessous);
5. dans le cadre de la connexion, gérer la persistance de la session utilisateur.

### 4.3 Accès à la base de données avec PDO

Commencez par prendre en main le modèle de données et la BDD. Déterminez les
requêtes SQL qui vous seront utiles (vous pouvez les tester dans pgAdmin avant de les
intégrer à votre code).

. **Sécurité**

```
Un compte utilisateur, même s’il est destiné à être utilisé par une application (on
parle alors d’ utilisateur applicatif ou app user ) doit toujours se voir attribuer des
droits d’accès les plus limités possibles.
Déterminés quels sont droits nécessaires à votre utilisateur applicatif et mettez-
les en oeuvre.
De plus, veillez à appliquer les principes d’usages sécurisés de PDO abordés en
point de cours.
```
### 4.4 Architectures de code

Appliquez-vous à structurer votre code le plus possible et le plus proprement possible.
Cela jouera un rôle important dans l’évaluation de votre travail.

Certaines techniques vous seront enseignées, mais à vous de pousser la démarche
plus loin en gardant une bonne vision d’ensemble sur votre projet.

```
Une liste non exhaustive :
```

1. emploi d’un **point d’entrée unique** et **routage** associé;
2. utilisation d’un **patron d’architecture** comme MVC;
3. une **arborescence des fichier** réfléchie : reflet de la structure de votre code;
4. projet en « **tout objet** » (éviter les scripts et ne réaliser quasi que des classes);
5. tout emploi de _design pattern_ pourra être valorisé **s’il est employé pour des rai-**
    **sons pertinentes**.

### 4.5 API REST

L’objectif ici est de réaliser **au moins un** **_endpoint_** **d’API REST** en respectant les
principes de cette architecture (un cours dédié vous sera dispensé), et de le consommer
en JavaScript avec **fetch** ().

Vous pouvez choisir de réaliser une partie du projet en REST, voir l’intégralité du projet
(vous veillerez à conserver au moins quelques éléments dynamiques reposant sur le
_templating_ malgré tout).

Une autre possibilité est de reproduire avec REST et JavaScript une fonctionnalité que
vous aurez préalablement implémentée avec l’approche classique de rendu côté serveur
et de _templating_. Par exemple, la liste des pathologies.


