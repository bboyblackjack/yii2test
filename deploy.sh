docker compose up --build -d
docker exec -it ops_php php init --env=Development --owerwrite=all
docker exec -it ops_php composer install
docker exec -it ops_php php yii migrate --interactive=0