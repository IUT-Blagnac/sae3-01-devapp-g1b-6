package app.appsae;

import javafx.application.Platform;


/**
 * Classe pour le Thread de l'application implémentant Runnable
 * */
public class ThreadMajGraph implements Runnable{
    private boolean enCours;
    private final AppSAEController ctrl;

    /**
     * Constructeur de la classe qui prend on paramètre le controller AppSAEController
     * */
    public ThreadMajGraph(AppSAEController asc) {
        //on récupère le controller
        this.ctrl = asc;
        //on donne True comme valeur ici pour ensuite avoir la possibilité de créer une méthode stop
        this.enCours = true;
    }

    /**
     * Méthode run de notre Thread
     * */
    @Override
    public void run() {
        try {
            //on boucle tant qu'on ne fait pas stop (donc tant que enCours = True)
            while (enCours) {
                //on utilise le Thread graphique Javafx
                Platform.runLater(() -> {
                    //on lance les méthodes qui mettent à jour les graphiques
                    ThreadMajGraph.this.ctrl.majChartCO2();
                    ThreadMajGraph.this.ctrl.majChartTEMP();
                    ThreadMajGraph.this.ctrl.majChartHUM();
                });

                System.out.println("RunBackground");
                try {
                    //on fait dormir le Thread pendant un duré (ici 10 seconde)
                    Thread.sleep(10000);
                } catch (InterruptedException e) {
                    System.out.println("run1(): "+e.getMessage());
                    System.exit(1);
                }
            }
        }catch(Exception e){
            System.out.println("run2(): "+e.getMessage());
            System.exit(1);
        }
    }

    /**
     * Méthode stop qui nous servira à arrêter le Thread
     * */
    public void stop() {
        //on passe la variable à False pour arrêter le Thread
        this.enCours = false;
    }
}
