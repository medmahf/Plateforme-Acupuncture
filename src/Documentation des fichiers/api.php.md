# Documentation du fichier api.php

## Rôle

`api.php` est le point d’entrée de l’API REST de l’application. Il permet d’exposer des données du projet (ex : pathologies) au format JSON, pour être consommées par des clients JavaScript (fetch) ou d’autres applications.

---

## Endpoints disponibles

### 1. Liste des pathologies
- **URL** : `/api.php?ressource=pathologies`
- **Méthode** : GET
- **Description** : Retourne la liste des pathologies, éventuellement filtrée.
- **Paramètres GET optionnels** :
  - `type` : filtre par type de pathologie
  - `mer` : filtre par méridien
  - `carac` : filtre par mot-clé dans la description

**Exemple d’appel** :
```
GET /api.php?ressource=pathologies&type=lp&mer=E
```

**Exemple de réponse** :
```json
[
  {
    "idp": 1,
    "desc": "voie luo du cœur pleine",
    "type": "lp",
    "mer": "C"
  },
  ...
]
```

---

## Gestion des erreurs
- Si la ressource n’existe pas :
  - Code HTTP 404, réponse : `{ "error": "Ressource non trouvée" }`
- Si erreur de connexion BDD :
  - Code HTTP 500, réponse : `{ "error": "Erreur de connexion à la base de données" }`

---

## Sécurité
- L’API ne retourne que des données publiques (aucune donnée sensible).
- Les requêtes sont préparées (pas d’injection SQL possible).
- Les filtres sont optionnels et sécurisés.

---

## Extension possible
- Ajouter d’autres endpoints (ex : détail d’une pathologie, liste des méridiens, etc.)
- Ajouter une authentification pour certains endpoints si besoin.

---

## Utilisation côté client
- L’API est consommée en JavaScript avec `fetch()` pour afficher dynamiquement la liste des pathologies dans la version REST/JS du site.
