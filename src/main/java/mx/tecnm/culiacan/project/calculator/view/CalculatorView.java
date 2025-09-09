package mx.tecnm.culiacan.project.calculator.view;

import mx.tecnm.culiacan.project.calculator.controller.CalculatorController;
import mx.tecnm.culiacan.project.calculator.model.Operation;
import mx.tecnm.culiacan.project.calculator.view.components.CustomButton;
import mx.tecnm.culiacan.project.calculator.view.components.CustomLabel;
import mx.tecnm.culiacan.project.calculator.view.components.CustomTextField;

import javax.swing.JFrame;
import javax.swing.JPanel;
import java.awt.GridLayout;
import java.awt.BorderLayout;

public class CalculatorView extends JFrame {

    private CustomLabel lblResult;
    private CustomTextField txtNumber;
    private CustomButton btnFactorial, btnFibonacci, btnAckermann, btnClean;

    public CalculatorView(){
        super("Calculadora");
        createInterface();
    }

    private void createInterface(){
        setSize(450,450);
        setLocationRelativeTo(null);
        setDefaultCloseOperation(EXIT_ON_CLOSE);

        JPanel mainPanel = new JPanel(new BorderLayout(40,40));
        JPanel topPanel = new JPanel(new GridLayout(0,2,10,10));
        JPanel bottomPanel = new JPanel(new GridLayout(0,2,20,20));

        CustomLabel lblNumber = new CustomLabel("Número");
        txtNumber = new CustomTextField();
        CustomLabel lblResultLabel = new CustomLabel("Resultado;");
        lblResult = new CustomLabel("");
        btnFactorial = new CustomButton("Factorial");
        btnFibonacci = new CustomButton("Fibonacci");
        btnAckermann = new CustomButton("Ackermann");
        btnClean = new CustomButton("Limpiar");

        topPanel.add(lblNumber);
        topPanel.add(txtNumber);
        topPanel.add(lblResultLabel);
        topPanel.add(lblResult);
        bottomPanel.add(btnFactorial);
        bottomPanel.add(btnFibonacci);
        bottomPanel.add(btnAckermann);
        bottomPanel.add(btnClean);

        mainPanel.add(topPanel, BorderLayout.NORTH);
        mainPanel.add(bottomPanel, BorderLayout.CENTER);

        add(mainPanel);
        setVisible(true);
    }

    public void listener(CalculatorController c){
        btnFactorial.addActionListener(c);
        btnFibonacci.addActionListener(c);
        btnAckermann.addActionListener(c);
        btnClean.addActionListener(c);
    }

    public void clean(){
        txtNumber.setText("");
        lblResult.setText("");
        txtNumber.requestFocus();
    }

    public int getNumber(){
        int result = 0;
        try {
            result = Integer.parseInt(txtNumber.getText());
        } catch (NumberFormatException e) {
            txtNumber.setText("0");
        }
        return result;
    }

    public void setResult(Operation op){
            lblResult.setText(op.getResult()+"");
    }

    public CustomLabel getLblResult() {
        return lblResult;
    }

    public void setLblResult(CustomLabel lblResult) {
        this.lblResult = lblResult;
    }

    public CustomTextField getTxtNumber() {
        return txtNumber;
    }

    public void setTxtNumber(CustomTextField txtNumber) {
        this.txtNumber = txtNumber;
    }

    public CustomButton getBtnFactorial() {
        return btnFactorial;
    }

    public void setBtnFactorial(CustomButton btnFactorial) {
        this.btnFactorial = btnFactorial;
    }

    public CustomButton getBtnFibonacci() {
        return btnFibonacci;
    }

    public void setBtnFibonacci(CustomButton btnFibonacci) {
        this.btnFibonacci = btnFibonacci;
    }

    public CustomButton getBtnAckermann() {
        return btnAckermann;
    }

    public void setBtnAckermann(CustomButton btnAckermann) {
        this.btnAckermann = btnAckermann;
    }

    public CustomButton getBtnClean() {
        return btnClean;
    }

    public void setBtnClean(CustomButton btnClean) {
        this.btnClean = btnClean;
    }
}
