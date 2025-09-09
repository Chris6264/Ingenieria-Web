package mx.tecnm.culiacan.project.calculator.view.components;

import javax.swing.JTextField;
import java.awt.Font;
import java.awt.Dimension;

public class CustomTextField extends JTextField {

    public CustomTextField(){
        super();
        setFont(new Font("Arial", Font.BOLD, 30));
        setPreferredSize(new Dimension(200,70));
    }
}
