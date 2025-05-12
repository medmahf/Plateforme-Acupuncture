# Documentation de la page patho.twig

## Rôle

La page `patho.twig` est la vue principale pour la consultation des pathologies sur la plateforme. Elle propose deux modes d’affichage : 
- **Approche classique** (rendu côté serveur avec Twig/PHP)
- **Approche dynamique REST/JS** (chargement via API REST et JavaScript)

---

## Fonctionnalités proposées

### 1. Affichage classique (Twig/PHP)
- Affiche la liste des pathologies reçue du contrôleur PHP.
- Permet de filtrer la liste par :
  - **Type** (select dynamique)
  - **Méridien** (select dynamique)
  - **Caractéristiques** (mot-clé, champ texte)
- Affiche un lien vers le détail de chaque pathologie.
- Affiche un formulaire de recherche par mot-clé (accessible uniquement aux utilisateurs connectés).
- Affiche les résultats de la recherche ou du filtrage côté serveur.

### 2. Affichage dynamique (REST/JS)
- Un bouton permet d’activer l’affichage dynamique.
- Utilise `fetch()` pour appeler l’API REST (`api.php?ressource=pathologies`).
- Affiche la liste des pathologies reçue en JSON, sans recharger la page.
- Permet de comparer l’approche classique et l’approche REST/JS sur la même page.

---

## Expérience utilisateur
- Navigation clavier et accessibilité assurées (labels, focus, aria-labels).
- Affichage conditionnel des fonctionnalités selon l’état de connexion (recherche par mot-clé).
- Possibilité de basculer entre affichage classique et dynamique à tout moment.

---

## Exemple de structure (simplifiée)
```twig
<h1>Liste des pathologies</h1>
<!-- Bouton pour affichage dynamique -->
<button id="toggle-api-view">Afficher dynamiquement via l'API REST</button>
<div id="api-patho-list" style="display:none;">
    <ul id="api-patho-ul"></ul>
</div>
<!-- Formulaire de filtres -->
<form> ... </form>
<!-- Formulaire de recherche par mot-clé (si connecté) -->
<form> ... </form>
<!-- Liste classique Twig -->
<ul>
    {% for item in data %}
        <li>{{ item.desc }} ...</li>
    {% endfor %}
</ul>
```

---

## Bonnes pratiques
- Les deux approches coexistent sans se gêner.
- Le code JS est encapsulé et n’interfère pas avec le rendu Twig.
- Les filtres et la recherche sont accessibles et utilisables dans les deux modes.

---

## Extension possible
- Ajouter le filtrage dynamique côté JS (en passant les filtres à l’API REST).
- Ajouter la pagination côté serveur et côté REST/JS.
- Ajouter un affichage dynamique du détail d’une pathologie via l’API.
