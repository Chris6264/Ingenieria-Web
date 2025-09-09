package mx.tecnm.culiacan.project.calculator.model;

public class CalculatorService {

    private final CalculatorRepository db;

    public CalculatorService(){
        db = new CalculatorRepository();
    }

    private int calculateFactorial(int number){
        if(number == 0) return 1;
        return number * calculateFactorial(number - 1);
    }

    private int calculateFibonacci(int number){
        if(number == 0) return 0;
        if(number == 1) return 1;
        return calculateFibonacci(number - 1) + calculateFibonacci(number - 2);
    }

    private int calculateAckermann(int m, int n){
        if(m == 0) return n + 1;
        if(n == 0) return calculateAckermann(m - 1, 1);
        return calculateAckermann(m - 1, calculateAckermann(m, n - 1));
    }

    public Operation processOperation(String operation, int number){
        Operation op = db.searchObject(operation, number);

        if(op != null){
            return op;
        }

        op = switch(operation){
            case "Factorial" -> new Operation(operation, number, calculateFactorial(number));
            case "Fibonacci" -> new Operation(operation, number, calculateFibonacci(number));
            case "Ackermann" -> new Operation(operation, number, calculateAckermann(1, number));
            default -> null;
        };

        if(op != null){
            db.saveObject(op);
        }

        return op;
    }

    public void closeDatabase(){
        CalculatorRepository.closeConnection();
    }
}