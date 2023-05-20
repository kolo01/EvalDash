### Ceci est un projet, visant a mettre en place un systeme de controle et de vente de farine pour un entrepot de farine

#TECHNOLOGIE UTILISEE:
  -SYMFONY(PHP)
#EXIGENCES: 
  CONNAISSANCE ASSEZ BASIQUE DU FRAMEWORD
#CONTRAINTES: 
    LIMITE DE TEMPS 
    UTILISATION RATIONNELLE DES RESSOURCES EN NOTRE POSSESSION
#OBJECTIFS:
  REALISER UNE APPLICATION WEB(RESPONSIVE) PERMETTANT UNE GESTION OPTIMALE DES DIFFERENTES TRANSACTIONS DANS L'ENTREPOT
  
#LES DIFFERENTES RELATIONS:
  - UN CLIENT PEUT PASSER UNE OU PLUSIEURS COMMANDES
  - UNE COMMANDE PEUT AVOIR UN OU PLUSIEURS PRODUITS
  - CHAQUE PRODUIT EST FOURNIT PAR UN OU PLUSIEURS FOURNISSEURS(OPTIONNEL SELON LE CAS DE FIGURE)

# CREATION DES TABLES ET LEUR CONTENU
  - Client: nom,prenom,numero,antecedent(somme du)
  - Produit : titre,quantite,prix d'achat(buy),prix de vente(sell),collection<fournisseur>(optionnel)
  - Commande: idClient,Collection<Produit>,prix total,verse,restant,getAntecedent,lieu de livraison(optionnel),
  - Fournisseur(optionnel):nom,prenom,numero,societe
