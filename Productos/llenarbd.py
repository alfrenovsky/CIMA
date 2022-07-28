import urllib.request,mysql.connector,csv,re
import os
from bs4 import BeautifulSoup
from datetime import datetime
from io import StringIO

def INSERT_DATA(link,est,fecha):

    respuesta = urllib.request.urlopen(link)
    file = StringIO(bytearray(respuesta.read()).decode())

    try:

        filecsv = csv.reader(file,delimiter=",")

        for row in filecsv:

            query_Insert = 'INSERT INTO productos (Fecha,estacion,presion,temperatura,iwv,ztd,o,n) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)'
            val = (row[0], est ,row[1], row[2], row[3], row[4], row[5], row[6])

            fecha_csv = datetime.fromisoformat(row[0])

            if fecha_csv > fecha:

                db.execute(query_Insert, val)

        mydb.commit()

    except:

        pass

#----------- Creo objeto soup para scraping de la pagina donde se van a obtener datos -------
link = 'https://cima.ingenieria.uncuyo.edu.ar/IWV_ERA5/productos/'
datos = urllib.request.urlopen(link).read().decode()
soup =  BeautifulSoup(datos,"html.parser")
tags = soup('a')
#--------------------------------------------------------------------------------------------

# ----------------Creo objeto mysql para CRUD de BD--------------------------
mydb = mysql.connector.connect(
    host=os.environ['MYSQL_HOST'],
    user=os.environ['MYSQL_USER'],
    passwd=os.environ['MYSQL_PASSWORD'],
    database=os.environ['MYSQL_DATABASE'],
)

db = mydb.cursor()
#-----------------------------------------------------------------------------

#Consulta la fecha de los ultimos registros insertados en la tabla para retomar el llenado de la misma
print("<--Buscando fecha de los ultimos registros-->")
query_FechaMax = 'SELECT estacion,max(FECHA) FROM `productos` group by estacion'
db.execute(query_FechaMax)
result_FechaMax = db.fetchall()

estacion_FechaMax={}

for val in result_FechaMax:

    estacion_FechaMax[val[0]]=val[1]

print("<--Busqueda finalizada-->")

for estaciones, fechas in estacion_FechaMax.items():

    print(estaciones, fechas)
#----------------------------------------------------------------------------------

#------------Llenado de Bd --------------------------------------------------------
print("<--Llenado de BD-->")
for tag in tags:

    tag = str(tag.get('href'))

    if tag != "../":

        link2 = link + tag
        datos2 = urllib.request.urlopen(link2).read().decode()
        soup2 =  BeautifulSoup(datos2, "html.parser")
        tags2 = soup2('a')

        carpeta_year=[int(s) for s in re.findall(r'-?\d+\.?\d*', tag)][0]

        for tag2 in tags2:

            tag2 = str(tag2.get('href'))

            if tag2 != "../":

                estacion = tag2
                link3 = link2 + estacion
                est = estacion[:4]

                if est == 'CALL':

                    est = 'CAL1'

                try:

                    if estacion_FechaMax[est].year <= carpeta_year:

                        INSERT_DATA(link3,est,estacion_FechaMax[est])

                except:

                        INSERT_DATA(link3,est,datetime.fromisoformat('2000-01-01 00:00:00'))
        print(f"<--Año {carpeta_year} finalizado-->")

db.close()
