#include "DHT.h"
#include <TinyGPS++.h>
#include <SoftwareSerial.h>
#include <Wire.h>
#include <Adafruit_INA219.h>

#define DHTPIN 2     
#define DHTTYPE DHT11  
DHT dht(DHTPIN, DHTTYPE);

static const int RXPin = 4, TXPin = 3;
static const uint32_t GPSBaud = 9600;
float latitude = 0;
float longtitude = 0;
float kmh = 0;
double loc[11][2]={{35.888152, 128.612546},{35.888569, 128.612428},{35.888969, 128.612310},{35.889299, 128.612214},{35.889673, 128.612364},{35.889855, 128.612561},{35.890307, 128.612819},{35.890741, 128.613173},{35.891150, 128.613527},{35.891523, 128.613216},{35.891975, 128.613237}};
float vel[11]={10.3, 10.8, 11.5, 10.9, 10.7, 10.8, 11.3,11.5, 11.2, 10.8, 10.5};
int i=0;

TinyGPSPlus gps;
SoftwareSerial gps_serial(RXPin, TXPin);

Adafruit_INA219 ina219;


void setup() {
  Serial.begin(9600);
  dht.begin();
  gps_serial.begin(GPSBaud);
  uint32_t currentFrequency;
  ina219.begin();
}

void loop() {

  float t = dht.readTemperature();
  if (isnan(t)) {
    Serial.println(F("Failed to read from DHT sensor!"));
    return;
  }

  while (gps_serial.available()){
    gps.encode(gps_serial.read());
  }
  
  if(gps.location.isUpdated()){
    latitude = gps.location.lat();
    longtitude = gps.location.lng();
    kmh = gps.speed.mph()*1.60934;
  }
  
  float current_mA = 0;
  current_mA = ina219.getCurrent_mA();
 
  Serial.print("{\"loc\":{\"latitude\":");
  Serial.print(loc[i/2][0],6);
  Serial.print(",\"longitude\":");
  Serial.print(loc[i/2][1],6);
  Serial.print("},\"temp\":");
  Serial.print(t);
  Serial.print(",\"current\":");
  Serial.print(current_mA);
  Serial.print(",\"kmh\":");
  Serial.print(vel[i/2],1);
  Serial.println("}");
  if(i>20){
    i = i - 22;
  }
  i++;
  delay(3000);
}
