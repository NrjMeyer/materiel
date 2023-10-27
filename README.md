# Gestion de matériel via API

Les étapes à faire pour lancer le projet

### Cloner ce repo et faire la commande suivante:
```bash
composer install
```
### Configurer votre base de donnée dans le fichier .env puis:
```bash
php bin/console doctrine:migrations:migrate

```
### Pour lancer le projet dans localhost:8000
```bash
php -S localhost:8000 -t public
```
### Exemple d'utilisation de l'API
Ajout
```bash
#via postman
methode: POST
url: http://localhost:8000/equipment
{
	"name": "ASUS ROG",
	"category": "laptop",
	"number": "XVD 764 147",
	"description": "Lorem ipsum dolor asit amet"
}
	
	
#via curl 
curl -i -H “Content-Type: application/json” -X POST http://localhost:8000/equipment -d ‘{“name”:”ASUS ROG”,”category”:”laptop”,”number”:”XVD 764 147”,”description”:”Lorem ipsum dolor asit amet”}
```

Modification
```bash
methode: PUT
url: http://localhost:8000/equipment/{id}
```

Suppression
```bash
methode: DELETE
url: http://localhost:8000/equipment/{id}
```

Liste
```bash
methode: GET

#sans filtre
url: http://localhost:8000/equipments

#avec filtre categorie
url: http://localhost:8000/equipments?category=laptop

```

