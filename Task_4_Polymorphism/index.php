<?php
class Animal {
    public function makeSound() {
        echo "This animal makes a sound.<br>";
    }
}

class Dog extends Animal {
    public function makeSound(): void {
        echo "Dog Days: Dog barks.<br>";
    }
}

class Cat extends Animal {
    public function makeSound(): void {
        echo "Cat says: Meow.<br>";
    }
}

function animalSound(Animal $animal) {
    $animal->makeSound(); 
}


$dog = new Dog();
$cat = new Cat();
$number = new Animal();

animalSound($dog);  
animalSound($cat);  
animalSound($number);  
?>
