<?php
    session_start();
    if (isset($_SESSION["user"])){
        header("Location: login.php");
        exit();
    }

    if(isset($_POST["submit"])) {
        $last_name = $_POST["last_name"];
        $first_name = $_POST["first_name"];
        $lot_blk = $_POST['lot_blk'];
        $street = $_POST['street'];
        $phase_subdivision = $_POST['phase_subdivision'];
        $barangay = $_POST['barangay'];
        $country = $_POST['country'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $contact_number = $_POST["contact_number"];        
        $email = $_POST["email"];
        $password = $_POST["password"];
        $repeat_password = $_POST["repeat_password"];
        

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();
        if (empty($first_name) || empty($last_name) || empty($lot_blk) || empty($street) || empty($phase_subdivision) || empty($barangay)|| empty($country) || empty($state) || empty($city)|| empty($contact_number) || empty($email) || empty($password)) {
            echo "Debug: Empty fields detected: ";
            if(empty($first_name)) echo "first_name ";
            if(empty($last_name)) echo "last_name ";
            if(empty($lot_blk)) echo "lot_blk ";
            if(empty($street)) echo "street ";
            if(empty($phase_subdivision)) echo "phase_subdivision ";
            if(empty($barangay)) echo "barangay ";
            if(empty($country)) echo "country ";
            if(empty($state)) echo "state ";
            if(empty($city)) echo "city ";
            if(empty($contact_number)) echo "contact_number ";
            if(empty($email)) echo "email ";
            if(empty($password)) echo "password ";
            exit(); // stop execution to debug
        }
        

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
        }

        if(strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters long");
        }

        if($password != $repeat_password){
            array_push($errors, "Password does not match");
        }

        require_once "database.php";
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if($rowCount > 0){
            array_push($errors,"Email Already Exists.");
        }

        if (count($errors) > 0){
            foreach($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            require_once("database.php");
            $sql = "INSERT INTO user (first_name, last_name, email, password, contact_number, country, state, city, lot_blk, street, phase_subdivision, barangay) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);
            if ($preparestmt) {
                mysqli_stmt_bind_param($stmt, "ssssisssssss", $first_name, $last_name, $email, $passwordHash, $contact_number, $country, $state, $city, $lot_blk, $street, $phase_subdivision, $barangay);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are Registered Successfully!</div>";
            } else {
                die("Something went wrong");
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <!-- header -->
    <header> 
        <h2 class="logo"> <i> Jenny </i> </h2>
        <nav class="navigation">
            <a href="login.php"> Home </a>
            <a href="login.php"> About </a>
            <a href="registration.php"> Gallery </a>
            <a href="registration.php"> Contact </a>
            <a href="registration.php"> Feedback </a>
            
        </nav>
    </header>




    <!-- register -->
    <div class="form-box register">

        <h2> <b> Registration </b> </h2>
        <form action="registration.php" method="post">
            <div class="input-box">
                <input type="text" id="first_name" name="first_name" required>
                <label>Firstname</label>
            </div>
            <div class="input-box">
                <input type="text" id="last_name" name="last_name" required>
                <label>Lastname</label>
            </div>

            <div class="row mb-3">
                <div class="col">
                <label>Address:</label> 
                    <div class="input-box">
                    <input type="text"  id="lot_blk" name="lot_blk" placeholder="Blk. Lot">
                </div>
                <div class="input-box">
                    <input type="text"  id="street" name="street" placeholder="Street">
                </div>
                <div class="input-box">
                    <input type="text"  id="phase_subdivision" name="phase_subdivision" placeholder="Subdivision">
                </div>
                <div class="input-box">
                    <input type="text"  id="barangay" name="barangay" placeholder="Barangay">
                </div>
                </div>
                <div class="dropdown">
                    <label for="country" class="form-label">Country:</label>
                    <select class="form-control" id="country" class="form-select" name="country" required>
                        <option selected>Choose...</option>
                    </select>
                </div>
                <div class="dropdown">
                    <label for="province" class="form-label">Province:</label>
                    <select class="form-control" id="state" class="form-select" name="state" required>
                        <option selected>Choose...</option>
                    </select>
                </div>
                <div class="dropdown">
                    <label for="city" class="form-label">City:</label>
                    <select class="form-control" id="city" class="form-select" name="city" >
                        <option selected>Choose...</option>
                    </select>
                </div>

                <div class="dropdown">
                    <label for="contact" class="form-label">Contact Number:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="phoneCode" readonly>
                        <input type="text" class="form-control" id="contactNumber" name="contact_number" placeholder="Enter Contact Number">
                    </div>
                        </div>

            <div class="input-box">
                <input type="email" id="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password">
                <label>Password</label>
            </div>
            <div class="input-box">
                <input type="password" id="repeat_password" name="repeat_password" required>
                <label>Repeat password</label>
            </div>
            <button type="submit" class="btn" name="submit">Register</button>
            <div class="login-register">
                <p>Already have an account?
                    <a href="login.php" class="login-link">Login</a>
                </p>
            </div>
            </form>
            </div>
    </div>
</div>


<script src="script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>

let data = [];

document.addEventListener('DOMContentLoaded', function() {
    fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries%2Bstates%2Bcities.json')
        .then(response => response.json())
        .then(jsonData => {
            data = jsonData;
            const countries = data.map(country => country.name);
            populateDropdown('country', countries);
        })
        .catch(error => console.error('Error fetching countries:', error));
});

function populateDropdown(dropdownId, data) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.innerHTML = '';
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item;
        option.text = item;
        dropdown.add(option);
    });
}

document.getElementById('country').addEventListener('change', function() {
    const selectedCountry = this.value;
    const countryData = data.find(country => country.name === selectedCountry);
    if (countryData && countryData.states) {
        const states = countryData.states.map(state => state.name);
        populateDropdown('state', states);
    }
    const phoneCode = countryData ? countryData.phone_code : '';
    document.getElementById('phoneCode').value = phoneCode;
});

document.getElementById('state').addEventListener('change', function() {
    const selectedState = this.value;
    const countryData = data.find(country => country.name === document.getElementById('country').value);
    if (countryData) {
        const stateData = countryData.states.find(state => state.name === selectedState);
        if (stateData && stateData.cities) {
            const cities = stateData.cities.map(city => city.name);
            populateDropdown('city', cities);
        } else {
            console.log('No cities found for state:', selectedState);
        }
    } else {
        console.log('Country data not found for state:', selectedState);
    }
});

</script>
<footer>
    <p>© 2024 Jenny. All rights reserved.</p>
    </footer>
</body>
</html>
