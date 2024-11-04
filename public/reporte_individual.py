import sys
import xlsxwriter
import pandas as pd
import sys
import psycopg2
import os
from dotenv import load_dotenv
from datetime import date

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

encuestas=pd.read_sql("""select respuestas2.aplica, egresados.cuenta, respuestas2.fec_capt, carreras.carrera, carreras.plantel
                        from ((respuestas2 
                        inner join egresados on respuestas2.cuenta=egresados.cuenta)
                        inner join carreras  on carreras.clave_carrera=egresados.carrera and carreras.clave_plantel=egresados.plantel)
                        
                        where (respuestas2.utiliza is not null or respuestas2.ngr11f is not null) and egresados.anio_egreso=2019""",cnx)

ClavesNombres = {'17': 'Erendira', '12':'Mónica', '15':'César', '20':'María', '21':'Ivonne','8':'Elia','7':'otra monica','6':'Silvia','9':'Veronica',
                             '14':'Alberto','18':'Daniela','19':'Elvira','13':'Carolina','22':'Elizabeth'}

def mapeo(x):
    if(x==None):
        return 'INTERNET'
    else:
        try:
            return ClavesNombres[x]
        except:
            return 'Encuestador Desconocido'
#     return x/100
encuestas['aplica'] = encuestas['aplica'].map(lambda x:mapeo(x))

# Convert datetime from datetime64[ns] to string type
#encuestas['fec_capt']=pd.to_datetime(encuestas['fec_capt'].astype(str), format='%Y/%m/%d')
print(encuestas['fec_capt'])
print(encuestas[0:10])
print(encuestas['aplica'].unique())

writer = pd.ExcelWriter('storage/reporte_individual.xlsx', engine='xlsxwriter')

workbook = writer.book
a_color='#173d83'
#estilos----------------
negro_b = workbook.add_format({
    'bold': 2,
    'border': 0,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':13}) 
header_format = workbook.add_format({
    'bold': True,
    'bg_color': a_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1,
    'font_size':12})
blue_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':10,
    'border_color':a_color})
date_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':10,
    'border_color':a_color,
    'num_format': 'dd/mm/yy'})
date_content_bold = workbook.add_format({
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'bold': True,
    'num_format': 'dd/mm/yy'})
worksheet = workbook.add_worksheet()
worksheet.merge_range('C2:H3', 'PROGRAMA DE VINCULACION A EGRESADOS UNAM', negro_b)
worksheet.merge_range('C4:H4', 'CONSECUTIVO ENCUESTAS 2019', negro_b)
worksheet.insert_image("A1", "img/logoPVE.png",{"x_scale": 0.2, "y_scale": 0.2})
worksheet.merge_range('G6:H6',today, date_content_bold)
worksheet.write('B8','Numero de cuenta',header_format)
worksheet.write('C8','Fecha en que realizó',header_format)
worksheet.write('D8','Aplicador',header_format)
worksheet.write('E8','Carrera',header_format)
worksheet.write('F8','Plantel',header_format)

for i in range(0,len(encuestas)):
    worksheet.write('B'+str(i+9),encuestas['cuenta'].values[i],blue_content)
    worksheet.write('C'+str(i+9),str(encuestas['fec_capt'].values[i]),date_content)
    worksheet.write('D'+str(i+9),encuestas['aplica'].values[i],blue_content)
    worksheet.write('E'+str(i+9),encuestas['carrera'].values[i],blue_content)
    worksheet.write('F'+str(i+9),encuestas['plantel'].values[i],blue_content)
worksheet.set_column('J:J',15)
worksheet.set_column('B:C',17)
worksheet.set_column('E:F',28)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()