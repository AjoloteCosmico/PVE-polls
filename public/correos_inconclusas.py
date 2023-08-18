import sys
import xlsxwriter
import pandas as pd
import sys
import mysql.connector
import os
from dotenv import load_dotenv
from datetime import date
import EncuestasSQL
today = date.today()
load_dotenv()

#configurar la conexion a la base de datos
DB_USERNAME = os.getenv('DB_USERNAME')
DB_DATABASE = os.getenv('DB_DATABASE')
DB_PASSWORD = os.getenv('DB_PASSWORD')
DB_PORT = os.getenv('DB_PORT')
DB_HOST=os.getenv('DB_HOST')

# Conectar a DB
cnx = mysql.connector.connect(user=DB_USERNAME,
                              password=DB_PASSWORD,
                              host=DB_HOST,
                              port=DB_PORT,
                              database=DB_DATABASE,
                              use_pure=False)

encuestas_completas=pd.read_sql("""select respuestas2.aplica, egresados.cuenta, respuestas2.fec_capt, carreras.carrera, carreras.plantel
                        from ((respuestas2 
                        inner join egresados on respuestas2.cuenta=egresados.cuenta)
                        inner join carreras  on carreras.clave_carrera=egresados.carrera and carreras.clave_plantel=egresados.plantel)
                        
                        where respuestas2.ngr11f is not null and egresados.anio_egreso=2019""",cnx)
encuestas_incompletas=pd.read_sql("""select respuestas2.aplica, egresados.cuenta, respuestas2.fec_capt, carreras.carrera, carreras.plantel
                        from ((respuestas2 
                        inner join egresados on respuestas2.cuenta=egresados.cuenta)
                        inner join carreras  on carreras.clave_carrera=egresados.carrera and carreras.clave_plantel=egresados.plantel)
                        where respuestas2.ngr11f is  null and egresados.anio_egreso=2019""",cnx)
egresados=pd.read_sql("""select * from egresados where egresados.anio_egreso=2019""",cnx)

def formatear_cuenta(columna):
        """ Formatea los números de cuenta para que tengan un formato consistente y comparable

         Parámetros
        ----------
        columna : DataFrame / list / Series
            Números de cuenta

        Devuelve
        -------
        Series
            Números de cuenta formateados
        """
        # Copiar la columna para no sobreescribirla
        columna = columna.copy()
        # Convertir la columna a tipo Series de pandas
        columna = pd.Series(columna)
        # Convertir a tipo string  
        columna = columna.astype('str')
        # Remplazar todo lo que no es número con la cadena vacía
        columna = columna.str.replace("\D", "", regex = True)
        # Llenar las cadenas con ceros a la izquierda para que tengan todas 9 dígitos
        columna = columna.str.pad(width=9, side='left', fillchar='0')
    
        return columna  

egresados['cuenta']=formatear_cuenta(egresados['cuenta'])

inconclusos=encuestas_incompletas[['cuenta','fec_capt']].merge(egresados,how='inner',on='cuenta')
index_for_drop=inconclusos[inconclusos['cuenta'].isin(encuestas_completas['cuenta'].unique())].index
inconclusos.drop(index_for_drop , inplace=True)
print('columnas df',inconclusos.columns)
ClavesNombres = {'17': 'Erendira', '12':'Mónica', '15':'César', '20':'María', '21':'Ivonne',
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

writer = pd.ExcelWriter('storage/correos_inconclusas.xlsx', engine='xlsxwriter')

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
worksheet.merge_range('C4:H4', 'EGRESADOS CON ENCUESTAS INCONCLUSAS 2019', negro_b)
worksheet.insert_image("A1", "img/logoPVE.png",{"x_scale": 0.2, "y_scale": 0.2})
worksheet.merge_range('G6:H6',today, date_content_bold)

worksheet.write('B8','Nombre',header_format)
worksheet.write('C8','Paterno',header_format)
worksheet.write('D8','Materno',header_format)
worksheet.write('E8','Numero de cuenta',header_format)
worksheet.write('F8','Fecha en que realizó',header_format)
worksheet.write('G8','Carrera',header_format)
worksheet.write('H8','Plantel',header_format)
worksheet.write('I8','Correo 1',header_format)
worksheet.write('J8','Correo 2',header_format)
worksheet.write('K8','Correo UNAM',header_format)
worksheet.write('L8','Telefono 1',header_format)
worksheet.write('M8','Telefono 2',header_format)
worksheet.write('N8','Telefono encuesta',header_format)

for i in range(0,len(inconclusos)):
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