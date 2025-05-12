# Documentation : Table utilisateurs et gestion des droits PostgreSQL

## Contexte

Cette documentation explique comment créer la table `utilisateurs` pour l’application, et comment accorder les droits nécessaires à l’utilisateur applicatif PostgreSQL afin de permettre l’inscription et la gestion des comptes sur le site.

---

## Création de la table `utilisateurs`

```sql
CREATE TABLE IF NOT EXISTS utilisateurs (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dernier_acces TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    etat VARCHAR(50) DEFAULT 'actif'
);
```

---

## Gestion des droits dans pgAdmin

1. Ouvre pgAdmin et connecte-toi à ta base.
2. Navigue dans l’arborescence : Bases de données > ta base > Schémas > Tables > `utilisateurs`
3. Clique droit sur la table `utilisateurs` > Propriétés > Sécurité > Privilèges.
4. Ajoute l’utilisateur applicatif (ex : `acu`) si besoin, et coche SELECT, INSERT, UPDATE.
5. Enregistre.

---

## À propos de la séquence

> Donner les droits INSERT sur la table ne donne pas automatiquement le droit d’utiliser la séquence associée (ici `utilisateurs_id_seq`).
> La séquence est utilisée pour l’auto-incrémentation de la colonne `id` lors des INSERT.

---

## Script SQL complet pour l’utilisateur applicatif

```sql
-- Création de l’utilisateur applicatif (ex : acu)
CREATE USER acu WITH PASSWORD 'motdepasse';

-- Droits sur la table
GRANT SELECT, INSERT, UPDATE ON TABLE utilisateurs TO acu;

-- Droits sur la séquence (indispensable pour les INSERT)
GRANT USAGE, SELECT ON SEQUENCE utilisateurs_id_seq TO acu;
```

---

## Vérification des droits sur la séquence

Pour vérifier les droits sur la séquence, exécute :
```sql
\dp utilisateurs_id_seq
```

---

## Bonnes pratiques
- N’utilise jamais le superutilisateur PostgreSQL pour l’application.
- Limite les droits de l’utilisateur applicatif au strict nécessaire (SELECT, INSERT, UPDATE sur les tables, USAGE/SELECT sur les séquences).
- Après chaque modification de la structure (nouvelle table ou séquence), pense à accorder les droits nécessaires.

---

## Résumé
- Le droit INSERT sur la table ne suffit pas, il faut aussi donner USAGE/SELECT sur la séquence.
- Après ce GRANT, l’inscription et la gestion des utilisateurs fonctionneront sans erreur de privilège.