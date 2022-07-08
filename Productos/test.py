from bs4 import BeautifulSoup
import urllib.request
import requests
import mysql.connector
from mysql.connector import errorcode
import os
import csv
import pandas as pd
from io import StringIO

link = 'https://cima.ingenieria.uncuyo.edu.ar/IWV_ERA5/productos/'
datos = urllib.request.urlopen(link).read().decode()
soup =  BeautifulSoup(datos)
tags = soup('a')

def INSERT_DATA(link,est):
    respuesta = urllib.request.urlopen(link)
    f = StringIO(bytearray(respuesta.read()).decode())
    # data = pd.read_csv(f, sep='[;,]', engine='python')
    # f.close()
    # data.to_csv('output.csv',sep=",")
    # with open('output.csv', newline="") as csvfile2:
    try:
        spamreader2 = csv.reader(f,delimiter=",")
        for row in spamreader2:
            query1 = 'INSERT INTO productos (Fecha,estacion,presion,temperatura,iwv,ztd,o,n) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)'
            val = (row[0], est ,row[1], row[2], row[3], row[4], row[5], row[6])
            mycursor.execute(query1, val)
    except:
        pass
        
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="productos"
)
mycursor = mydb.cursor()

count = 0
for tag in tags:
    if count == 0:
        tag = str(tag.get('href'))
        if tag != "../":
            print(tag)
            link2 = link + tag
            datos2 = urllib.request.urlopen(link2).read().decode()
            soup2 =  BeautifulSoup(datos2)
            tags2 = soup2('a')
            for tag2 in tags2:
            
                tag2 = str(tag2.get('href'))
                if tag2 != "../":
                    if count == 0:
                        count = 0
                        estacion = tag2
                        link3 = link2 + estacion
                        
                        est = estacion[:4]
                        if est == 'CALL':
                            est = 'CAL1'
                        INSERT_DATA(link3,est)
                mydb.commit()