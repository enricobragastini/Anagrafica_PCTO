import csv
from difflib import SequenceMatcher
from opencage.geocoder import OpenCageGeocode

COUNT=1

indirizzi = ["Informatica", "Telecomunicazioni", "Elettronica", "Logistica", "Costruzione del mezzo"]
mansioni = ["FABLAB", "LOG01", "CML01", "CML03", "ELE01", "ELE02", "ELE03", "ELE05", "ELE07", "ELE08", "ELE10",
            "ELN02", "ELN05",
            "INF01", "INF02", "INF03", "INF04", "INF05", "INF06", "INF07", "INF08", "LOG03", "LOG04", "LOG05",
            "LOG06", "TLC02",
            "TLC03", "TLC06", "TLC07", "TLC08"]


##-- METODO PER CONTROLLARE LA PERCENTUALE DI CORRISPONDENZA
def corrispondence(ragione1, ragione2):
    return SequenceMatcher(None, ragione1, ragione2).ratio()


##-- METODO PER NORMALIZZARE GLI INDIRIZZI E AVERE IL LORO ID
def indirizzo(string):
    string = string[string.find(".") + 2:].lower()
    for item in indirizzi:
        if corrispondence(string, item) >= 0.6:
            return indirizzi.index(item) + 1
    return "NULL"


##-- METODO PER FORMALIZZARE LA MANSIONE
def mansione(string):
    string = string[:5]
    for item in mansioni:
        if item == string:
            return item
    return "NULL"

def getCOOR(via,comune,provincia,cap,nazione):
    geocoder = OpenCageGeocode('25f82a3206364b1aa3e59436abe00ce2')
    result= geocoder.geocode((via if via != None else "") +", "+(comune if comune !=None else "") +", "+(provincia if provincia !=None else "")+", "+(cap if cap !=None else "")+", "+(nazione if nazione !=None else ""))
    return [result[0]['geometry']['lat'], result[0]['geometry']['lng']]



def etlDictGen(file1, file2):
    matrix1 = []  ##- MATRICE CONTENENTE TUTTE LE RIGHE DEL PRIMO CSV (quello degli alunni)
    matrix2 = []  ##- MATRICE CONTENENTE TUTTE LE RIGHE DEL SECONDO CSV (quello delle aziende)
    matrix3 = []  ##- MATRICE CONTENENTE TUTTI GLI ITEM GIA AGGIUNTI AL DIZIONARIO
    mega_dict = dict()
    global COUNT

    ##-- APRO I FILE E LI CONVERTO IN MATRICI
    with open(file1) as csvfile:
        readCSV = csv.reader(csvfile, delimiter=';')
        for row in readCSV:
            matrix1.append(row)

    with open(file2) as csvfile:
        readCSV = csv.reader(csvfile, delimiter=';')
        for row in readCSV:
            matrix2.append(row)

    ##-- GENERO IL DIZIONARIO
    for item in matrix1:
        if item[0] not in mega_dict.keys():
            mega_dict[item[0]] = {"id": COUNT,
                                  "ragione_sociale": item[0],
                                  "tipo": None,
                                  "comune": None,
                                  "provincia": item[4],
                                  "nazione": None,
                                  "indirizzo": None,
                                  "cap": None,
                                  "latitudine": None,
                                  "longitudine":None,
                                  "telefono": item[3],
                                  "mail": item[2],
                                  "sito": None,
                                  "n_dipendenti": None,
                                  "data_convenzione": None,
                                  "cod_ateco": None,
                                  "indirizzo_studio": [],
                                  "mansione": []
                                  }
            COUNT += 1
        addrToAdd = indirizzo(item[1])
        if addrToAdd not in mega_dict[item[0]]["indirizzo_studio"]:
            mega_dict[item[0]]["indirizzo_studio"].append(addrToAdd)

        manToAdd = mansione(item[6])
        if manToAdd not in mega_dict[item[0]]["mansione"]:
            mega_dict[item[0]]["mansione"].append(manToAdd)

    ##-- RIEMPIO IL DIZIONARIO CON I CAMPI PRESENTI SOLO NEL SECONDO CSV
    for keys, values in mega_dict.items():
        for item in matrix2:
            if corrispondence(keys, item[2]) >= 0.96:
                mega_dict[keys]["tipo"] = item[1]
                mega_dict[keys]["comune"] = item[3]
                mega_dict[keys]["nazione"] = item[5]
                mega_dict[keys]["indirizzo"] = item[6]
                mega_dict[keys]["cap"] = item[7]
                mega_dict[keys]["sito"] = item[10]
                mega_dict[keys]["n_dipendenti"] = int(item[11]) if item[11] != "" else None
                mega_dict[keys]["data_convenzione"] = item[12][6:] + "-" + item[12][3:5] + "-" + item[12][:2] if \
                    item[12] != "" else None
                mega_dict[keys]["cod_ateco"] = item[14]

                ##-- RIEMPIO LA TERZA MATRICE CON GLI ELEMENTI GIA INSERITI NEL DIZIONARIO
                if item not in matrix3:
                    matrix3.append(item)
    ##-- RIMUOVO DALLA SECONDA MATRICE GLI ELEMENTI GIA INSERITI NEL DIZIONARIO
    for item in matrix3:
        matrix2.remove(item)
    ##-- CREO UN FILE CON GLI ELEMENTI NON INSERITI NEL DIZIONARIO
    with open("output.csv", "w", newline="") as f:
        writer = csv.writer(f, delimiter=';')
        writer.writerows(matrix3)

    return mega_dict


def dictFiller(megaDict, csvFile):
    matrix = []  ##- MATRICE CONTENENTE TUTTE LE RIGHE DEL CSV (quello degli "errori")
    itemToDel = []  ##- MATRICE CONTENENTE TUTTI GLI ELEMENTI DA ELIMINARE

    global COUNT

    ##-- APRO IL FILE E LO CONVERTO IN MATRICE
    with open(csvFile) as csvfile:
        readCSV = csv.reader(csvfile, delimiter=';')
        for row in readCSV:
            matrix.append(row)

    ##-- SCORRO LA MATRICE E CONTROLLO CHE GLI ELEMENTI NON SIANO GIA PRESENTI NEL DIZIONARIO
    for item in matrix:
        for keys, values in megaDict.items():
            if corrispondence(item[2], keys) >= 0.85:
                if item not in itemToDel:
                    itemToDel.append(item)

    ##-- RIMUOVO DALLA SECONDA MATRICE GLI ELEMENTI GIA INSERITI NEL DIZIONARIO
    if len(itemToDel)>=0:
        for item in itemToDel:
            matrix.remove(item)

    ##-- RIEMPIO LA MATRICE
    for item in matrix:
        if item[0] not in megaDict.keys():
            megaDict[item[2]] = {"id": COUNT,
                                 "ragione_sociale": item[2],
                                 "tipo": item[1],
                                 "comune": item[3],
                                 "provincia": None,
                                 "nazione": item[5],
                                 "indirizzo": item[6],
                                 "cap": item[7],
                                 "latitudine": None,
                                 "longitudine": None,
                                 "telefono": None,
                                 "mail": None,
                                 "sito": item[10],
                                 "n_dipendenti": int(item[11]) if item[11] != "" else None,
                                 "data_convenzione": item[12][6:] + "-" + item[12][3:5] + "-" + item[12][:2] if \
                                     item[12] != "" else None,
                                 "cod_ateco": item[14],
                                 "indirizzo_studio": [],
                                 "mansione": []
                                 }
            COUNT+=1
    return megaDict
##-- GENERO LE COORDINATE
def coorGenerator(megaDict):
    for keys, values in megaDict.items():
        try:
            coor=getCOOR(megaDict[keys]["indirizzo"],megaDict[keys]["comune"],megaDict[keys]["provincia"],megaDict[keys]["cap"],megaDict[keys]["nazione"])
            megaDict[keys]["latitudine"]=coor[0]
            megaDict[keys]["longitudine"]=coor[1]
        except:
            pass

def tryToGen(megaDict):
    pass

def dictToSQL(megaDict):

    ##-- CREO UN FILE aziende.sql CON LE QUERY PER POPOLARE IL DATABASE AZIENDE
    query = "INSERT INTO aziende (id, ragione_sociale, tipo, comune, provincia, nazione, indirizzo, cap, latitudine, longitudine, telefono, " \
            "mail, sito, n_dipendenti, data_convenzione, cod_ateco) VALUES ({});\n"
    with open("aziende.sql","w") as aziendeSql:
        for keys, values in megaDict.items():
            queryValues = ""
            for key, value in values.items():
                try:
                    if value != None and value != "" and not isinstance(value, list):
                        if isinstance(value, int):
                            queryValues = queryValues + '' + str(value) + '' + ", "
                        else:
                            queryValues = queryValues + '"' + str(value) + '"' + ", "
                    elif not isinstance(value, list):
                        queryValues = queryValues + "NULL" + ", "
                except:
                    pass
            aziendeSql.write(query.format(queryValues.rstrip(", ")))

    ##-- CREO UN FILE indirizzi.sql CON LE QUERY PER POPOLARE IL DATABASE INDIRIZZI
    query = "INSERT INTO indirizzi_richiesti (id_azienda, id_indirizzo) VALUES ({});\n"
    with open("indirizzi.sql", "w") as indirizziSql:
        for keys in megaDict.keys():
            queryValues = ""
            if len(megaDict[keys]["indirizzo_studio"])>0 or megaDict[keys]["id"]==None:
                for item in megaDict[keys]["indirizzo_studio"]:
                    queryValues = "" + str(megaDict[keys]["id"]) + ", " + "" + str(item) + ""
                    indirizziSql.write(query.format(queryValues))
                    queryValues = ""

    ##-- CREO UN FILE qualifiche.sql CON LE QUERY PER POPOLARE IL DATABASE MANSIONI
    query = "INSERT INTO qualifiche (id_azienda, id_mansione) VALUES ({});\n"
    with open("qualifiche.sql", "w") as qualificheSql:
        for keys in megaDict.keys():
            queryValues = ""
            if len(megaDict[keys]["mansione"]) > 0 or megaDict[keys]["id"]==None:
                for item in megaDict[keys]["mansione"]:
                    if value != None and value != "":
                        queryValues = "" + str(megaDict[keys]["id"]) + ", " + "'" + item + "'"
                        qualificheSql.write(query.format(queryValues))
                    else:
                        queryValues = "" + str(megaDict[keys]["id"]) + ", " + "'" + "NULL" + "'"
                        qualificheSql.write(query.format(queryValues))
                    queryValues = ""

if __name__ == '__main__':
    ##-- genero il dizionario
    print("Inizio parte 1...")
    megaDict=etlDictGen("alunni.csv", "aziende.csv")
    print("Fine parte 1.")

    ##-- riempio il dizionario con le aziende scartate nella prima parte
    print("Inizio parte 2...")
    megaDict=dictFiller(megaDict, "aziende.csv")
    print("Fine parte 2.")

    ##-- inserisco le coordinate nel dizionario
    print("Inizio parte 3...")
    coorGenerator(megaDict)
    print("Fine parte 3.")

    ##--genero i file .sql contenenti le query per popolare i database
    print("Genero i file...")
    dictToSQL(megaDict)
    print("File generati con successo!")
