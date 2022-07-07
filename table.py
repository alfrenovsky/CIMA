
import mysql.connector
from mysql.connector import errorcode
import os
import csv


def INSERT_DATA(path,est):
    with open(path, newline='') as csvfile:
        spamreader = csv.reader(csvfile)
        for row in spamreader:
            query1 = 'INSERT INTO productos (Fecha,estacion,presion,temperatura,iwv,ztd,o,n) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)'
            val = (row[0], est ,row[1], row[2], row[3], row[4], row[5], row[6])
            mycursor.execute(query1, val)


mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="productos"
)
mycursor = mydb.cursor()
contenido = os.listdir(rf'C:\Users\renzo\Documents\Estaciones')

for anio in contenido:
    contenido2 = os.listdir(rf'C:\Users\renzo\Documents\Estaciones\{anio}')
    for estacion in contenido2:
        est = estacion[:4]
        if est == 'CALL':
            est = 'CALL1'
        anio2 = anio.split('_')[1]
        path = rf'C:\Users\renzo\Documents\Estaciones\{anio}\{estacion[:4]}_{anio2[2:]}.csv'
        try:
            query = "CREATE TABLE productos ( FECHA DATETIME, ESTACION char(4), PRESION decimal(17,11), TEMPERATURA decimal(17,14), IWV decimal(17,14), ZTD decimal(8,6), O decimal(8,6), n TINYINT) "
            mycursor.execute(query)
        except:
            pass
        INSERT_DATA(path,est)
