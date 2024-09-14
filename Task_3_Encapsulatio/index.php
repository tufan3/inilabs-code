<?php
class Employee {
    private $name;
    private $position;
    private $salary; 

    public function __construct($name, $position, $salary) {
        $this->name = $name;
        $this->position = $position;
        $this->setSalary($salary);
    }

    public function getName() {
        return $this->name;
    }

    public function getPosition() {
        return $this->position;
    }

    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        if ($salary > 0) { 
            $this->salary = $salary;
        } else {
            echo "Salary must be a positive value.";
        }
    }

    public function displayEmployeeInfo() {
        echo "Employee: " . $this->getName() . "<br>";
        echo "Position: " . $this->getPosition() . "<br>";
        echo "Salary: " . $this->getSalary() . "<br>";
    }
}

$employee = new Employee("Md Robiul Islam Tufan", "Software Developer", 50000);
$employee->displayEmployeeInfo();

$employee->setSalary(60000);
echo "Updated Salary: " . $employee->getSalary() . "<br>";

$employee->setSalary(-1000);
?>
