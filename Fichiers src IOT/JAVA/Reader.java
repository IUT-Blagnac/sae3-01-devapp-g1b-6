package app.appsae;

import java.io.BufferedReader;
import java.io.FileReader;
import java.util.HashMap;

public class Reader {

    public HashMap<String, String> readerYML(String file){
        HashMap<String, String> dict = new HashMap();
        try {
            FileReader fr = new FileReader("file");
            BufferedReader bfr = new BufferedReader(fr);

            String ligne;
            String[] donnee;

            for(int i=0;i<15;i++){
                ligne = bfr.readLine();
                donnee = ligne.split(":");
                dict.put(donnee[0],donnee[1]);
            }

        }catch (Exception e){
            System.out.println(e.getMessage());
        }
        return dict;
    }
}
