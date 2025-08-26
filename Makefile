# Makefile for Laravel Docker setup

# Переменные
ENV_DIR=environment
DOCKER_COMPOSE=docker compose -f $(ENV_DIR)/docker-compose.yml
APP_CONTAINER = app

# Билд образов
build:
	$(DOCKER_COMPOSE) build

# Запуск контейнеров в detached mode
up:
	$(DOCKER_COMPOSE) up -d

# Остановка и удаление контейнеров
down:
	$(DOCKER_COMPOSE) down

# Открытие bash оболочки в app контейнере
bash:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) bash

# Просмотр логов (follow)
logs:
	$(DOCKER_COMPOSE) logs -f

# Полная перестройка: down, build, up
rebuild: down build up


artisan:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan $(filter-out $@,$(MAKECMDGOALS))

%:
	@:

.PHONY: build up down bash logs rebuild artisan