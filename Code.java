import java.util.ArrayList;
import java.util.Scanner;

public class UserData {

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        printPersonalInfo(scanner);
        printProducts(scanner);

        scanner.close();
    }

    public static void printPersonalInfo(Scanner scanner) {
        System.out.print("Enter your name: ");
        String name = scanner.nextLine();

        System.out.print("Enter your age: ");
        int age = Integer.parseInt(scanner.nextLine());

        System.out.print("Enter your major: ");
        String major = scanner.nextLine();

        System.out.println("\nPersonal Information:");
        System.out.println("Name: " + name);
        System.out.println("Age: " + age);
        System.out.println("Major: " + major);
        System.out.println();
    }

    public static void printProducts(Scanner scanner) {
        ArrayList<Product> products = new ArrayList<>();

        System.out.println("Enter 3 products with their prices:");
        for (int i = 0; i < 3; i++) {
            System.out.print("Product " + (i+1) + " name: ");
            String name = scanner.nextLine();

            System.out.print("Product " + (i+1) + " price: ");
            String price = scanner.nextLine();

            products.add(new Product(name, price));
        }

        System.out.println("\nProduct List:");
        for (Product product : products) {
            System.out.println("Product: " + product.name + " — Price: " + product.price);
        }
    }

}

class Product {
    String name;
    String price;

    public Product(String name, String price) {
        this.name = name;
        this.price = price;
    }
}