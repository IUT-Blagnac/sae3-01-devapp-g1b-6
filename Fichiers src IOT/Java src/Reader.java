package app.appsae;

import org.yaml.snakeyaml.Yaml;

import java.io.*;
import java.util.HashMap;
import java.util.Map;

/**
 * Classe permettant de lire les différents fichiers et de charger le fichier de config
 * */
public class Reader {

    /**
     * Méthode qui lit les fichiers txt (co2, temp, hum) et les transforme en HashMap<String, String>
     * */
    public HashMap<String, String> readerTXT(String pathfile){
        //on instancie le HashMap à remplir
        HashMap<String, String> dict = new HashMap<>();
        try {
            //on créé un objet File qui prend comme valeur le fichier indiqué avec le pathfile
            File file = new File(pathfile);
            //On créé un FileReader avec file en paramètre
            FileReader fr = new FileReader(file);
            //On créé finalement un BufferedReader avec le FileReader en paramètre
            BufferedReader bfr = new BufferedReader(fr);

            //on créait des variables qui nous seront utiles
            String ligne;
            String[] donnee;

            //on boucle (ici 10 fois)
            for(int i=0;i<10;i++){
                //on lit la ligne
                ligne = bfr.readLine();
                //on split la ligne en deux avec ; comme séparateur
                donnee = ligne.split(";");
                //on ajoute le résultat dans le dictionnaire
                dict.put(donnee[0],donnee[1]);
            }

        }catch (Exception e){
            System.out.println("readerTXT(): "+e.getMessage());
            System.exit(1);
        }
        //on retourne le HashMap
        return dict;
    }

    /**
     * Méthode qui charge un fichier yaml dans un Map
     * */
    public Map<String, String> chargerYaml(){
        //on créé notre Map qui est null pour l'instant
        Map<String , String> data = null;
        
        try {
            // Créer un parseur de fichier yml
            Yaml yaml = new Yaml();
            // Charger le fichier yml en mémoire
            InputStream inputStream = new FileInputStream(new File("src/main/resources/app/appsae/config.yml"));
            // Parser le fichier yml et récupérer les données dans un Map<String, String>
            data = yaml.load(inputStream);

        }catch (Exception e){
            System.out.println("chargerYaml(): "+e.getMessage());
            System.exit(1);
        }
        //on retourne le map
        return data;
    }
}
