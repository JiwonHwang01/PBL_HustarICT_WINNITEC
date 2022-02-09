from sqlite3 import DatabaseError
import serial
import json
import mysql.connector
import datetime

mydb = mysql.connector.connect(
    host = "localhost",
    user = "root",
    password = "11111111",
    database = "pbl"
)
mycursor = mydb.cursor()



T= serial.Serial('COM7',9600)


def Insertion(json):
    sql = "INSERT INTO info (latitude, longitude, current, speed, temperature) VALUES (%s, %s, %s, %s, %s)"
    val = (json['loc']['latitude'],json['loc']['longitude'],json['current'],json['kmh'],json['temp'])
    mycursor.execute(sql,val)   

    mydb.commit()
    print(mycursor.rowcount, "record inserted.")
    print(json  )


def Ardread():
    if T.readable()==False:
        print("Serial transfer ERROR!!")
        return
    LINE = T.readline()
    L5INE = LINE[:-2].decode()
    json_data = json.loads(LINE)
    Insertion(json_data)
        

while(True):
    Ardread()
    