app-cli:
	docker-compose -f docker-compose.yml exec app bash

migration:
	docker-compose -f docker-compose.yml exec app php migrations/migration.php
