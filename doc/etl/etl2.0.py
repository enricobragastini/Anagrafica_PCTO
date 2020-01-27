import csv
from difflib import SequenceMatcher

matrix_alunni = []
matrix_reduct = []
aziende = []
mega_dict=dict()
indirizzi=["Informatica","Telecomunicazioni","Logistica","Elettronica","Costruzione del mezzo"]


def corrispondence(ragione1, ragione2):
    return SequenceMatcher(None, ragione1, ragione2).ratio()

def indirizzo(string):
    string=string[string.find(".")+2:].lower()
    for item in indirizzi:
        if corrispondence(string,item)>=0.6:
            return item
    return None


with open('alunni.csv') as csvfile:
    readCSV = csv.reader(csvfile, delimiter=';')
    for row in readCSV:
        matrix_alunni.append(row)

with open('aziende.csv') as csvfile:
    readCSV = csv.reader(csvfile, delimiter=';')
    for row in readCSV:
        matrix_reduct.append(row)

for item in matrix_alunni:
    if item[0] not in mega_dict.keys():
        mega_dict[item[0]]={"ragione_sociale":item[0],
                            "tipo":None,
                            "comune":None,
                            "provincia":item[4],
                            "nazione":None,
                            "indirizzo" : [],
                            "cap":None,
                            "telefono":item[3],
                            "mail":item[2],
                            "sito":None,
                            "n_dipendenti":None,
                            "data_convenzione":None,
                            "cod_ateco":None,
                            "indirizzo_studio":[]
                            }
    addrToAdd=indirizzo(item[1])
    if addrToAdd not in mega_dict[item[0]]["indirizzo_studio"]:
        mega_dict[item[0]]["indirizzo_studio"].append(addrToAdd)


for keys,values in mega_dict.items():
    for item in matrix_reduct:
        if corrispondence(keys,item[2])>=0.96:
            mega_dict[keys]["tipo"]=item[1]
            mega_dict[keys]["comune"]= item[3]
            mega_dict[keys]["nazione"]= item[5]
            mega_dict[keys]["indirizzo"].append(item[6])
            mega_dict[keys]["cap"]= item[7]
            mega_dict[keys]["sito"] = item[10]
            mega_dict[keys]["n_dipendenti"] = item[11]
            mega_dict[keys]["data_convenzione"] = item[12]
            mega_dict[keys]["cod_ateco"] = item[14]

for keys,values in mega_dict.items():
    print("Nome: "+keys)
    for key,value in values.items():
        print("\t"+str(key)+": "+str(value))
