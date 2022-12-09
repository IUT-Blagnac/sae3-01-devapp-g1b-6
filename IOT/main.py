import paho.mqtt.client as mqtt, json, yaml, os, sys

t=[] #tableau des températures
h=[] #tableau de l'humidite
c=[] #tableau du c02

#config
with open('config.yml', 'r') as fichier:
    config=yaml.safe_load(fichier)

#with open('config.json') as fichier:
    #config=json.load(fichier)

server = config['server']
appId = config['appId'] 
deviceId = config['deviceId']

topic="application/{}/device/{}/event/up"

def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))
    client.subscribe(topic.format(appId, deviceId))

def on_message(client, userdata, msg):
    fd = os.open("./temperature.txt", os.O_WRONLY | os.O_CREAT | os.O_APPEND)
    global t
    global h
    global c
    Jmsg=json.loads(msg.payload)

    #declaration des variables
    name = Jmsg["deviceName"]
    temp=Jmsg["object"]["temperature"]
    hum=Jmsg["object"]["humidity"]
    co2=Jmsg["object"]["co2"]

    #ecriture de la temperature, humidite et c02 dans le fichier.txt
    os.write(fd, b"   --- ")
    nom = str(name)
    nom_b = bytes(nom, 'utf-8')
    os.write(fd, nom_b)
    os.write(fd, b" ---")
    os.write(fd, b"\n")
    os.write(fd, b"\n")

    os.write(fd, b"Temperature : ")
    temperature = str(temp)
    temp_b = bytes(temperature, 'utf-8') 
    os.write(fd, temp_b)
    os.write(fd, b" degres.")
    os.write(fd, b"\n")

    os.write(fd, b"Pourcentage d'humidite : ")
    humidite = str(hum)
    hum_b = bytes(humidite, 'utf-8') 
    os.write(fd, hum_b)
    os.write(fd, b" %.")
    os.write(fd, b"\n")

    os.write(fd, b"Taux de C02 : ")
    carbonasse = str(co2)
    co2_b = bytes(carbonasse, 'utf-8') 
    os.write(fd, co2_b)
    os.write(fd, b" ppm.")
    os.write(fd, b"\n")
    os.write(fd, b"\n")

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