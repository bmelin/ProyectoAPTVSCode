import sys
import joblib
import numpy as np
import pandas as pd
import os

# ===== MAPEOS EXACTOS DEL MODELO =====

mapeo_menstruacion = {
    'menos_de_12': 2,
    '12_a_13': 1,
    'mayor_de_14': 0
}

mapeo_primer_hijo = {
    'nunca': 2,
    'menor_a_30': 1,
    'mayor_a_30': 0
}

mapeo_ejercicio = {
    'nunca': 0,
    'menos_de_3': 1,
    '3_a_4': 2,
    'mas_de_4': 3
}

mapeo_alcohol = {
    'nunca': 0,
    'ocasional': 1,
    'frecuente': 2,
    'diario': 3
}

# ===== FUNCION PARA CATEGORIZAR LA EDAD =====
def categorizar_edad(edad):
    if edad < 40:
        return 0
    elif edad < 50:
        return 1
    elif edad < 60:
        return 2
    else:
        return 3

# ===== CARGAR MODELO =====
model_path = os.path.join(os.path.dirname(__file__), "modelo_random_forest.pkl")
model = joblib.load(model_path)

# ===== RECIBIR DATOS DESDE PHP =====
edad = int(sys.argv[1])
FPG = int(sys.argv[2])
FSG = int(sys.argv[3])
DPC = int(sys.argv[4])
menstruacion = sys.argv[5]
primerHijo = sys.argv[6]
ejercicio = sys.argv[7]
alcohol = sys.argv[8]
mamografia = int(sys.argv[9])

# ===== TRANSFORMACIONES =====
edad_cat = categorizar_edad(edad)
menstruacion_val = mapeo_menstruacion[menstruacion]
primerHijo_val = mapeo_primer_hijo[primerHijo]
ejercicio_val = mapeo_ejercicio[ejercicio]
alcohol_val = mapeo_alcohol[alcohol]

# ===== CREAR DATAFRAME CON NOMBRE DE FEATURES =====
cols = [
    "Edad",
    "FamiliarPrimerGradoCC",
    "FamiliarSegundoGradoCC",
    "DiagnosticoPrevioCancer",
    "Menstruacion",
    "PrimerHijo",
    "Ejercicio",
    "Alcohol",
    "Mamografia"
]

data = pd.DataFrame([[
    edad_cat,
    FPG,
    FSG,
    DPC,
    menstruacion_val,
    primerHijo_val,
    ejercicio_val,
    alcohol_val,
    mamografia
]], columns=cols)

# ===== PREDICCION =====
pred = model.predict(data)
print(int(pred[0]))
