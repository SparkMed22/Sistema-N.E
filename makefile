MYSQL_CONTAINER=mysql_external

DB_HOST=$(shell grep DB_HOST .env | cut -d '=' -f2)
DB_NAME=$(shell grep DB_NAME .env | cut -d '=' -f2)
DB_USER=$(shell grep DB_USER .env | cut -d '=' -f2)
DB_PASS=$(shell grep DB_PASS .env | cut -d '=' -f2)
DB_PORT=$(shell grep DB_PORT .env | cut -d '=' -f2)

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart

logs:
	docker compose logs --tail 0 -f

setup:
	docker compose up -d --build
	docker exec sistema_ne_app composer install
	docker compose exec app composer require respect/validation

mysql-local:
	@mysql -h $(DB_HOST) -P $(DB_PORT) -u $(DB_USER) -p'$(DB_PASS)' $(DB_NAME)

mysql-docker:
	@docker exec -it $(MYSQL_CONTAINER) mysql -h localhost -P 3306 -u $(DB_USER) -p'$(DB_PASS)' $(DB_NAME)

help:
	@echo "Comandos disponibles:"
	@echo "  make setup       - Iniciar contenedor, Vendor, composers (Solo la primera vez)"
	@echo "  make up          - Levantar el servidor"
	@echo "  make down        - Apagar el servidor"
	@echo "  make restart     - Reiniciar el servidor"
	@echo "  make logs        - Ver logs"
	@echo "  make mysql-local - Entrar a MySQL (requiere cliente instalado)"
	@echo "  make mysql-docker- Entrar a MySQL usando Docker (recomendado)"
