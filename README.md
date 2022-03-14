# singwar

1. Clonar proyecto![1-proyecto_descargado_instalado]
 (https://user-images.githubusercontent.com/18306401/158255488-94f5ba5a-31e3-44e3-8a21-4fe8d32eb451.png)


2. Instalar proyecto -> composer install


. Descargar images y levantar containers (docker y docker-compose instalados)-> sudo docker-compose up -d
5. Comprobar contenedores Ok php, web y signwar_db  -> sudo docker ps -a
6. Ejecutar migraciones de BBDD -> sudo docker exec -ti php php ./bin/console doctrine:migrations:migrate
7. Decir que si a la pregunta
8. Migraciones con éxito
9. Tablas creadas: actor, contract, party, trail
10. Ayuda desde consola -> sudo docker exec -ti php php ./bin/console signwar:play --help
11.Probar desde consola fase 1  ->  sudo docker exec -ti php php ./bin/console signwar:play --toPlay
12.Probar desde consola fase 2  ->  sudo docker exec -ti php php ./bin/console signwar:play --toWin

# Para probar por http se adjunta postman collection. (signwar.postman_collection.json) 

Se adjunta además .zip con imágenes
del proceso de consola. No hay interface web.

12. Probar desde http fase 1 -> hacer post a la url signwar.localtest.me/api/signwar/play 

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


13. Probar desde http fase 2 -> hacer post a la url signwar.localtest.me/api/signwar/win 

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
                        
                        

