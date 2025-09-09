package mx.tecnm.culiacan.project;

import mx.tecnm.culiacan.project.calculator.controller.CalculatorController;
import mx.tecnm.culiacan.project.calculator.model.CalculatorService;
import mx.tecnm.culiacan.project.calculator.view.CalculatorView;

import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class AplCalculator {
    public static void main(String[] args) {
        CalculatorView view = new CalculatorView();
        CalculatorService model = new CalculatorService();
        CalculatorController controller = new CalculatorController(view, model);
        view.listener(controller);

        view.addWindowListener(new WindowAdapter() {
            @Override
            public void windowClosing(WindowEvent e){
                model.closeDatabase();
            }
        });
    }
}