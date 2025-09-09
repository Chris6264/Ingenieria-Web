package mx.tecnm.culiacan.project.calculator.controller;

import mx.tecnm.culiacan.project.calculator.model.CalculatorService;
import mx.tecnm.culiacan.project.calculator.model.Operation;
import mx.tecnm.culiacan.project.calculator.view.CalculatorView;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class CalculatorController implements ActionListener {

    private final CalculatorView view;
    private final CalculatorService model;

    public CalculatorController(CalculatorView view, CalculatorService model){
        this.view = view;
        this.model = model;
    }

    @Override
    public void actionPerformed(ActionEvent e) {
        int number = view.getNumber();

        if (e.getSource() == view.getBtnFactorial()) {
            calculate("Factorial",number);
            return;
        }

        if (e.getSource() == view.getBtnFibonacci()) {
            calculate("Fibonacci",number);
            return;
        }

        if (e.getSource() == view.getBtnAckermann()) {
            calculate("Ackermann",number);
            return;
        }

        if (e.getSource() == view.getBtnClean()) {
            view.clean();
        }
    }

    private Operation calculate (String operation, int number){
        Operation op = model.processOperation(operation, number);
        view.setResult(op);
        return op;
    }
}