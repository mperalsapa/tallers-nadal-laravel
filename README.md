# Tallers de nadal

Autor: Marc Peral

Aquest projecte te com a proposit fer servir el framework de php Laravel per generar un portal web on poder crear i apuntar-se a tallers de nadal. Els alumnes i professors podran crear tallers, i una vegada ha passat un periode de temps, es podran apuntar a altres tallers.
Tambe existeix la figura del Super Administrador. Aquesta figura no consta com Alumne o Professor, sino que es per administrar el lloc web i assignar alguns usuaris com administradors.

Aquest projecte te en compte que els tallers de nadal es fan 1 vegada al any (nadal) per lo tant, es tindria en compte un funcionament per etapes, es a dir:
- Insercio de nous usuaris.
    S'haurien d'inserir nous usuaris ja que l'anterior temporada es van esborrar. Aixo es degut a que a l'hora d'assignar tallers s'agafen tots els usuaris de la base de dades.
    Per inserir els usuaris, s'ha d'afegir un fitxer CSV en la ruta tallers-nadal-laravel/storage/usuaris.csv
    El fitxer ha de tenir el seguent nom "usuaris.csv", i ha de tenir el format ```Email,Etapa,Curs,Grup,Cognoms,Nom```, aquest seria un fitxer d'exemple:
    ```
    a.alumne1@sapalomera.cat,ESO,1,A,Cognom1 Cognom1,Nom1
    a.alumne2@sapalomera.cat,ESO,1,C,Cognom2 Cognom2,Nom2
    a.alumne3@sapalomera.cat,ESO,2,A,Cognom3 Cognom3,Nom3
    ```

- Periode de creacio de tallers:
    Usuaris i admins poden crear tallers i modificar-los.

- Periode d'eleccio de tallers: 
    Finalitzat el periode de creacio, comença el de seleccio de tallers. 

    - Usuaris: seleccionen tallers. A l'hora de seleccionar un taller, els alumnes només poden veure tallers que son assignats als seus cursos, mentre que els professors poden veure tots els tallers.

    - Admin: En cas de tenir un taller amb molta demanda i tenim mes recursos per fer un altre, un administrador pot crear mes tallers o clonar-los de tallers existents o del historic.

- Periode final
    - Generacio de seleccions
        - Automatic
        En cas de tenir alumnes que no han generat seleccions, es pot realitzar de manera automatica (tot i que es funcional, s'hauria de realitzar testos per comprovar que sigui 100% util en un entorn real, ja que si es fa servir la generacio automatica, no es pot tornar enrere).
        
        La seleccio automatica no te en compte si hi ha massa seleccions d'un taller. Aixo podria produir un error a l'hora de generar les assignacions, pero com aquest cas podria passar naturalment, no s'ha tingut en compte a l'hora de programar-ho. S'hauria de fer una comprovacio a l'hora de generar les seleccions automatiques.
        
        - Manual
        Tambe existeix la opcio d'anar alumne/professor per alumne/professor afegint/modificant les eleccions de taller, una per una.

    - Generacio d'assignacions
        - Automatic
        La generacio d'assignacions es pot fer automatica, pero requereix que tots els usuaris que son disponibles tinguin les 3 seleccions de tallers, per aquesta rao existeix la generacio de seleccions automatica.
        En cas de no tenir suficients espais en un taller per les seleccions actuals, el sistema ho indicara en un log per que l'administrador canvii manualment. Tambe es podria automatitzar aquesta tasca, pero això s'hauria de fer mes endavant.
        
        - Manual
        De la mateixa manera que amb les eleccions, tambe es pot canviar/afegir l'assignacio del taller d'alumnes/professors
    - Generacio d'informes
        Els informes son generats amb taules en una pagina web. Es presenta un botó que indica "Imprimir" i genera una vista d'impressió amb les taules corresponents amb l'informe generat.
        - Informe de tallers
        Aquest informe genera taules la qual cadascuna es un taller, i les files son els alumnes que han sigut assignats en aquest taller.
        - Informe de material
        Aquest informe genera una llista de tallers amb els corresponents materials.
        - Informe de Usuaris
        Aquest informe genera una llista d'usuaris amb les seves eleccions (1º, 2º, 3º) i la seva assignacio de taller.
    - Emmagatzemament de tallers historics
    Una vegada finalitzada la generacio de informes, podem enviar els tallers a l'historic.
    - Eliminacio de usuaris
    Enviats els tallers al historic, podem esborrar els usuaris i s'hauria completat un cicle.

# Com funciona
## Base de dades
Configurar en el fitxer .env la connexio amb la base de dades.
Executar la seguent comanda per crear les taules a la base de dades i afegir dades inicials per fer una previsualitzacio
```
php artisan migrate:fresh --seed
```
## Domini
L'entorn de desenvolupament fa servir el domini ```dev.tallers-nadal.mperalsapa.cf```, per lo que si es vol fer servir un altre domini, s'ha de canviar en el fitxer .env.

## Inici de sessio amb Google
De la mateixa manera que s'ha de canviar el domini, s'han de canviar les credencials de l'api de Google, i tambe el callback, corresponent al nou domini i a la configuracio de Google.

# Observacions
## Laravel
S'hauria de millorar la manera en la que s'implementa amb laravel.
Per exemple, fer servir el sistema de plantilles mes extensivament. Aplicar conceptes com els "ENUM" en comptes de afegir "hardcoded" certes variables, etc...

## Tallers
Un alumne només pot fer un taller, mentre que un administrador, pot fer mes d'un taller. Aixo es degut a que si ets administrador, has de poder generar duplicats de tallers basats en l'historic. Si no fos així, no es podrien duplicar, només copiarien de l'historic al taller que ja existeix o es crearia un de nou.

Hauria estat be implementar un filtre com el que existeix en el panell d'administracio. Com ja s'ha realitzat una implementacio seria facil copiar i enganxar la implementacio ja existent.

## Historic
Podem crear tallers basats en els que hi ha en l'historic. Tambe podem esborrar tallers de l'historic. Pero no podem modificar-los. Tambe hauria estat be afegir la vista de modificacio.

## Desplegament
Actualment degut a la manca de coneixements amb laravel, no he trobat una manera eficient de desplegar el projecte. S'hauria de millorar com s'envia a "Prod" de la manera mes automatica possible, en comptes de haver de copiar els fitxers o de executar comandes per que la base de dades s'actualitzi.

# TODO
M P, [14/03/2023 18:58]
✔?  Informes
    ✖  Informe des de un taller


M P, [15/03/2023 16:27]
✖  Filtre de tallers en la seleccio de tallers des de la seccio admin

