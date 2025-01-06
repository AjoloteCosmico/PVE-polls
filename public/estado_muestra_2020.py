import sys
import xlsxwriter
import pandas as pd
import sys
import psycopg2
import os
from dotenv import load_dotenv
from datetime import date
from sqlalchemy import create_engine

today = date.today()
load_dotenv()

#configurar la conexion a la base de datos
DB_USERNAME = os.getenv('DB_USERNAME')
DB_DATABASE = os.getenv('DB_DATABASE')
DB_PASSWORD = os.getenv('DB_PASSWORD')
DB_PORT = os.getenv('DB_PORT')
DB_HOST=os.getenv('DB_HOST')

# Conectar a DB
# Conectar a PostgreSQL
try:
    cnx = psycopg2.connect(
        user=DB_USERNAME,
        password=DB_PASSWORD,
        host=DB_HOST,
        port=DB_PORT,
        database=DB_DATABASE
    )
    print("Conexión exitosa")
except psycopg2.Error as e:
    print("Ocurrió un error al conectar a la base de datos:", e)

# Crear la URI de conexión
database_uri = f"postgresql+psycopg2://{DB_USERNAME}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_DATABASE}"

# Crear el motor de SQLAlchemy
engine = create_engine(database_uri)

query = """
WITH CarrerasConMuestras AS (
SELECT 
	carreras.plantel,
    carreras.carrera,
	muestras.poblacion as tamano_muestra,
	
	muestras.requeridas_5 as requeridas,
    muestras.carrera_id AS carrera_id,
    muestras.plantel_id AS plantel_id,
    carreras.clave_carrera,
    carreras.clave_plantel
	
    
FROM muestras
LEFT JOIN carreras
    ON carreras.clave_carrera = muestras.carrera_id
    AND carreras.clave_plantel = muestras.plantel_id
WHERE muestras.estudio_id = 3
)
-- Contar encuestas por teléfono y por internet para cada carrera
SELECT 
    c.plantel,
	c.carrera,
	c.tamano_muestra,
	COUNT(CASE WHEN e.status = 1 THEN 1 END) AS Telefonicas,
    COUNT(CASE WHEN e.status = 2 THEN 1 END) AS Internet,
	COUNT(CASE WHEN e.status = 1 THEN 1 END ) +  COUNT(CASE WHEN e.status = 2 THEN 1 END) as Total_realizadas,
	c.requeridas,
	c.requeridas - (COUNT(CASE WHEN e.status = 1 THEN 1 END ) +  COUNT(CASE WHEN e.status = 2 THEN 1 END)) as Faltan,
	CAST((((COUNT(CASE WHEN e.status = 1 THEN 1 END ) +  COUNT(CASE WHEN e.status = 2 THEN 1 END))*100)/c.requeridas) as double precision) as avance
    
    
FROM CarrerasConMuestras c
LEFT JOIN egresados e
    ON e.muestra = 3
    AND e.carrera = c.carrera_id
    AND e.plantel = c.plantel_id
GROUP BY 
    c.carrera, 
    c.plantel, 
    c.carrera_id, 
    c.plantel_id,
	c.tamano_muestra,
    c.requeridas
	
order by c.plantel
"""

encuestas=pd.read_sql(query,engine)
for col in ['created_at','updated_at','fec_capt']:
    encuestas[col]=encuestas[col].astype(str)
encuestas.to_excel('storage/estado_muestra_2020.xlsx')