package mx.tecnm.culiacan.project.calculator.model;

import jakarta.persistence.EntityManager;
import jakarta.persistence.EntityManagerFactory;
import jakarta.persistence.Persistence;
import jakarta.persistence.TypedQuery;
import jakarta.persistence.PersistenceException;
import jakarta.persistence.EntityTransaction;

public class CalculatorRepository {
    private static EntityManagerFactory emf;
    private static EntityManager em;

    public CalculatorRepository() {
        emf = Persistence.createEntityManagerFactory("objectdb:db/operation.odb");
        em = emf.createEntityManager();
    }

    public Operation searchObject(String operation, int value) {
        try {
            TypedQuery<Operation> query = em.createQuery(
                    "SELECT o FROM Operation o WHERE o.operation = :operation AND o.value = :value",
                    Operation.class
            );
            query.setParameter("operation", operation);
            query.setParameter("value", value);
            return query.getSingleResult();
        } catch (PersistenceException e) {return null;}
    }

    public void saveObject(Operation op) {
        EntityTransaction et = em.getTransaction();
        try {
            et.begin();
            em.persist(op);
            et.commit();
        } catch (PersistenceException e) {
            if (et.isActive()) et.rollback();
        }
    }

    public static void closeConnection() {
        if (em != null && em.isOpen()) {
            em.close();
        }
        if (emf != null && emf.isOpen()) {
            emf.close();
        }
    }
}