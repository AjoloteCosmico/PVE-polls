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

r20=pd.read_sql("select * from respuestas20 where fec_capt>'2025-01-01' and completed=1 and aplica2!=1",cnx)
r14=pd.read_sql("select * from respuestas20 where fec_capt>'2025-01-01' and completed=1 and aplica2==1",cnx)
r16=pd.read_sql("select * from respuestas16 where fec_capt>'2025-01-01' and completed=1 ",cnx)
rg=pd.read_sql("select * from respuestas14 where fec_capt>'2025-01-01' and aplica is not null ",cnx)

writer = pd.ExcelWriter('storage/egresados16_con_telefono.xlsx', engine='xlsxwriter')

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
worksheet.merge_range('C4:H4', 'Conteo', negro_b)
worksheet.insert_image("A1", "img/logoPVE.png",{"x_scale": 0.2, "y_scale": 0.2})
worksheet.merge_range('G6:H6',today, date_content_bold)

worksheet.write('B8','Generacion',header_format)
worksheet.write('C8','Telefonicas',header_format)
worksheet.write('D8','Internet',header_format)
worksheet.write('E8','Total',header_format)

worksheet.write('B9','Gen 2020',blue_content)
worksheet.write('B9',len(r20.loc[r20['aplica'].isin([])]),blue_content)
worksheet.write('B9',len(r20),blue_content)
worksheet.write('B9',len(r20),blue_content)
   

worksheet.set_column('B:D',20)
worksheet.set_column('E:E',20)
worksheet.set_column('F:M',28)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()