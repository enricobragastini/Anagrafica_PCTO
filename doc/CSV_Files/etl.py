import csv
import numpy
from difflib import SequenceMatcher
matrix=[["Ragione_sociale","tipo","comune","provincia","nazione","indirizzo","cap","telefono","mail","sito","ndip","data_conv","indirizzo_studio","cod_ateco"]]
matrix_alunni=[]
matrix_reduct=[]

def corrispondence(ragione1, ragione2):
    return SequenceMatcher(None, ragione1, ragione2).ratio()


with open('aziende_alunni.csv') as csvfile:
    readCSV = csv.reader(csvfile, delimiter=';')
    for row in readCSV:
        matrix_alunni.append(row)

with open('aziende_reduct.csv') as csvfile:
    readCSV = csv.reader(csvfile, delimiter=';')
    for row in readCSV:
        matrix_reduct.append(row)

print("Start reduction...")
for item1 in matrix_alunni:
    if len(item1)>1:
        for item2 in matrix_alunni:
            if (len(item2)>1):
                if corrispondence(item1[0], item2[0])==1.0 and matrix_alunni.index(item1)!=matrix_alunni.index(item2):
                    matrix_alunni[matrix_alunni.index(item2)]=[]
for item in matrix_alunni:
    if len(item)<1:
        matrix_alunni.remove(item)

for item1 in matrix_reduct:
    if len(item1)>1:
        for item2 in matrix_reduct:
            if (len(item2)>1):
                if corrispondence(item1[1], item2[1])==1.0 and matrix_reduct.index(item1)!=matrix_reduct.index(item2):
                    matrix_reduct[matrix_reduct.index(item2)]=[]
for item in matrix_reduct:
    if len(item)<1:
        matrix_reduct.remove(item)
print("End reduction.")

print()

print("Start fusion...")
for item1 in matrix_alunni:
      for item2 in matrix_reduct:
          try:
              if corrispondence(item1[0], item2[1])>=0.96:
                  matrix.append([item1[0],item2[0],"comune",item1[4],"nazione","indirizzo","cap",item1[3],item1[2],item2[2],item2[3],item2[4],"indirizzo_studio",item2[5]])
                  # matrix_alunni[item1]=[]
                  # matrix_reduct[item2]=[]
          except:
              pass

# for item in matrix_alunni:
#     if len(item)<1:
#         matrix_alunni.remove(item)
# for item in matrix_reduct:
#     if len(item)<1:
#         matrix_reduct.remove(item)
#
# with open("error_alunni.csv", "w", newline="") as f:
#     writer = csv.writer(f,delimiter=';')
#     writer.writerows(matrix_alunni)
# with open("error_reduct.csv", "w", newline="") as f:
#     writer = csv.writer(f,delimiter=';')
#     writer.writerows(matrix_reduct)
print("End fusion")

print("Start creating csv...")
with open("output.csv", "w", newline="") as f:
    writer = csv.writer(f,delimiter=';')
    writer.writerows(matrix)
print("The End")
#433