'''# liste=["Ikram","aya","chaimae","Hasnaa"]
# l=[]
# def ajouter():
#     for i in liste:
#         l.append(i)
#     print(l)
# ajouter()
# # def chercher():
# #     for i in liste:
# #         if i in liste:
# #             print("True")
# #         else:
# #             print("False")
# # chercher()

# def delete(x):
#     if x in liste:
#         liste.remove(x)
#         print(liste)
# y=str(input("Entrez un nom a supprimer:"))
# delete(y)
# def chercher(nom):
#     i=0
#     for x in liste:
#         if x==nom:
#             return i
# y=str(input("Entrez un nom a Rechercher:"))
# chercher()
# def rechercher(nom):
#     position=chercher(l,nom)
#     if position !=-1:
#         print("Exist")
#     else:
#         print("Do't exist")
# rechercher()
# def modifier(nom):
#     position=chercher(l,nom)
#     if position !=-1:
#         value=(input("Entrez un nom"))
#         l[position]=value
# def supprimer(l,nom):
#     position=chercher(l,nom)
#     if position !=-1:
#         l.pop(position)
#         value=(input("Entrez un nom"))
#         l[position]=value
# ===========================================================================Tableaudes objets=======================================================================
class Personne:
    def __init__(self,nom):
        self.nom=nom
    def __str__(self):
       return f"{self.nom}"
p1=Personne("Ikram")
p2=Personne("Aya")
p3=Personne("Chaima")
L=[p1,p2,p3]
for x in L:
    print(x)
p4=Personne("ISGI")
L.append(p4)
print("La personne a ete ajoute")
# ===========================================================================================
class GestionDonnees:
    def __init__(self):
        self.donnees = []

    def ajouter(self, element):
        self.donnees.append(element)

    def supprimer(self, element):
        self.donnees.remove(element)

    def modifier(self, ancien_element, nouveau_element):
        index = self.donnees.index(ancien_element)
        self.donnees[index] = nouveau_element

# Exemple d'utilisation
gestion = GestionDonnees()

# Ajouter des éléments
gestion.ajouter("A")
gestion.ajouter("B")
print("Apres l'ajout:", gestion.donnees)

# Modifier un élément
gestion.modifier("A", "C")
print("Apres la modification:", gestion.donnees)

# Supprimer un élément
gestion.supprimer("C")
print("Apres la suppression:", gestion.donnees)

'''
# *******************************************test de cours *******************************
# ****************************************************************************************
'''l=[p1,p2,p3]
p4=personne("tazi",23)
test=False
for x in l:
    if x.nom ==p4.nom:
        test = True
        break
    else:
        test = False

# affichage
if test==False:
    print("inouvlable")
else:
    print("exist")
'''
class Personne :
    def __init__(self,n,p,a):
        self.nom = n
        self.prenom = p
        self.age = a

    def __str__(self):
        return f"le nom est {self.nom} le pernom est {self.prenom} l'age est {self.age}"

    def __eq__(self,p):
        return isinstance(p,Personne) and self.nom==p.nom

class GestionPersonne :
    def __init__(self):
        self.l = []
    def ajouter(self,p):
        self.l.append(p)

    def afficher(self):
        for x in self.l:
            print(x)

    def chercher(self,p):
        i=0
        for x in self.l:
            if x == p:
                return i
            i += 1
        return -1

if __name__=="__main__":
    p1 = Personne("ayat","mohamed",19)
    p2 = Personne("imad","dine",25)
    p3 = Personne("salah","raougai",18)
    liste = GestionPersonne()
    liste.ajouter(p1)
    liste.ajouter(p2)
    liste.ajouter(p3)

    liste.afficher()


    print(liste.chercher(p1))
    print(liste.chercher(p2))
    print(liste.chercher(p3))