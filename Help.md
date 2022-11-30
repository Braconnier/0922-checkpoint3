# Commandes utiles

###### **PHP/SYMFONY/DOCTRINE**

---

## Passage des tests de code-quality avant commit / push

### Dans un projet comportant la suite grumphp

- Executer la commande :

```
php ./vendor/bin/grumphp run
```

---

## **Preparation de la Bdd** (Symfony/Doctrine)

### Ajouter à composer.json -> scripts :

```
,
    "prepare-db": [
    "php bin/console d:d:d --if-exists --force",
    "php bin/console d:d:c",
    "php bin/console d:m:m -n",
    "php bin/console d:f:l --append"
```

- Executer la commande :

```
composer prepare-db
```

---

## **Lancement de symfony http (no-tls)**

- Executer la commande :

```
symfony server:start --no-tls
```

---

## **Lancement de webpack sans overlay warnings Bootstrap**

- Executer la commande :

```
yarn dev-server --no-client-overlay-warnings
```

---

## **Lancement des mises à jour des dépendences composer**

- Executer la commande :

```
composer install
```

---

## **Lancement des mises à jour des dépendences yarn**

- Executer la commande :

```
yarn
```

---
