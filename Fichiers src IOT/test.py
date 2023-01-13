import paho.mqtt.client as mqtt, json, base64

# The callback for when the client receives a CONNACK response from the server.
def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))

    # Subscribing in on_connect() means that if we lose the connection and
    # reconnect then subscriptions will be renewed.
    client.subscribe("application/1/device/+/event/up")

# The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
    Jmsg=json.loads(msg.payload)
    mydata=Jmsg["object"]
    if (mydata!=""):
        print(mydata)
        Jmydata=json.loads(mydata)

#def bleu():
 #   msg="blue"
  #  msg_bytes=msg.encode('ascii')
   # b64_bytes=base64.b64encode(msg_bytes)
    #b64_msg=b64_bytes.decode('ascii')
    #print(b64_msg)
    #payloadJson={"confirmed":False,"fPort":5,"data":b64_msg}
    #client.publish(topic="application/1/device/0c7e450102030102/command/down",payload=json.dumps(payloadJson))

client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("chirpstack.iut-blagnac.fr", 1883, 60)

# Blocking call that processes network traffic, dispatches callbacks and
# handles reconnecting.
# Other loop*() functions are available that give a threaded interface and a
# manual interface.
client.loop_forever()