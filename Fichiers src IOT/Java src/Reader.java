package app.appsae;

import org.yaml.snakeyaml.Yaml;

import java.io.*;
import java.util.HashMap;
import java.util.Map;

public class Reader {

    public HashMap<String, String> readerYML(String file){
        HashMap<String, String> dict = new HashMap();
        try {
            FileReader fr = new FileReader("file");
            BufferedReader bfr = new BufferedReader(fr);

            String ligne;
            String[] donnee;

            for(int i=0;i<18;i++){
                ligne = bfr.readLine();
                donnee = ligne.split(":");
                dict.put(donnee[0],donnee[1]);
            }

        }catch (Exception e){
            System.out.println("readerYML(): "+e.getMessage());
            System.exit(1);
        }
        return dict;
    }

    public HashMap<String, String> readerTXT(String pathfile){
        HashMap<String, String> dict = new HashMap();
        try {
            File file = new File(pathfile);
            FileReader fr = new FileReader(file);
            BufferedReader bfr = new BufferedReader(fr);

            String ligne;
            String[] donnee;

            for(int i=0;i<10;i++){
                ligne = bfr.readLine();
                donnee = ligne.split(";");
                dict.put(donnee[0],donnee[1]);
            }

        }catch (Exception e){
            System.out.println("readerTXT(): "+e.getMessage());
            System.exit(1);
        }
        return dict;
    }

    public Map<String, String> chargerYaml(){
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
        return data;
    }
}
