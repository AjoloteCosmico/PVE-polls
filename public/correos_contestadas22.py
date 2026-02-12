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

egresados=pd.read_sql("""
                    select 
                        egresados.nombre, egresados.paterno, egresados.materno, egresados.cuenta, egresados.status,
                        respuestas20.updated_at AS fecha_respuesta, 
                        users.name AS nombre_aplicador
                    from egresados 
                    inner join respuestas20  ON egresados.cuenta = respuestas20.cuenta 
                    left join users ON CAST(respuestas20.aplica AS VARCHAR) = CAST(users.clave AS VARCHAR)
                    where egresados.muestra = 5 and (egresados.status = '2' or egresados.status = '1') 
                    and respuestas20.completed = 1
                      """,cnx)

print('len de egresados',len(egresados))
correos=pd.read_sql('select * from correos',cnx)
writer = pd.ExcelWriter('storage/correos_contestadas22.xlsx', engine='xlsxwriter')

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
worksheet.merge_range('C4:H4', 'EGRESADOS QUE COMPLETARON LA ENCUESTA DE SEGUIMIENTO 2022', negro_b)
worksheet.insert_image("A1", "img/logoPVE.png",{"x_scale": 0.2, "y_scale": 0.2})
worksheet.merge_range('G6:H6',today, date_content_bold)

worksheet.write('B8','Nombre',header_format)
worksheet.write('C8','Paterno',header_format)
worksheet.write('D8','Materno',header_format)
worksheet.write('E8','Numero de cuenta',header_format)
worksheet.write('F8','Fecha en que realizó',header_format)
worksheet.write('G8','mode de aplicacion',header_format)
worksheet.write('H8','Aplicador',header_format)
worksheet.write('I8','Correo 1',header_format)
worksheet.write('J8','Correo 2',header_format)
worksheet.write('K8','Correo 3',header_format)
worksheet.write('L8','Correo 4',header_format)

# --- Llenado de Datos ---

dict_correos = correos.groupby('cuenta')['correo'].apply(list).to_dict()

for i, fila in egresados.iterrows():
    idx_excel = i + 8 # Fila actual en Excel
    cuenta_eg = str(fila['cuenta'])
    
    # Datos básicos
    worksheet.write(idx_excel, 1, fila['nombre'], blue_content)
    worksheet.write(idx_excel, 2, fila['paterno'], blue_content)
    worksheet.write(idx_excel, 3, fila['materno'], blue_content)
    worksheet.write(idx_excel, 4, cuenta_eg, blue_content)
    
    # Fecha de respuesta
    fecha_val = fila['fecha_respuesta']
    fecha_str = str(fecha_val)[0:10] if pd.notnull(fecha_val) else 'N/A'
    worksheet.write(idx_excel, 5, fecha_str, blue_content)
    
    # Modo aplicación
    modo = 'TELEFÓNICA' if str(fila['status']) == '1' else 'INTERNET'
    worksheet.write(idx_excel, 6, modo, blue_content)
    
    # Aplicador
    nom_ap = fila['nombre_aplicador'] if pd.notnull(fila['nombre_aplicador']) else 'N/A'
    worksheet.write(idx_excel, 7, nom_ap, blue_content)
    
    # Correos desde el diccionario (mucho más rápido que .loc)
    lista_c = dict_correos.get(cuenta_eg, [])
    for j, correo in enumerate(lista_c[:4]):
        worksheet.write(idx_excel, 8 + j, correo, blue_content)
        
        
worksheet.set_column('B:D',18)
worksheet.set_column('E:E',25)
worksheet.set_column('F:M',30)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()