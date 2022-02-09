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
    longitude = gps.location.lng();
    kmh = gps.speed.mph()*1.60934;
  }
  
  float current_mA = 0;
  current_mA = ina219.getCurrent_mA();
 
  Serial.print("{\"loc\":{\"latitude\":");
  Serial.print(latitude, 6);
  Serial.print(",\"longitude\":");
  Serial.print(longitude ,6);
  Serial.print("},\"temp\":");
  Serial.print(t);
  Serial.print(",\"current\":");
  Serial.print(current_mA);
  Serial.print(",\"kmh\":");
  Serial.print(kmh);
  Serial.println("}");
  delay(3000);
}
