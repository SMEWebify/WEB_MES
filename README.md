# Git
* [télécharger git](https://git-scm.com/download/win)
* choix par défaut
* [ajouter les commandes git au PATH](http://www.computerhope.com/issues/ch000549.htm)

#Commande de versionnement
```bash
# activer ssh
eval $(ssh-agent -s)
# activer la clé (à chaque démarrage de l'ordi)
ssh-add "C:\wamp\SSH\id_rsa_kevin_maison.ppk"
# Enter passphrase for ...
Identity added: C:\wamp\SSH\id_rsa_kevin_maison.ppk (C:\wamp\SSH\id_rsa_kevin_maison.ppk)

# voir l'état du versionnement
git status
# Mettre sur l'étagère TOUTES les modifs
git add -A
# versionner
git commit -m "commentaire"
# pousser sur gitlab
git push
```

## Génération clef SSH
* [doc gitlab](https://gitlab.com/profile/keys)

* [installer la suite puTTy pour windows](http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html) `A Windows installer for everything except PuTTYtel`
* [génération clé SSH](http://www.it-connect.fr/chapitres/authentification-ssh-par-cles/)
  * "generate"
  * adresse e-mail en commentaire `kevin.niglaut@wanadoo.fr`
  * mot de passe
  * enregistré clé publique + clé privée
  * sauvegarder la clé publique dans le profile [gitlab](https://gitlab.com/profile/keys) dans un répertoire SSH c:\wamp\

* définir la variable d'environnement GIT_SSH="C:\Program Files (x86)\PuTTY\plink.exe"
* activer la clé :
  * lancer putty / pageant (icone en bas à droite)
  * clic droit / add key

```bash
# lancer la console git : clic droit explorteur fichiers
# définir l'utilisateur git
git config --global user.email "kevin.niglaut@wanadoo.fr"
git config --global user.name "kevin"


# récuération initiale du code source distant (activer le clé ssh)
git clone git@gitlab.com:billy_boy/ERP.git
```



# Atom
## Installation
* [télécharger Atom](https://atom.io/)
Plugins :
* git-control

## Astuces
astuces markdown
* `shift + ctrl + m` => ouvrir en mode markdown
* `shift + ctrl + d` => dupliquer une ligne
* `shift + ctrl + k` => supprimer une ligne
astuces de code
* `ctrl + up` / down => déplacement ligne(s)
* (dés)indenter => `(shift) + tab`

```xml
<toto>
    <tata>hods</tata>
</toto>
```
