# Kamiseta galeria
# Asier Pérez, Oier Cao, Brando Insausti, Uhaitz Errekalde, Bitor Delgado eta Luken Escobero

#Erabiltzeko instrukzioak
1. Web irudia eraiki direktorioan egonda
```
$ docker build -t="web" .
```
2. Zerbitzuen edukiontziak hasi detached moduan
```
$ docker-compose up -d
```
3. img direktorioaren baimenak aldatua argazkiak igotzeko
```
$ sudo chmod 777 app
```
4. Datu basearen dump-a importatu
```
http://localhost:8890/ direkzioan root erabiltzailea eta root pasahitza erabiliz "importar" atalean db.sql fitxategia igo
```
5. Web sisteman sartu
```
http://localhost:81/ direkzioan sartu eta web orrialdea erabili 
```
