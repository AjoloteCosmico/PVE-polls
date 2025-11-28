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

continuas=pd.read_sql("select * from  respuestas_continua where updated_at >'2025-11-24'",cnx)
opciones=pd.read_sql("select * from  options where reactivo like 'edc%' or reactivo = 'binaria'",cnx)
respuestas_multiple=pd.read_sql("select * from  multiple_option_answers where reactivo like 'edc%'",cnx)
reactivos=pd.read_sql("select * from  reactivos where clave like 'edc%'",cnx)
#asignar columna con desc de cada opcion
for i in range(len(reactivos)):
    if(reactivos['type'].values[i]=='multiple_option'):
        ops=opciones.loc[opciones['reactivo']==reactivos['clave'].values[i]]
        for j in range(len(ops)):
            continuas[f"{reactivos['clave'].values[i]}-{ops['descripcion'].values[j]}"]=2

#llenar columnas de las opciones multiples
print("llenando opciones multiples")
for i in range(len(reactivos)):
    if(reactivos['type'].values[i]=='multiple_option'):
        print(reactivos['clave'].values[i])
        ops=opciones.loc[opciones['reactivo']==reactivos['clave'].values[i]]
        
        for j in range(len(ops)):
            print("",ops['descripcion'].values[j])
            resp=respuestas_multiple.loc[(respuestas_multiple['reactivo']==reactivos['clave'].values[i])&(respuestas_multiple['clave_opcion']==ops['clave'].values[j])]
            print('',len(resp),'respuestas')
            continuas.loc[continuas['registro'].isin(resp['encuesta_id'].unique()),f"{reactivos['clave'].values[i]}-{ops['descripcion'].values[j]}"]=1
            print(continuas[f"{reactivos['clave'].values[i]}-{ops['descripcion'].values[j]}"].unique())
#exportar codificado
continuas[['registro','nbr2', 'nbr3', 'carrera', 'anio_egreso','edc1',
'edc14',
'edc15',
'edc15-En la UNAM', 'edc15-En otra institución pública',
'edc15-En otra institución privada',
'edc15-En la empresa o institución dónde trabaja',
'edc15-En una asociación', 'edc15-En internet',
'edc2',
'edc2otra',
'edc3-Tecnología',
'edc3-Conocimientos relacionados con su carrera', 'edc3-Liderazgo',
'edc3-Gestión de proyectos', 'edc3-Análisis de datos',
'edc3otra',
'edc5-Herramientas digitales para la docencia',
'edc5-Seguridad, privacidad  y gobernanza digital',
'edc5-Desarrollo de software y web (tecnologías aplicadas)',
'edc5-Datos, gestión y automatización', 'edc5-Ofimática',
'edc5otra',
'edc4-Chino', 'edc4-Francés', 'edc4-Inglés', 'edc4-Alemán',
'edc4-No lo requiero', 'edc4-Portugués',
'edc4otra',
'edc6',
'edc6otra',
'edc8',
'edc12a',
'edc12b',
'edc12c',
'edc12d',
'edc7',
'edc9',
'edc10','edc11-Correo electrónico',
'edc11-Redes sociales', 'edc11-Página oficial', 'edc11-WhatsApp']].to_excel('storage/base_continua.xlsx')
from meta_continua import meta_continua
#recodificar 
for i in range(len(reactivos)):
    print(reactivos['clave'].values[i])
    if(reactivos['type'].values[i]=='option'):
        continuas[f"{reactivos['clave'].values[i]}"]=continuas[f"{reactivos['clave'].values[i]}"].map(meta_continua[f"{reactivos['clave'].values[i]}"])
    if(reactivos['type'].values[i]=='multiple_option'):
        ops=opciones.loc[opciones['reactivo']==reactivos['clave'].values[i]]
        for j in range(len(ops)):
            print(len(ops))
            continuas[f"{reactivos['clave'].values[i]}-{ops['descripcion'].values[j]}"]=continuas[f"{reactivos['clave'].values[i]}-{ops['descripcion'].values[j]}"].map(meta_continua[f"{reactivos['clave'].values[i]}-{ops['descripcion'].values[j]}"])
         
continuas[['registro','nbr2', 'nbr3', 'carrera', 'anio_egreso','edc1',
'edc14',
'edc15',
'edc15-En la UNAM', 'edc15-En otra institución pública',
'edc15-En otra institución privada',
'edc15-En la empresa o institución dónde trabaja',
'edc15-En una asociación', 'edc15-En internet',
'edc2',
'edc2otra',
'edc3-Tecnología',
'edc3-Conocimientos relacionados con su carrera', 'edc3-Liderazgo',
'edc3-Gestión de proyectos', 'edc3-Análisis de datos',
'edc3otra',
'edc5-Herramientas digitales para la docencia',
'edc5-Seguridad, privacidad  y gobernanza digital',
'edc5-Desarrollo de software y web (tecnologías aplicadas)',
'edc5-Datos, gestión y automatización', 'edc5-Ofimática',
'edc5otra',
'edc4-Chino', 'edc4-Francés', 'edc4-Inglés', 'edc4-Alemán',
'edc4-No lo requiero', 'edc4-Portugués',
'edc4otra',
'edc6',
'edc6otra',
'edc8',
'edc12a',
'edc12b',
'edc12c',
'edc12d',
'edc7',
'edc9',
'edc10','edc11-Correo electrónico',
'edc11-Redes sociales', 'edc11-Página oficial', 'edc11-WhatsApp']].to_excel('storage/respuestas_ed_continua_recodificado.xlsx')