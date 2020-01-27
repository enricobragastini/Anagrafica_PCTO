import csv
from difflib import SequenceMatcher

matrix_alunni = []
matrix_reduct = []
aziende = []
mega_dict=dict()

indirizzi=["Informatica","Telecomunicazioni","Elettronica","Logistica","Costruzione del mezzo"]
mansioni=["FABLAB","LOG01","CML01","CML03","ELE01","ELE02","ELE03","ELE05","ELE07","ELE08","ELE10","ELN02","ELN05",
          "INF01","INF02","INF03","INF04","INF05","INF06","INF07","INF08","LOG03","LOG04","LOG05","LOG06","TLC02",
          "TLC03","TLC06","TLC07","TLC08"]

aziendeSql=open("aziende.sql","w")
indirizziSql=open("indirizzi.sql","w")
qualificheSql=open("qualifiche.sql","w")

def corrispondence(ragione1, ragione2):
    return SequenceMatcher(None, ragione1, ragione2).ratio()

def indirizzo(string):
    string=string[string.find(".")+2:].lower()
    for item in indirizzi:
        if corrispondence(string,item)>=0.6:
            return indirizzi.index(item)
    return "NULL"
def mansione(string):
    string=string[:5]
    for item in mansioni:
        if item==string:
            return item
    return "NULL"


with open('alunni.csv') as csvfile:
    readCSV = csv.reader(csvfile, delimiter=';')
    for row in readCSV:
        matrix_alunni.append(row)

with open('aziende.csv') as csvfile:
    readCSV = csv.reader(csvfile, delimiter=';')
    for row in readCSV:
        matrix_reduct.append(row)
count=1
for item in matrix_alunni:
    if item[0] not in mega_dict.keys():
        mega_dict[item[0]]={"id":count,
                            "ragione_sociale":item[0],
                            "tipo":None,
                            "comune":None,
                            "provincia":item[4],
                            "nazione":None,
                            "indirizzo" : None,
                            "cap":None,
                            "telefono":item[3],
                            "mail":item[2],
                            "sito":None,
                            "n_dipendenti":None,
                            "data_convenzione":None,
                            "cod_ateco":None,
                            "indirizzo_studio":[],
                            "mansione":[]
                            }
        count+=1
    addrToAdd=indirizzo(item[1])
    if addrToAdd not in mega_dict[item[0]]["indirizzo_studio"]:
        mega_dict[item[0]]["indirizzo_studio"].append(addrToAdd)

    manToAdd=mansione(item[6])
    if manToAdd not in mega_dict[item[0]]["mansione"]:
        mega_dict[item[0]]["mansione"].append(manToAdd)


for keys,values in mega_dict.items():
    for item in matrix_reduct:
        if corrispondence(keys,item[2])>=0.96:
            mega_dict[keys]["tipo"]=item[1]
            mega_dict[keys]["comune"]= item[3]
            mega_dict[keys]["nazione"]= item[5]
            mega_dict[keys]["indirizzo"]=item[6]
            mega_dict[keys]["cap"]= item[7]
            mega_dict[keys]["sito"] = item[10]
            mega_dict[keys]["n_dipendenti"] = item[11]
            mega_dict[keys]["data_convenzione"] = item[12]
            mega_dict[keys]["cod_ateco"] = item[14]

for keys,values in mega_dict.items():
    print("Nome: "+keys)
    for key,value in values.items():
        print("\t"+str(key)+": "+str(value))

# query = "INSERT INTO aziende (id, ragione_sociale, tipo, comune, provincia, nazione, indirizzo, cap, telefono, " \
#                 "mail, sito, n_dipendenti, data_convenzione, cod_ateco) VALUES ({});\n"
#
# for keys,values in mega_dict.items():
#     queryValues = ""
#     for key,value in values.items():
#         try:
#             if value!=None and value!="":
#                 queryValues=queryValues+'"'+value+'"'+", "
#             else:
#                 queryValues = queryValues + "NULL" + ", "
#         except:
#             pass
#     aziendeSql.write(query.format(queryValues.rstrip(", ")))
# aziendeSql.close()
#
query = "INSERT INTO indirizzi_richiesti (id_azienda, id_indirizzo) VALUES ({});\n"

for keys in mega_dict.keys():
    queryValues = ""
    for item in mega_dict[keys]["indirizzo_studio"]:
        queryValues="'"+str(mega_dict[keys]["id"])+"', "+"'"+str(item)+"'"
        indirizziSql.write(query.format(queryValues))
        queryValues = ""
indirizziSql.close()

query = "INSERT INTO qualifiche (id_azienda, id_mansione) VALUES ({});\n"

for keys in mega_dict.keys():
    queryValues = ""
    for item in mega_dict[keys]["mansione"]:
        if value != None and value != "":
            queryValues="'"+str(mega_dict[keys]["id"])+"', "+"'"+item+"'"
            qualificheSql.write(query.format(queryValues))
        else:
            queryValues = "'" + str(mega_dict[keys]["id"]) + "', " + "'" + "NULL" + "'"
            qualificheSql.write(query.format(queryValues))
        queryValues = ""
qualificheSql.close()
