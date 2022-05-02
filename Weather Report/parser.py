from argparse import _MutuallyExclusiveGroup
import xml.dom.minidom
import sys              #for args
import mysql.connector
from mysql.connector import Error
from datetime import date, timedelta


# get days of week and long description
def getImgInfo(node):
    imgList = node.getElementsByTagName("img")
    for img in imgList:
        return img.getAttribute("alt")

# get high temp and low temp
def getTemps(node):
    plist = node.getElementsByTagName("p")
    for p in plist:
        if p.getAttribute("class") == "temp temp-low":
            return p.firstChild.nodeValue
        elif p.getAttribute("class") == "temp temp-high":
            return p.firstChild.nodeValue

def getShortDesc(node):
    plist = node.getElementsByTagName("p")
    for p in plist:
        if p.getAttribute("class") == "short-desc":
            val = p.firstChild.nodeValue if p.firstChild.nodeValue == p.lastChild.nodeValue else p.firstChild.nodeValue + " " + p.lastChild.nodeValue
            return val

def parseInfo(city_name, long_desc, temp, short_desc):
    # city name, date, day or night, short desc , long desc
    days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]
    values = []

    long_desc = long_desc.split(":")
    if long_desc[0] in days:    #if day in description is just a day then it is morning
        long_desc[0] += " Day"
    
    # city state -> remove state -> put back cityname
    city_name = city_name.split(" ") 
    city_name.remove('NJ')
    city_name = ' '.join(city_name)
    values.append(city_name)
    # print(city_name)

    values.extend(long_desc[0].split()) # add date day
    values.append(temp)
    values.append(short_desc)
    values.append(long_desc[1].strip())
    
    return values

def get_dates(weather_report):
    dates = {} # empty list for dates
    t_delta = 0
    for l in weather_report:
        if l[1] not in dates.keys():
            dates[l[1]] = (date.today()+timedelta(days=t_delta)).isoformat();
            t_delta += 1 # increase time delta
    return dates


# create xml objject
document = xml.dom.minidom.parse(sys.argv[1])

# trying to get city name
nodelist = document.getElementsByTagName("h2")
city_name = nodelist[1].firstChild.nodeValue # 2 item in list is city name

city_name = city_name.strip()

insert_values = [] # hold insert values

# get my elements
nodelist = document.getElementsByTagName("div")
for node in nodelist:
    if node.getAttribute("class") == "tombstone-container":
        long_desc = getImgInfo(node)
        temp = getTemps(node)
        short_desc = getShortDesc(node)
        values = parseInfo(city_name, long_desc, temp, short_desc)
        # send to db now
        insert_values.append(values)

# start connection to database


try:

    connection = mysql.connector.connect(user='root', passwd='',host='localhost', database='weather_db')
    if connection.is_connected():
        print("connection successful")
        dates = get_dates(insert_values)

        cursor = connection.cursor()
        
        for i in insert_values:
            # print(i)
            d = dates[i[1]] # get val from dict where i[1] holds my day
            # print(d)
            # print(i)
            # check len of values
            if len(i) == 5:
                # does not contain day or night
                try:
                    cursor.execute("INSERT INTO weather_report (city_name, date_recorded, temp, short_desc, long_desc) VALUES ('{}','{}','{}','{}','{}');".format(i[0], d, i[2], i[3], i[4]))
                    connection.commit() # commit changes to db
                except:
                    connection.rollback() # roll back in case of error
            elif len(i) == 6:
                # if i contains day or night in list
                try:
                    cursor.execute("INSERT INTO weather_report (city_name, date_recorded, day_night, temp, short_desc, long_desc) VALUES ('{}','{}','{}','{}','{}','{}');".format(i[0], d, i[2], i[3], i[4], i[5]))
                    connection.commit()
                except:
                    connection.rollback()
except Error as e:
    print("Error while connecting to mysql: ", e)
