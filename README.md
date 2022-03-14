# singwar

1. Clonar proyecto
2. Instalar proyecto -> composer install
3. Descargar imágenes y levantar contenedores (necesario docker y docker-compose) -> sudo docker-compose up -d
4. Comprovar contenedores Ok php, web y signwar_db  -> sudo docker ps -a
5. Ejecutar migraciones de BBDD -> sudo docker exec -ti php php ./bin/console doctrine:migrations:migrate
6. Decir que si a la pregunta
7. Migraciones con éxito
8. Tablas creadas: actor, contract, party, trail
9. Ayuda desde consola -> sudo docker exec -ti php php ./bin/console signwar:play --help
10. Probar desde consola fase 1  ->  sudo docker exec -ti php php ./bin/console signwar:play --toPlay
11. Probar desde consola fase 2  ->  sudo docker exec -ti php php ./bin/console signwar:play --toWin
12. Probar desde http -> hacer post a la url signwar.localtest.me/api/signwar/play 

      con body-raw = 
                        {
                            "party1" : {
                                "rol" : "plaintiff",
                                "sign" : "NKN"   
                            },
                            "party2" : {
                                "rol" : "defendant",
                                "sign" : "NNN"   
                            }
                        }


13. Probar desde http -> hacer post a la url signwar.localtest.me/api/signwar/win 

      con body-raw = 
                        {
                            "party1" : {
                                "rol" : "plaintiff",
                                "sign" : "N#N"   
                            },
                            "party2" : {
                                "rol" : "defendant",
                                "sign" : "NNN"   
                            }
                        }

