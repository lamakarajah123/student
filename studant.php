<?php

class Student {
    public $student_id;
    public $first_name;
    public $last_name;
    public $gender;
    public $dob;
    public $address;
    public $city;
    public $country;
    public $tel;

    public function __construct($student_id, $first_name, $last_name, $gender, $dob, $address, $city, $country, $tel) {
        $this->student_id = $student_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->gender = $gender;
        $this->dob = $dob;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->tel = $tel;
        }
      }
                include "data.in.php";

             if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (isset($_POST['submit'])) {
              if ($_POST['submit'] == 'View') {
              if (isset($students[$_POST['student_id']])) {
                $student = $students[$_POST['student_id']];
                echo " <fieldset>";
                echo "<legend>Student Profile</legend>";
                echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                echo "Student id: <input type='text' name='student_id' value='" . $student->student_id . "' readonly>";
                echo "<p>First Name: <input type='text' name='first_name' value='" . $student->first_name . "' readonly>";
                echo " Last Name: <input type='text' name='last_name' value='" . $student->last_name . "' readonly></p>";
                echo "<p>Gender: ";
                echo "<input type='radio' name='gender' value='Male' " . ($student->gender === "Male" ? "checked" : "") . " disabled> Male ";
                echo "<input type='radio' name='gender' value='Female' " . ($student->gender === "Female" ? "checked" : "") . " disabled> Female</p>";
                echo "<p>Date of Birth: <input type='text' name='date_of_birth' value='" . $student->dob . "' readonly></p>";
                echo "<p>Address: <input type='text' name='address' value='" . $student->address . "' readonly></p>";
                echo "<p>City: <input type='text' name='City' value='" . $student->city . "' readonly>";
                echo " Country: <input type='text' name='Country' value='" . $student->country . "' readonly></p>";
                echo "<p>Tel: <input type='text' name='tel' value='" . $student->tel . "' readonly></p>";
                echo " </fieldset>";
                echo "</form>";
              } else {
                echo "No student found with the given student_id.";
             }
         
              }      elseif ($_POST['submit'] == 'Insert') {
              $requiredFields = ['student_id', 'first_name', 'last_name', 'dob', 'address', 'city', 'country', 'tel'];
                $isEmptyField = false;

             foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    echo "Error: $field should not be empty.<br>";
                    $isEmptyField = true;
                }
               }

            
             if (empty($_POST['gender'])) {
                echo "Error: Gender should not be empty.<br>";
                $isEmptyField = true;
             }

             if (!$isEmptyField) {
                $student_id = $_POST['student_id'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $dob = $_POST['dob'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $country = $_POST['country'];
                $tel = $_POST['tel'];

                $studentExists = false;

                foreach ($students as $existingStudent) {
                    if ($existingStudent->student_id == $student_id) {
                        $studentExists = true;
                        break;
                    }
                }

                if ($studentExists) {
                    echo "Student with ID $student_id already exists.";
                } else {
                    $new_student = new Student(
                        $student_id,
                        $first_name,
                        $last_name,
                        $gender,
                        $dob,
                        $address,
                        $city,
                        $country,
                        $tel
                    );

                    $students[$student_id] = $new_student;
                    $data_content = "<?php\n\$students = array(\n";

                    foreach ($students as $student) {
                        $data_content .= sprintf(
                            "    '%s' => new Student('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'),\n",
                            $student->student_id,
                            $student->student_id,
                            $student->first_name,
                            $student->last_name,
                            $student->gender,
                            $student->dob,
                            $student->address,
                            $student->city,
                            $student->country,
                            $student->tel
                        );
                    }

                    $data_content .= ");\n\n?>";

                    $data_file = 'data.in.php';
                    file_put_contents($data_file, $data_content);
                    echo "Student with ID $student_id added successfully.";
                  }
             }
          }        elseif ($_POST['submit'] == 'Update') {
                        $student_id = $_POST['student_id'];
                     if(isset($students[$student_id])) {
               
                 $students[$student_id]->first_name = !empty($_POST['first_name']) ? $_POST['first_name'] : $students[$student_id]->first_name;
                 $students[$student_id]->last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : $students[$student_id]->last_name;
                 $students[$student_id]->gender = isset($_POST['gender']) ? $_POST['gender'] : $students[$student_id]->gender;
                 $students[$student_id]->dob = !empty($_POST['dob']) ? $_POST['dob'] : $students[$student_id]->dob;
                 $students[$student_id]->address = !empty($_POST['address']) ? $_POST['address'] : $students[$student_id]->address;
                 $students[$student_id]->city = !empty($_POST['city']) ? $_POST['city'] : $students[$student_id]->city;
                 $students[$student_id]->country = !empty($_POST['country']) ? $_POST['country'] : $students[$student_id]->country;
                 $students[$student_id]->tel = !empty($_POST['tel']) ? $_POST['tel'] : $students[$student_id]->tel;

               
                 $data_content = "<?php\n\$students = array(\n";
                 foreach ($students as $key => $student) {
                    $data_content .= sprintf(
                        "    '%s' => new Student('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'),\n",
                        $key,
                        $student->student_id,
                        $student->first_name,
                        $student->last_name,
                        $student->gender,
                        $student->dob,
                        $student->address,
                        $student->city,
                        $student->country,
                        $student->tel
                    );
                 }
                 $data_content .= ");\n\n?>";

                  $data_file = 'data.in.php';
                 file_put_contents($data_file, $data_content);

                 echo "Student with ID $student_id updated successfully.";
             }      else {
                  echo "No student found with the given student_id: $student_id.";
             }
         }          elseif ($_POST['submit'] == 'Clear') {
                       $_POST = array();
                               }
    }


}
 
?>

<!DOCTYPE html>
<html>

<head>
    <title>  </title>
</head>

<body>
         
    <?php
    if (!isset($_POST['submit']) || ($_POST['submit'] == 'Insert' && isset($students[$_POST['student_id']])))
     {
        ?>
            <fieldset>
                <legend>Student Profile</legend>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        
                    Student ID: <input type="text" name="student_id" value="<?php echo isset($_POST['student_id']) ? $_POST['student_id'] : ''; ?>"><br>
                    <p></p>
                    First Name: <input type="text" name="first_name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>">
                    Last Name: <input type="text" name="last_name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>"><br>
                    <p></p>
                    Gender:
                    <input type="radio" name="gender" value="Male" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Male' ? 'checked' : ''; ?>> Male
                    <input type="radio" name="gender" value="Female" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Female' ? 'checked' : ''; ?>> Female <br>
                    <p></p>
                     Date of Birth: 
                    <input type="text" name="dob" value="<?php echo isset($_POST['dob']) ? date('d/m/Y', strtotime($_POST['dob'])) : ''; ?>" placeholder="dd/mm/yyyy"><br>
                    <p></p>
                    Address: <input type="text" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>"><br>
                    <p></p>
                    City: <input type="text" name="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
                    Country: <input type="text" name="country" value="<?php echo isset($_POST['country']) ? $_POST['country'] : ''; ?>"><br>
                    <p></p>
                    Tel: <input type="text" name="tel" value="<?php echo isset($_POST['tel']) ? $_POST['tel'] : ''; ?>"><br>
                    <p></p>
                    <input type="submit" name="submit" value="View">
                    <input type="submit" name="submit" value="Insert">
                    <input type="submit" name="submit" value="Update">
                    <input type="submit" name="submit" value="Clear">
                </form>
          <?php
        }
        ?>
        </fieldset>
        </body>
        </html>