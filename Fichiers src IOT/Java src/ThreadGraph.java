package app.appsae;

import static java.lang.Thread.sleep;

public class ThreadGraph implements Runnable{
    private boolean enCours;
    private AppSAEController ctrl = new AppSAEController();

    public ThreadGraph() {
        this.enCours = true;
    }

    @Override
    public void run() {
        while(enCours){
            try {
                //ctrl.infoChartCO2();
                System.out.println("temp");
                System.out.println("hum");
                sleep(30000);
            }catch(Exception e){
                System.out.println("run(): "+e.getMessage());
                System.exit(1);
            }
        }
    }

    public void stop() {
        this.enCours = false;
    }
}
