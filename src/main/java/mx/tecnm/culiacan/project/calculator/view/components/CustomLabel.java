package mx.tecnm.culiacan.project.calculator.view.components;

import javax.swing.JLabel;
import java.awt.Font;

public class CustomLabel extends JLabel {

    public CustomLabel(String text){
        super(text);
        setFont(new Font("Arial", Font.BOLD, 20));
    }
}
