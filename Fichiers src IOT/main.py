import paho.mqtt.client as mqtt, json, yaml, os, sys, time

t=[] #tableau des températures
h=[] #tableau de l'humidite
c=[] #tableau du c02

#config
with open('config.yml', 'r') as fichier:
    config=yaml.safe_load(fichier)

#with open('config.json') as fichier:
    #config=json.load(fichier)

#variables du fichier de config
server = config['server']
appId = config['appId'] 
deviceId = config['deviceId']
tempM = config['tauxMaxTemp']
c02M = config['tauxMaxC02']
humM = config['tauxMaxHum']
frequence = config['frequence']

tempMax = tempM.to_bytes(4, sys.byteorder)
c02Max = c02M.to_bytes(4, sys.byteorder)
humMax = humM.to_bytes(4, sys.byteorder)

topic="application/{}/device/{}/event/up"

def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))
    client.subscribe(topic.format(appId, deviceId))

def on_message(client, userdata, msg):
    ft = os.open("./temperature.txt", os.O_WRONLY | os.O_CREAT | os.O_TRUNC) #fichier des températures
    fc = os.open("./c02.txt", os.O_WRONLY | os.O_CREAT | os.O_TRUNC) #fichier des taux de c02
    fh = os.open("./humidite.txt", os.O_WRONLY | os.O_CREAT | os.O_TRUNC) #fichier de % d'humidité
    fs = os.open("./seuil.txt", os.O_WRONLY | os.O_CREAT | os.O_TRUNC) #fichier des seuils d'alerte
    global t
    global h
    global c
    Jmsg=json.loads(msg.payload)

    #declaration des variables
    name = Jmsg["deviceName"]
    temp=Jmsg["object"]["temperature"]
    hum=Jmsg["object"]["humidity"]
    co2=Jmsg["object"]["co2"]
    #time.sleep(frequence)    ------------  test

    #ecriture de la temperature, humidite et c02 dans les différents fichiers texte
    nom = str(name)
    nom_b = bytes(nom, 'utf-8')

    os.write(ft, b"\n")
    os.write(fc, b"\n")
    os.write(fh, b"\n")
    os.write(fs, b"\n")

    os.write(ft, nom_b)
    os.write(fc, nom_b)
    os.write(fh, nom_b)
    os.write(fs, nom_b)

    os.write(ft, b";")
    os.write(fc, b";")
    os.write(fh, b";")
    os.write(fs, b";")

    temperature = str(temp)
    temp_b = bytes(temperature, 'utf-8') 

    if (temp_b > tempMax):
        os.write(fs, temp_b)
        os.write(fs, b";")

    else:
        os.write(fs, b"-")
        os.write(fs, b";")
        os.write(ft, temp_b)
        os.write(ft, b";")

    humidite = str(hum)
    hum_b = bytes(humidite, 'utf-8') 

    if (hum_b > humMax):
        os.write(fs, hum_b)
        os.write(fs, b";")

    else:
        os.write(fs, b"-")
        os.write(fs, b";")
        os.write(fh, hum_b)
        os.write(fh, b";")

    carbonasse = str(co2)
    co2_b = bytes(carbonasse, 'utf-8') 

    if (co2_b > c02Max):
        os.write(fs, co2_b)

    else:
        os.write(fs, b"-")
        os.write(fs, b";")
        os.write(fc, co2_b)

    #affichage dans le terminal
    print(name)
    print(temp, "°C")
    t.append(temp)
    print(t)
    print(hum, "%")
    h.append(hum)
    print(h)
    print(co2, "ppm")
    c.append(co2)
    print(c)
    if len(t)>=10 :
        print("Moyenne des températures = ",round(sum(t[-10:])/10,2), "°C") 
    if len(h)>=10 :
        print("Moyenne de l'humidite = ",round(sum(h[-10:])/10,2), "%") 
    if len(c)>=10 :
        print("Moyenne du co2 = ",round(sum(c[-10:])/10,2), "ppm") 

client = mqtt.Client()
client.on_message = on_message
client.on_connect = on_connect
#client.connect(config[0], 1883, 60)
client.connect(config['server'], 1883, 60)
client.loop_forever()
