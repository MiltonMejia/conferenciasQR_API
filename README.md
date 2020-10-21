# conferenciasQR_API
GraphQL API para el procesamiento de asistencias a conferencias

##Instalación
> composer install
 
 ## Descripción
 La API utilizada es Graphql en PHP mediante el framework [GraphQL] (https://github.com/webonyx/graphql-php)
 La api registra la asistencia a una serie de conferencias dentro de una convención (previo registro), en dado caso de cumplir una serie de conferencis mínimas, se le envía al asistente un diploma con los datos que éste haya proporcionado 

 ## Notas
 Puesto que el el desarrollo de la API no se utilizó la convención de GrapQL para el schema (se utilizó el proporcionado por el framework) en el repositorio se integra un schema de GraphQL en el archivo schema.graphql
