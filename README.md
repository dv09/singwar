# singwar

1. Clonar proyecto!
 
2. Instalar proyecto -> composer install 
![1-proyecto_descargado_instalado](https://user-images.githubusercontent.com/18306401/158255488-94f5ba5a-31e3-44e3-8a21-4fe8d32eb451.png)

3. Descargar images y levantar containers (docker y docker-compose instalados)-> sudo docker-compose up -d
![2-levantar_contenedores_db_php_nginx](https://user-images.githubusercontent.com/18306401/158256002-607c8155-b637-4aee-a9e1-28937a36d142.png)
![3-imagenes_descargadas_contenedores-up](https://user-images.githubusercontent.com/18306401/158256103-a0f4ea6e-03af-40bd-b86a-4cb8569a3029.png)

4. Comprobar contenedores Ok php, web y signwar_db  -> sudo docker ps -a
![4-comprova_contenedores_ok](https://user-images.githubusercontent.com/18306401/158256124-780d9ece-4147-4017-b22b-3939f6b2f6ec.png)

5. Ejecutar migraciones de BBDD -> sudo docker exec -ti php php ./bin/console doctrine:migrations:migrate
![5-ejecutar-migration](https://user-images.githubusercontent.com/18306401/158256158-56308105-21b0-4921-90e1-1e3a26e62271.png)

6. Decir que si a la pregunta
![6-yes_a_la_pregunta](https://user-images.githubusercontent.com/18306401/158256183-fc3b6cec-0484-4298-b910-fbb8011f060e.png)

7. Migraciones con éxito
![7-migration_con_exito](https://user-images.githubusercontent.com/18306401/158256233-baa2cf71-a204-475c-bd2c-1d5db7998f9a.png)

8. Tablas creadas: actor, contract, party, trail
![8-tablas_creadas](https://user-images.githubusercontent.com/18306401/158256261-934979e2-4f29-44ab-bab9-f7a5ae542882.png)

9. Ayuda desde consola -> sudo docker exec -ti php php ./bin/console signwar:play --help
![comando_ayuda_desde_consola](https://user-images.githubusercontent.com/18306401/158256701-0ef41679-30e6-410d-b952-a444db6c57f5.png)
![ayuda_desde_consola](https://user-images.githubusercontent.com/18306401/158256683-095208af-126d-4270-9d5b-5f1efc5ed240.png)

10.Probar desde consola fase 1  ->  sudo docker exec -ti php php ./bin/console signwar:play --toPlay
![9 0_fase_1_desde_consola](https://user-images.githubusercontent.com/18306401/158256412-4abac83d-f9fa-47d3-b575-410296e3a47b.png)
![9 1-fase_1_desde_consola](https://user-images.githubusercontent.com/18306401/158256457-d1e070da-20b9-4ce6-a2e2-eafa11cb1080.png)
![9 2-fase_1_desde_consola png](https://user-images.githubusercontent.com/18306401/158256502-25d0febd-6905-489a-85a1-495f5036154f.png)
![9 3-fase_1_desde_consola](https://user-images.githubusercontent.com/18306401/158256604-d0772f01-c83d-4368-8f9d-9322b27cf3bd.png)
![9 4-fase_1_desde_consola png](https://user-images.githubusercontent.com/18306401/158256609-f9617a59-23c8-49df-8648-56aafcef7a34.png)
![9 5-fase_1_desde_consola](https://user-images.githubusercontent.com/18306401/158256618-1769ed78-bdbd-4eb1-a286-91a9de6319ae.png)

11.Probar desde consola fase 2  ->  sudo docker exec -ti php php ./bin/console signwar:play --toWin
![10 0_fase_2_desde_consola](https://user-images.githubusercontent.com/18306401/158256654-21337184-ae4e-4280-bbd4-568fe7f50540.png)
![10 1_fase_2_desde_consola](https://user-images.githubusercontent.com/18306401/158256666-35163058-3dba-4b14-b229-415087c87967.png)

Se adjunta además .zip con imágenes
del proceso de consola. No hay interface web.

# Para probar por http se adjunta postman collection. (signwar.postman_collection.json) 

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
                        
                        

