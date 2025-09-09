package mx.tecnm.culiacan.project.calculator.view.components;

import javax.swing.JButton;
import java.awt.Font;
import java.awt.Color;

public class CustomButton extends JButton {
    public CustomButton(String text){
        super(text);
        setFont(new Font("Arial",Font.BOLD,20));
        setForeground(Color.WHITE);
        setBackground(Color.BLACK);
    }
}
